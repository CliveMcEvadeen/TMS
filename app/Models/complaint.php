<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'complaint_code',
        'room_number',
        'block',
        'location',
        'telephone_number',
        'description',
        'status',
    ];

    // Define the relationship with the Tenant model
    public function tenant()
    {
        return $this->belongsTo(Tenants::class, 'tenant_id');
    }
}
