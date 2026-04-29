<?php

namespace App\Notifications;

use App\Models\ConstructionEquipmentOrderMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConstructionEquipmentRentingRequestPlaced extends Notification
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
        return [
            //
            'construction_equipment_sub_category' => $this->match->constructionEquipment->subCategory->label,
            'construction_equipment_sub_category_photo' => $this->match->constructionEquipment->subCategory->photo,
            'construction_equipment_brand' => $this->match->constructionEquipment->brand,
            'construction_equipment_model' => $this->match->constructionEquipment->model,
            'renter_type' => $this->match->order->user->user_type,
            'construction_equipment_region' => $this->match->constructionEquipment->region,
            'construction_equipment_city' => $this->match->constructionEquipment->city,
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
        return 'construction-equipment-renting-request-placed';
    }
}
