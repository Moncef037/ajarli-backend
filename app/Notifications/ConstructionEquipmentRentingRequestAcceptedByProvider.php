<?php

namespace App\Notifications;

use App\Models\ConstructionEquipmentOrderMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConstructionEquipmentRentingRequestAcceptedByProvider extends Notification
{
    use Queueable;

    protected $match;

    /**
     * Create a new notification instance.
     */
    public function __construct(ConstructionEquipmentOrderMatch $match)
    {
        //
        $this->match = $match;
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
        $providerFullName = $this->match->provider->first_name . ' ' . $this->match->provider->last_name;

        return [
            //
            'match_id' => $this->match->id,
            'message' => $providerFullName . ' has accepted the offer',
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'construction-equipment-renting-request-accepted-by-provider';
    }
}
