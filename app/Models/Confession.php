<?php

namespace App\Models;

use Database\Factories\ConfessionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confession extends Model
{
    /** @use HasFactory<ConfessionFactory> */
    use HasFactory;

    protected $fillable = [
        'body',
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
     * @param  Builder<Confession>  $query
     * @return Builder<Confession>
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }
}
