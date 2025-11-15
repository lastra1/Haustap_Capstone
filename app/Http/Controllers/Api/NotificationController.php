<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            'projectId' => env('FIREBASE_PROJECT_ID'),
            'keyFilePath' => env('FIREBASE_CREDENTIALS_PATH')
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 20);
        $category = $request->get('category');
        $type = $request->get('type');
        $read = $request->get('read');

        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($category) {
            $query->byCategory($category);
        }

        if ($type) {
            $query->byType($type);
        }

        if ($read !== null) {
            $query->where('is_read', $read);
        }

        $notifications = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $notifications->items(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'last_page' => $notifications->lastPage()
            ],
            'unread_count' => Notification::where('user_id', $user->id)->unread()->count()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'in:info,warning,error,success',
            'category' => 'nullable|string|max:50',
            'related_id' => 'nullable|string|max:100',
            'related_type' => 'nullable|string|max:100',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create notification in MySQL
        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->get('type', 'info'),
            'category' => $request->category,
            'related_id' => $request->related_id,
            'related_type' => $request->related_type,
            'metadata' => $request->metadata ?? []
        ]);

        // Sync to Firebase
        $firebaseNotification = [
            'id' => $notification->id,
            'user_id' => $notification->user_id,
            'title' => $notification->title,
            'message' => $notification->message,
            'type' => $notification->type,
            'category' => $notification->category,
            'related_id' => $notification->related_id,
            'related_type' => $notification->related_type,
            'is_read' => $notification->is_read,
            'read_at' => $notification->read_at?->toIso8601String(),
            'metadata' => $notification->metadata,
            'created_at' => $notification->created_at->toIso8601String(),
            'updated_at' => $notification->updated_at->toIso8601String()
        ];

        $this->firestore->collection('notifications')
            ->document($notification->id)
            ->set($firebaseNotification);

        // Send real-time notification to user
        $this->sendRealtimeNotification($notification);

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
            'data' => $notification
        ], 201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $notification
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->markAsRead();

        // Update Firebase
        $this->firestore->collection('notifications')
            ->document($notification->id)
            ->update([
                ['path' => 'is_read', 'value' => true],
                ['path' => 'read_at', 'value' => $notification->read_at->toIso8601String()]
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => $notification
        ]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        
        $unreadNotifications = Notification::where('user_id', $user->id)
            ->unread()
            ->get();

        foreach ($unreadNotifications as $notification) {
            $notification->markAsRead();
            
            // Update Firebase
            $this->firestore->collection('notifications')
                ->document($notification->id)
                ->update([
                    ['path' => 'is_read', 'value' => true],
                    ['path' => 'read_at', 'value' => $notification->read_at->toIso8601String()]
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'count' => $unreadNotifications->count()
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        // Delete from Firebase
        $this->firestore->collection('notifications')
            ->document($notification->id)
            ->delete();

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    public function destroyAll()
    {
        $user = Auth::user();
        
        // Delete from Firebase
        $notifications = Notification::where('user_id', $user->id)->get();
        foreach ($notifications as $notification) {
            $this->firestore->collection('notifications')
                ->document($notification->id)
                ->delete();
        }

        // Delete from MySQL
        Notification::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications deleted successfully'
        ]);
    }

    public function unreadCount()
    {
        $user = Auth::user();
        $count = Notification::where('user_id', $user->id)->unread()->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    public function sendBulkNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'in:info,warning,error,success',
            'category' => 'nullable|string|max:50',
            'related_id' => 'nullable|string|max:100',
            'related_type' => 'nullable|string|max:100',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $notifications = [];
        foreach ($request->user_ids as $userId) {
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->get('type', 'info'),
                'category' => $request->category,
                'related_id' => $request->related_id,
                'related_type' => $request->related_type,
                'metadata' => $request->metadata ?? []
            ]);

            // Sync to Firebase
            $firebaseNotification = [
                'id' => $notification->id,
                'user_id' => $notification->user_id,
                'title' => $notification->title,
                'message' => $notification->message,
                'type' => $notification->type,
                'category' => $notification->category,
                'is_read' => $notification->is_read,
                'created_at' => $notification->created_at->toIso8601String()
            ];

            $this->firestore->collection('notifications')
                ->document($notification->id)
                ->set($firebaseNotification);

            $notifications[] = $notification;
            $this->sendRealtimeNotification($notification);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk notifications sent successfully',
            'count' => count($notifications)
        ]);
    }

    private function sendRealtimeNotification($notification)
    {
        // This would typically integrate with a real-time service like Pusher, WebSocket, or Firebase Cloud Messaging
        // For now, we'll update the Firebase document to trigger real-time listeners
        $realtimeData = [
            'type' => 'new_notification',
            'notification_id' => $notification->id,
            'user_id' => $notification->user_id,
            'title' => $notification->title,
            'message' => $notification->message,
            'timestamp' => now()->toIso8601String()
        ];

        $this->firestore->collection('realtime_events')
            ->document('user_' . $notification->user_id)
            ->collection('notifications')
            ->document($notification->id)
            ->set($realtimeData);
    }
}