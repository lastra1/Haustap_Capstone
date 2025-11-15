<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationPin;
use App\Models\User;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LocationPinController extends Controller
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
        $type = $request->get('type');
        $active = $request->get('active');
        $public = $request->get('public');

        $query = LocationPin::where('user_id', $user->id);

        if ($type) {
            $query->byType($type);
        }

        if ($active !== null) {
            $query->where('is_active', $active);
        }

        if ($public !== null) {
            $query->where('is_public', $public);
        }

        $pins = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $pins->items(),
            'pagination' => [
                'current_page' => $pins->currentPage(),
                'per_page' => $pins->perPage(),
                'total' => $pins->total(),
                'last_page' => $pins->lastPage()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'type' => 'in:home,work,service,custom',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // If type is 'home' or 'work', ensure only one active pin of that type
        if (in_array($request->type, ['home', 'work'])) {
            LocationPin::where('user_id', $user->id)
                ->where('type', $request->type)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        // Create location pin in MySQL
        $pin = LocationPin::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'type' => $request->get('type', 'custom'),
            'is_active' => $request->get('is_active', true),
            'is_public' => $request->get('is_public', false),
            'metadata' => $request->metadata ?? []
        ]);

        // Sync to Firebase
        $firebasePin = [
            'id' => $pin->id,
            'user_id' => $pin->user_id,
            'title' => $pin->title,
            'description' => $pin->description,
            'latitude' => $pin->latitude,
            'longitude' => $pin->longitude,
            'address' => $pin->address,
            'city' => $pin->city,
            'state' => $pin->state,
            'country' => $pin->country,
            'postal_code' => $pin->postal_code,
            'type' => $pin->type,
            'is_active' => $pin->is_active,
            'is_public' => $pin->is_public,
            'metadata' => $pin->metadata,
            'created_at' => $pin->created_at->toIso8601String(),
            'updated_at' => $pin->updated_at->toIso8601String()
        ];

        $this->firestore->collection('location_pins')
            ->document($pin->id)
            ->set($firebasePin);

        return response()->json([
            'success' => true,
            'message' => 'Location pin created successfully',
            'data' => $pin
        ], 201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $pin = LocationPin::where('user_id', $user->id)->find($id);

        if (!$pin) {
            return response()->json([
                'success' => false,
                'message' => 'Location pin not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pin
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $pin = LocationPin::where('user_id', $user->id)->find($id);

        if (!$pin) {
            return response()->json([
                'success' => false,
                'message' => 'Location pin not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'type' => 'in:home,work,service,custom',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // If changing type to 'home' or 'work', deactivate other pins of that type
        if ($request->has('type') && in_array($request->type, ['home', 'work'])) {
            LocationPin::where('user_id', $user->id)
                ->where('type', $request->type)
                ->where('id', '!=', $pin->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $pin->update($request->only([
            'title', 'description', 'latitude', 'longitude', 'address',
            'city', 'state', 'country', 'postal_code', 'type',
            'is_active', 'is_public', 'metadata'
        ]));

        // Update Firebase
        $firebaseData = array_merge($request->only([
            'title', 'description', 'latitude', 'longitude', 'address',
            'city', 'state', 'country', 'postal_code', 'type',
            'is_active', 'is_public', 'metadata'
        ]), ['updated_at' => $pin->updated_at->toIso8601String()]);

        $this->firestore->collection('location_pins')
            ->document($pin->id)
            ->update($firebaseData);

        return response()->json([
            'success' => true,
            'message' => 'Location pin updated successfully',
            'data' => $pin
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $pin = LocationPin::where('user_id', $user->id)->find($id);

        if (!$pin) {
            return response()->json([
                'success' => false,
                'message' => 'Location pin not found'
            ], 404);
        }

        // Delete from Firebase
        $this->firestore->collection('location_pins')
            ->document($pin->id)
            ->delete();

        $pin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Location pin deleted successfully'
        ]);
    }

    public function nearby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'numeric|min:0.1|max:50', // radius in kilometers
            'type' => 'nullable|string|in:home,work,service,custom'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $radius = $request->get('radius', 10); // default 10km
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $query = LocationPin::active()
            ->where('is_public', true)
            ->nearby($latitude, $longitude, $radius);

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        $pins = $query->get();

        // Calculate distances for each pin
        $pinsWithDistance = $pins->map(function ($pin) use ($latitude, $longitude) {
            $pin->distance = round($pin->calculateDistance($latitude, $longitude), 2);
            return $pin;
        })->sortBy('distance')->values();

        return response()->json([
            'success' => true,
            'data' => $pinsWithDistance,
            'center' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ],
            'radius_km' => $radius
        ]);
    }

    public function geocode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Using a free geocoding service (Nominatim)
        try {
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $request->address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1
            ]);

            if ($response->successful() && !empty($response->json())) {
                $result = $response->json()[0];
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'latitude' => (float) $result['lat'],
                        'longitude' => (float) $result['lon'],
                        'address' => $result['display_name'],
                        'city' => $result['address']['city'] ?? $result['address']['town'] ?? null,
                        'state' => $result['address']['state'] ?? null,
                        'country' => $result['address']['country'] ?? null,
                        'postal_code' => $result['address']['postcode'] ?? null
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Geocoding service error'
            ], 500);
        }
    }

    public function reverseGeocode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $request->latitude,
                'lon' => $request->longitude,
                'format' => 'json',
                'addressdetails' => 1
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'address' => $result['display_name'] ?? null,
                        'city' => $result['address']['city'] ?? $result['address']['town'] ?? null,
                        'state' => $result['address']['state'] ?? null,
                        'country' => $result['address']['country'] ?? null,
                        'postal_code' => $result['address']['postcode'] ?? null
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Location not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reverse geocoding service error'
            ], 500);
        }
    }
}