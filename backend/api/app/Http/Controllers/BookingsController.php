<?php

namespace App\Http\Controllers;

use App\Support\FileJsonStore;
use App\Services\Firebase\FirestoreClient;
use App\Repositories\Firebase\BookingsRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BookingsController extends BaseController
{
    private function bookingsRepo(): BookingsRepository
    {
        return new BookingsRepository(new FirestoreClient());
    }

    private function returnsStore(): FileJsonStore
    {
        return new FileJsonStore(base_path('storage/data/returns.json'), []);
    }

    public function index(Request $request)
    {
        $items = $this->bookingsRepo()->list();
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function show(string $id)
    {
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        if (!is_array($doc) || empty($doc)) { return response()->json(['success'=>false,'message'=>'Not Found'], 404); }
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $out = [
            'id' => $id,
            'provider_id' => (int)($f['provider_id']['integerValue'] ?? 0),
            'providerUid' => (string)($f['providerUid']['stringValue'] ?? ''),
            'clientUid' => (string)($f['clientUid']['stringValue'] ?? ''),
            'service_name' => (string)($f['service_name']['stringValue'] ?? ''),
            'scheduled_date' => (string)($f['scheduled_date']['stringValue'] ?? ''),
            'scheduled_time' => (string)($f['scheduled_time']['stringValue'] ?? ''),
            'address' => (string)($f['address']['stringValue'] ?? ''),
            'price' => isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
                : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0),
            'status' => (string)($f['status']['stringValue'] ?? 'pending'),
        ];
        return response()->json(['success' => true, 'data' => $out]);
    }

    public function store(Request $request)
    {
        $payload = $request->json()->all();
        $user = $request->attributes->get('auth_user');
        if ($user) {
            $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
            $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
            $payload['clientUid'] = $uid;
        }
        $id = $this->bookingsRepo()->create($payload);
        return response()->json(['success' => true, 'data' => ['id' => $id]]);
    }

    public function cancel(string $id, Request $request)
    {
        $payload = $request->json()->all();
        $reason = isset($payload['reason']) ? (string)$payload['reason'] : '';
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $clientUid = (string)($f['clientUid']['stringValue'] ?? '');
        $user = $request->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        if ($role !== 'admin' && $clientUid !== '' && $clientUid !== $uid) {
            return response()->json(['success' => false, 'message' => 'forbidden'], 403);
        }
        $ok = $this->bookingsRepo()->cancel($id, $reason);
        return response()->json(['success' => $ok]);
    }

    public function updateStatus(string $id, Request $request)
    {
        $payload = $request->json()->all();
        $newStatus = strtolower((string)($payload['status'] ?? ''));
        if ($newStatus === '') { return response()->json(['success'=>false,'message'=>'status required'], 422); }
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $providerUid = (string)($f['providerUid']['stringValue'] ?? '');
        $user = $request->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        if ($role !== 'admin' && $providerUid !== '' && $providerUid !== $uid) {
            return response()->json(['success' => false, 'message' => 'forbidden'], 403);
        }
        $ok = $this->bookingsRepo()->setStatus($id, $newStatus);
        return response()->json(['success' => $ok]);
    }

    public function rate(string $id, Request $request)
    {
        $payload = $request->json()->all();
        $rating = isset($payload['rating']) ? (int)$payload['rating'] : null;
        if (!$rating || $rating < 1 || $rating > 5) { return response()->json(['success'=>false,'message'=>'rating must be 1-5'], 422); }
        $fs = new FirestoreClient();
        $doc = $fs->get('bookings', $id);
        $f = is_array($doc['fields'] ?? null) ? $doc['fields'] : [];
        $clientUid = (string)($f['clientUid']['stringValue'] ?? '');
        $user = $request->attributes->get('auth_user');
        $role = strtolower((string)($user->role ?? ''));
        $uid = preg_replace('/[^a-z0-9]+/i', '-', strtolower($user->email ?: $user->name));
        $uid = trim((string)$uid ?: 'user-' . md5((string)($user->email ?: $user->name)), '-');
        if ($role !== 'admin' && $clientUid !== '' && $clientUid !== $uid) {
            return response()->json(['success' => false, 'message' => 'forbidden'], 403);
        }
        $ok = $this->bookingsRepo()->rate($id, (float)$rating);
        return response()->json(['success' => $ok]);
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
