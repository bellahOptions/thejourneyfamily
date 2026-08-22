<?php

namespace App\Models;

use Database\Factories\ConsultationBookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationBooking extends Model
{
    /** @use HasFactory<ConsultationBookingFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_SCHEDULED = 'scheduled';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'couple_name',
        'whatsapp',
        'email',
        'notes',
        'status',
        'ip_address',
        'user_agent',
    ];
}
