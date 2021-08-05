<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Invoices[]|Collection $invoices
 */
class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
    ];

    protected $dates = [
        'payment_at'
    ];

    /**
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'paymets_id', 'id');
    }

}
