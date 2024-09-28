<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenants;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'property_id',
        'payment_id',
        'amount',
        'payment_status',
        'approved_at',
        'rejected_at',
        'payment_date',
        'payment_details',
        'user_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenants::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
