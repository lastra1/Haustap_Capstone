<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('firebase/firebase-service-account.json'));

        $this->messaging = $factory->createMessaging();
    }

    public function send(string $fcmToken, string $title, string $body, array $data = [])
    {
        try {
            $notification = Notification::create($title, $body);

            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);

            Log::debug("FCM sent successfully to $fcmToken");

        } catch (\Exception $e) {
            Log::error("FCM failed: " . $e->getMessage());
        }
    }
}
