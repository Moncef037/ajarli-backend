<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'user_type',
        'receive_notifications_from',
        'profile_picture',
    ];

    public function isProvider(): bool
    {
        return $this->user_type === 'provider_individual' || $this->user_type === 'provider_society';
    }

    public function isRenter(): bool
    {
        return $this->user_type === 'renter_individual' || $this->user_type === 'renter_society';
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function Documents()
    {
        return $this->hasMany(Document::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'recipient_id');
    }

    public function givenFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'author_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function constructionVehicleOrders()
    {
        return $this->hasMany(ConstructionVehicleOrder::class);
    }

    public function constructionEquipmentOrders()
    {
        return $this->hasMany(ConstructionEquipmentOrder::class);
    }

    public function constructionAttachmentOrders()
    {
        return $this->hasMany(ConstructionAttachmentOrder::class);
    }

    public function transportationVehicleOrders()
    {
        return $this->hasMany(TransportationVehicleOrder::class);
    }

    public function constructionVehicleOrderMatches()
    {
        return $this->hasMany(ConstructionVehicleOrderMatch::class);
    }

    public function constructionEquipmentOrderMatches()
    {
        return $this->hasMany(ConstructionEquipmentOrderMatch::class);
    }

    public function constructionAttachmentOrderMatches()
    {
        return $this->hasMany(ConstructionAttachmentOrderMatch::class);
    }

    public function transportationVehicleOrderMatches()
    {
        return $this->hasMany(TransportationVehicleOrderMatch::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
