<?php

namespace App\Notifications\SalesCrm;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SalesOrderApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param array|object $data
     * @return void
     */
    public function __construct(public array|object $data)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'id' => $this->id,
            'title' => $this->data['title'],
            'subtitle' => $this->data['subtitle'],
            'type' => $this->data['type'],
            'icon' => $this->data['icon'],
        ];
    }
}
