<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

class RetreatRegistration extends Model
{
    protected $fillable = [
        'confirmation_token',
        'couple_name',
        'email',
        'wedding_anniversary',
        'participant_whatsapp',
        'spouse_whatsapp',
        'transport_status',
        'bringing_children',
        'children_ages',
        'expectations',
        'prayer_request',
        'previous_feedback',
        'payment_made',
        'package_key',
        'package_label',
        'package_price',
        'questions',
        'consent_at',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'wedding_anniversary' => 'date',
            'consent_at' => 'datetime',
            'package_price' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'confirmation_token';
    }

    public function packageDetails(): array
    {
        return config("retreat.packages.{$this->package_key}", []);
    }

    public function formattedPackagePrice(): string
    {
        return 'NGN '.number_format($this->package_price);
    }

    public function eventDate(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            config('retreat.event_date'),
            config('retreat.timezone', config('app.timezone'))
        );
    }
}
