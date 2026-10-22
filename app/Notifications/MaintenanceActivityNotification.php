<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MaintenanceActivityNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $maintenanceId,
        public string $status,
        public string $title,
        public string $message,
    ) {}

    /**
     * Get the channels the notification should use.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the serializable data for the database notification.
     *
     * @return array<string, int|string>
     */
    public function toArray(object $notifiable): array
    {
        $url = $notifiable->role === 'admin'
            ? route('admin.maintenance.index', ['status' => $this->status, 'open' => $this->maintenanceId])
            : route('maintenance.index', ['request' => $this->maintenanceId]);

        return [
            'type' => 'maintenance',
            'title' => $this->title,
            'message' => $this->message,
            'url' => $url,
            'icon' => 'fa-wrench',
            'maintenance_id' => $this->maintenanceId,
        ];
    }
}
