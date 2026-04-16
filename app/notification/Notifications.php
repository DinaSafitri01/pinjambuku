<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NotifikasiPinjam extends Notification
{
    use Queueable;

    protected $notifData;

    /**
     * Create a new notification instance.
     */
    public function __construct($notifData)
    {
        $this->notifData = $notifData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->notifData['title'],
            'message' => $this->notifData['message'],
            'url' => $this->notifData['url'] ?? '#',
            'icon' => $this->notifData['icon'] ?? 'bi-info-circle',
        ];
    }
}
