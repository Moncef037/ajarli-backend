<?php

namespace App\Notifications;

use App\Models\SuccessfullyRentedConstructionVehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConstructionVehicleOrderMatchSettled extends Notification
{
    use Queueable;

    protected $successfulMatch;

    /**
     * Create a new notification instance.
     */
    public function __construct(SuccessfullyRentedConstructionVehicle $successfulMatch)
    {
        //
        $this->successfulMatch = $successfulMatch;
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
        $provider = $this->successfulMatch->match->provider;
        $providerFullName = $provider->first_name . ' ' . $provider->last_name;

        $renter = $this->successfulMatch->match->order->user;
        $renterFullName = $renter->first_name . ' ' . $renter->last_name;
        return [
            //
            'message' => "The construction vehicle renting request has been settled. The provider, $providerFullName, and the renter, $renterFullName, have agreed on the terms of the offer.",
            'successful_match_id' => $this->successfulMatch->id
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'construction-vehicle-order-match-settled';
    }
}
