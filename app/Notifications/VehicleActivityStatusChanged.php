<?php

namespace App\Notifications;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleActivityStatusChanged extends Notification
{
    use Queueable;

    protected $vehicle;
    protected $activity_status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Vehicle $vehicle, string $activity_status)
    {
        //
        $this->vehicle = $vehicle;
        $this->activity_status = $activity_status;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'vehicle_id' => $this->vehicle->id,
            'activity_status' => $this->activity_status,
            'message' => 'Vehicle activity status has been changed to ' . $this->activity_status,
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'vehicle-activity-status-changed';
    }
}
