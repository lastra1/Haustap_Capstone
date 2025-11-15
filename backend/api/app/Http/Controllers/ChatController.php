<?php

namespace App\Http\Controllers;

use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ChatController extends BaseController
{
    private function store(): FileJsonStore
    {
        return new FileJsonStore(base_path('storage/data/chat.json'), [
            'conversations' => [],
            'messages' => [],
            'next_msg_id' => 1,
        ]);
    }

    public function open(Request $request)
    {
        $payload = $request->json()->all();
        $booking_id = (int)($payload['booking_id'] ?? 0);
        $client_id = isset($payload['client_id']) ? (int)$payload['client_id'] : null;
        $provider_id = isset($payload['provider_id']) ? (int)$payload['provider_id'] : null;
        if ($booking_id <= 0) { return response()->json(['success'=>false,'message'=>'booking_id required'], 422); }
        $store = $this->store()->read();
        $found = null;
        foreach ($store['conversations'] as $c) {
            if ((int)($c['booking_id'] ?? 0) === $booking_id) { $found = $c; break; }
        }
        if (!$found) {
            $found = [
                'id' => 'booking_' . $booking_id,
                'booking_id' => $booking_id,
                'client_id' => $client_id,
                'provider_id' => $provider_id,
                'opened_at' => round(microtime(true) * 1000)
            ];
            $store['conversations'][] = $found;
            $this->store()->write($store);
        }
        return response()->json(['success'=>true, 'conversation'=>$found]);
    }

    public function listMessages(int $booking_id, Request $request)
    {
        $store = $this->store()->read();
        $since = (int)($request->query('since', 0));
        $messages = array_values(array_filter($store['messages'], function ($m) use ($booking_id, $since) {
            if ((int)($m['booking_id'] ?? 0) !== $booking_id) return false;
            if ($since && (int)($m['ts'] ?? 0) <= $since) return false;
            return true;
        }));
        usort($messages, function ($a, $b) { return ((int)$a['ts']) <=> ((int)$b['ts']); });
        return response()->json(['success'=>true, 'messages'=>$messages]);
    }

    public function sendMessage(int $booking_id, Request $request)
    {
        $payload = $request->json()->all();
        $text = trim((string)($payload['text'] ?? ''));
        $sender = (string)($payload['sender'] ?? 'client');
        $sender_id = isset($payload['sender_id']) ? (int)$payload['sender_id'] : null;
        if ($text === '') { return response()->json(['success'=>false,'message'=>'text required'], 422); }
        $store = $this->store()->read();
        $msg = [
            'id' => (int)($store['next_msg_id'] ?? 1),
            'booking_id' => $booking_id,
            'sender' => $sender,
            'sender_id' => $sender_id,
            'text' => $text,
            'ts' => round(microtime(true) * 1000)
        ];
        $store['messages'][] = $msg;
        $store['next_msg_id'] = (int)($store['next_msg_id'] ?? 1) + 1;
        $this->store()->write($store);
        return response()->json(['success'=>true, 'message'=>$msg]);
    }
}