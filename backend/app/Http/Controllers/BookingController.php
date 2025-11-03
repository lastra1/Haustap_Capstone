<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FcmService;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Booking::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'total_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user() ?? $request->user(); // Sanctum auth

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'service_provider_id' => 1, // or dynamic if available
            'booking_date' => $request->booking_date,
            'status' => 'pending',
            'total_amount' => $request->total_amount,
        ]);

         $this->notifyProvider($booking, $user->id);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 201);
    }

    public function notifyProvider($booking, $userId)
    {
        $fcmService = new FcmService();

        $provider = User::where('id', $userId)->first(); // example
        if ($provider && $provider->fcm_token) {
            $fcmService->send(
                $provider->fcm_token,
                'New Booking',
                'You have a new booking!',
                ['booking_id' => $booking->id]
            );
        }
    }

    /**
     * Show a single booking
     */
    public function show($id)
    {
        $booking = Booking::with(['service', 'user'])->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    /**
     * Update booking status (optional)
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->update([
            'status' => $request->status ?? $booking->status,
        ]);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking,
        ]);
    }

    /**
     * Delete a booking (optional)
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
