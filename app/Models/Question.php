<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_FEATURED = 'featured';

    public const STATUS_ANSWERED = 'answered';

    protected $fillable = [
        'body',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'is_hidden' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Question>  $query
     * @return Builder<Question>
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * @param  Builder<Question>  $query
     * @return Builder<Question>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_FEATURED);
    }
}
