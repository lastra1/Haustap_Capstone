<?php

namespace App\Http\Controllers;

use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BookingsController extends BaseController
{
    private function bookingsStore(): FileJsonStore
    {
        return new FileJsonStore(base_path('storage/data/bookings.json'), []);
    }

    private function returnsStore(): FileJsonStore
    {
        return new FileJsonStore(base_path('storage/data/returns.json'), []);
    }

    public function index(Request $request)
    {
        $items = $this->bookingsStore()->read();
        if (!is_array($items)) { $items = []; }
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function show(int $id)
    {
        $items = $this->bookingsStore()->read();
        $found = null;
        if (is_array($items)) {
            foreach ($items as $it) {
                if ((int)($it['id'] ?? 0) === $id) { $found = $it; break; }
            }
        }
        if (!$found) { return response()->json(['success'=>false,'message'=>'Not Found'], 404); }
        return response()->json(['success' => true, 'data' => $found]);
    }

    public function store(Request $request)
    {
        $payload = $request->json()->all();
        $items = $this->bookingsStore()->read();
        if (!is_array($items)) { $items = []; }
        $maxId = 0; foreach ($items as $it) { $iid = (int)($it['id'] ?? 0); if ($iid > $maxId) { $maxId = $iid; } }
        $id = $maxId + 1;
        $nowMs = round(microtime(true) * 1000);
        $booking = [
            'id' => $id,
            'provider_id' => isset($payload['provider_id']) ? (int)$payload['provider_id'] : null,
            'service_name' => isset($payload['service_name']) ? (string)$payload['service_name'] : null,
            'scheduled_date' => isset($payload['scheduled_date']) ? (string)$payload['scheduled_date'] : null,
            'scheduled_time' => isset($payload['scheduled_time']) ? (string)$payload['scheduled_time'] : null,
            'address' => isset($payload['address']) ? (string)$payload['address'] : null,
            'lat' => $payload['lat'] ?? null,
            'lng' => $payload['lng'] ?? null,
            'price' => $payload['price'] ?? null,
            'notes' => isset($payload['notes']) ? (string)$payload['notes'] : null,
            'status' => 'pending',
            'created_at' => $nowMs,
        ];
        $items[] = $booking;
        $this->bookingsStore()->write($items);
        return response()->json(['success' => true, 'id' => $id, 'data' => ['id' => $id, 'booking' => $booking]]);
    }

    public function cancel(int $id, Request $request)
    {
        $payload = $request->json()->all();
        $reason = isset($payload['reason']) ? (string)$payload['reason'] : null;
        $nowMs = round(microtime(true) * 1000);
        $items = $this->bookingsStore()->read();
        $found = false;
        if (is_array($items)) {
            foreach ($items as &$it) {
                if ((int)($it['id'] ?? 0) === $id) {
                    $it['status'] = 'cancelled';
                    if ($reason !== null && $reason !== '') { $it['cancellation_reason'] = $reason; }
                    $it['cancelled_at'] = $nowMs;
                    $found = true; break;
                }
            }
            unset($it);
        }
        if (!$found) { return response()->json(['success'=>false,'message'=>'Booking not found'], 404); }
        $this->bookingsStore()->write($items);
        return response()->json(['success' => true]);
    }

    public function updateStatus(int $id, Request $request)
    {
        $payload = $request->json()->all();
        $newStatus = strtolower((string)($payload['status'] ?? ''));
        if ($newStatus === '') { return response()->json(['success'=>false,'message'=>'status required'], 422); }
        $items = $this->bookingsStore()->read();
        $found = false;
        if (is_array($items)) {
            foreach ($items as &$it) {
                if ((int)($it['id'] ?? 0) === $id) { $it['status'] = $newStatus; $found = true; break; }
            }
            unset($it);
        }
        if (!$found) { return response()->json(['success'=>false,'message'=>'Booking not found'], 404); }
        $this->bookingsStore()->write($items);
        return response()->json(['success' => true]);
    }

    public function rate(int $id, Request $request)
    {
        $payload = $request->json()->all();
        $rating = isset($payload['rating']) ? (int)$payload['rating'] : null;
        if (!$rating || $rating < 1 || $rating > 5) { return response()->json(['success'=>false,'message'=>'rating must be 1-5'], 422); }
        $items = $this->bookingsStore()->read();
        $found = false;
        if (is_array($items)) {
            foreach ($items as &$it) {
                if ((int)($it['id'] ?? 0) === $id) { $it['rating'] = $rating; $found = true; break; }
            }
            unset($it);
        }
        if (!$found) { return response()->json(['success'=>false,'message'=>'Booking not found'], 404); }
        $this->bookingsStore()->write($items);
        return response()->json(['success' => true]);
    }

    public function requestReturn(int $id, Request $request)
    {
        $payload = $request->json()->all();
        $issues = isset($payload['issues']) && is_array($payload['issues']) ? $payload['issues'] : [];
        $notes = isset($payload['notes']) ? (string)$payload['notes'] : '';
        $recs = $this->returnsStore()->read();
        if (!is_array($recs)) { $recs = []; }
        $recs[] = [ 'booking_id' => $id, 'issues' => $issues, 'notes' => $notes, 'ts' => round(microtime(true) * 1000) ];
        $this->returnsStore()->write($recs);
        return response()->json(['success' => true]);
    }

    public function listReturns()
    {
        $recs = $this->returnsStore()->read();
        if (!is_array($recs)) { $recs = []; }
        return response()->json(['success' => true, 'data' => $recs]);
    }
}