<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Services\Firebase\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = app(FirestoreClient::class);
    }

    /**
     * Get user's conversations
     */
    public function getConversations(Request $request)
    {
        try {
            $user = Auth::user();
            $limit = $request->get('limit', 20);
            $page = $request->get('page', 1);

            $conversations = ChatConversation::where('participant1_id', $user->id)
                ->orWhere('participant2_id', $user->id)
                ->with(['participant1', 'participant2', 'lastMessage'])
                ->orderBy('updated_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            // Get unread count for each conversation
            $conversations->getCollection()->transform(function ($conversation) use ($user) {
                $conversation->unread_count = ChatMessage::where('conversation_id', $conversation->id)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->count();
                
                return $conversation;
            });

            return response()->json([
                'success' => true,
                'data' => $conversations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get conversations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new conversation
     */
    public function createConversation(Request $request)
    {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'participant2_id' => 'required|integer|exists:users,id|not_in:' . $user->id,
                'subject' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if conversation already exists
            $existingConversation = ChatConversation::where(function ($query) use ($user, $request) {
                $query->where('participant1_id', $user->id)
                    ->where('participant2_id', $request->participant2_id);
            })->orWhere(function ($query) use ($user, $request) {
                $query->where('participant1_id', $request->participant2_id)
                    ->where('participant2_id', $user->id);
            })->first();

            if ($existingConversation) {
                return response()->json([
                    'success' => true,
                    'message' => 'Conversation already exists',
                    'data' => $existingConversation->load(['participant1', 'participant2'])
                ]);
            }

            // Create new conversation
            $conversation = ChatConversation::create([
                'participant1_id' => $user->id,
                'participant2_id' => $request->participant2_id,
                'subject' => $request->subject ?? 'New Conversation',
                'status' => 'active',
            ]);

            // Create conversation in Firebase
            $firebaseConversation = [
                'id' => $conversation->id,
                'participant1_id' => $user->id,
                'participant2_id' => $request->participant2_id,
                'subject' => $conversation->subject,
                'status' => $conversation->status,
                'created_at' => $conversation->created_at->toIso8601String(),
                'updated_at' => $conversation->updated_at->toIso8601String(),
            ];

            $this->firestore->collection('chat_conversations')->document($conversation->id)->set($firebaseConversation);

            return response()->json([
                'success' => true,
                'message' => 'Conversation created successfully',
                'data' => $conversation->load(['participant1', 'participant2'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create conversation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get messages in a conversation
     */
    public function getMessages(Request $request, $conversationId)
    {
        try {
            $user = Auth::user();
            $limit = $request->get('limit', 50);
            $page = $request->get('page', 1);

            // Verify user is part of the conversation
            $conversation = ChatConversation::where('id', $conversationId)
                ->where(function ($query) use ($user) {
                    $query->where('participant1_id', $user->id)
                        ->orWhere('participant2_id', $user->id);
                })
                ->first();

            if (!$conversation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            $messages = ChatMessage::where('conversation_id', $conversationId)
                ->with(['sender', 'receiver'])
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            // Mark messages as read
            ChatMessage::where('conversation_id', $conversationId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'data' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request, $conversationId)
    {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'content' => 'required|string|max:1000',
                'message_type' => 'nullable|string|in:text,image,file,location',
                'file_url' => 'nullable|string|max:500',
                'file_name' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verify user is part of the conversation
            $conversation = ChatConversation::where('id', $conversationId)
                ->where(function ($query) use ($user) {
                    $query->where('participant1_id', $user->id)
                        ->orWhere('participant2_id', $user->id);
                })
                ->first();

            if (!$conversation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            // Determine receiver
            $receiverId = $conversation->participant1_id === $user->id 
                ? $conversation->participant2_id 
                : $conversation->participant1_id;

            // Create message
            $message = ChatMessage::create([
                'conversation_id' => $conversationId,
                'sender_id' => $user->id,
                'receiver_id' => $receiverId,
                'content' => $request->content,
                'message_type' => $request->message_type ?? 'text',
                'file_url' => $request->file_url,
                'file_name' => $request->file_name,
                'is_read' => false,
                'sent_at' => now(),
            ]);

            // Update conversation last activity
            $conversation->update(['updated_at' => now()]);

            // Create message in Firebase
            $firebaseMessage = [
                'id' => $message->id,
                'conversation_id' => $conversationId,
                'sender_id' => $user->id,
                'receiver_id' => $receiverId,
                'content' => $message->content,
                'message_type' => $message->message_type,
                'file_url' => $message->file_url,
                'file_name' => $message->file_name,
                'is_read' => false,
                'sent_at' => $message->sent_at->toIso8601String(),
                'created_at' => $message->created_at->toIso8601String(),
            ];

            $this->firestore->collection('chat_messages')->document($message->id)->set($firebaseMessage);

            // Update conversation in Firebase
            $this->firestore->collection('chat_conversations')->document($conversationId)->update([
                ['path' => 'updated_at', 'value' => now()->toIso8601String()],
                ['path' => 'last_message_id', 'value' => $message->id],
                ['path' => 'last_message_content', 'value' => $message->content],
                ['path' => 'last_message_sender_id', 'value' => $user->id],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $message->load(['sender', 'receiver'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, $conversationId)
    {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'message_ids' => 'required|array',
                'message_ids.*' => 'integer|exists:chat_messages,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verify user is part of the conversation
            $conversation = ChatConversation::where('id', $conversationId)
                ->where(function ($query) use ($user) {
                    $query->where('participant1_id', $user->id)
                        ->orWhere('participant2_id', $user->id);
                })
                ->first();

            if (!$conversation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            // Mark messages as read
            $updated = ChatMessage::where('conversation_id', $conversationId)
                ->where('receiver_id', $user->id)
                ->whereIn('id', $request->message_ids)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            // Update Firebase for each message
            foreach ($request->message_ids as $messageId) {
                $this->firestore->collection('chat_messages')->document($messageId)->update([
                    ['path' => 'is_read', 'value' => true],
                    ['path' => 'read_at', 'value' => now()->toIso8601String()]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Messages marked as read',
                'data' => ['updated_count' => $updated]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark messages as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a message
     */
    public function deleteMessage(Request $request, $conversationId, $messageId)
    {
        try {
            $user = Auth::user();

            // Verify user is part of the conversation
            $conversation = ChatConversation::where('id', $conversationId)
                ->where(function ($query) use ($user) {
                    $query->where('participant1_id', $user->id)
                        ->orWhere('participant2_id', $user->id);
                })
                ->first();

            if (!$conversation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            $message = ChatMessage::where('id', $messageId)
                ->where('conversation_id', $conversationId)
                ->where('sender_id', $user->id)
                ->first();

            if (!$message) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message not found or access denied'
                ], 404);
            }

            // Soft delete message
            $message->update(['deleted_at' => now()]);

            // Update Firebase
            $this->firestore->collection('chat_messages')->document($messageId)->update([
                ['path' => 'deleted_at', 'value' => now()->toIso8601String()],
                ['path' => 'content', 'value' => 'This message was deleted'],
                ['path' => 'message_type', 'value' => 'deleted'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount(Request $request)
    {
        try {
            $user = Auth::user();

            $unreadCount = ChatMessage::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'unread_count' => $unreadCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get unread count',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}