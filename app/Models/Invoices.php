<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoices extends Model
{
    use HasFactory;


    public function payments(): BelongsTo
    {
        return $this->belongsTo(Payments::class, 'payments_id', 'id');
    }
}
