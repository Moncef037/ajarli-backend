<?php

namespace App\Notifications;

use App\Models\TransportationVehicleOrderMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransportationVehicleRentingRequestPlaced extends Notification
{
    use Queueable;
    protected $match;

    /**
     * Create a new notification instance.
     */
    public function __construct(TransportationVehicleOrderMatch $match)
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
        return [
            //
            'transportation_vehicle_sub_category' => $this->match->transportationVehicle->subCategory->label,
            'transportation_vehicle_sub_category_photo' => $this->match->transportationVehicle->subCategory->photo,
            'transportation_vehicle_brand' => $this->match->transportationVehicle->brand,
            'transportation_vehicle_model' => $this->match->transportationVehicle->model,
            'renter_type' => $this->match->order->user->user_type,
            'transportation_vehicle_region' => $this->match->transportationVehicle->region,
            'transportation_vehicle_city' => $this->match->transportationVehicle->city,
            'order_total_price' => $this->match->total_price,
            'match_id' => $this->match->id,
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'transportation-vehicle-renting-request-placed';
    }
}
