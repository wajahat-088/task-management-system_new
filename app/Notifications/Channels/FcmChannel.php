<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class FcmChannel
{
    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toFcm')) {
            return;
        }

        $data = $notification->toFcm($notifiable);

        $tokens = $notifiable->fcmTokens()->pluck('token');

        if ($tokens->isEmpty()) {
            Log::info("No FCM token for user: {$notifiable->id}");
            return;
        }

        $messaging = Firebase::messaging();

        foreach ($tokens as $token) {
            try {
                // fromArray() naye version mein zyada reliable hai
                $message = CloudMessage::fromArray([
                    'token' => $token,
                    'notification' => [
                        'title' => $data['title'],
                        'body'  => $data['body'],
                    ],
                    'data' => $data['data'] ?? [],
                ]);

                $messaging->send($message);
            } catch (\Throwable $e) {
                Log::error("FCM failed for user {$notifiable->id}: " . $e->getMessage());
            }
        }
    }
}