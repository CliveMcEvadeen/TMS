<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rents extends Model
{
    use HasFactory;

    protected $table = 'rents';

    protected $fillable = [
        'start_date',
        'end_date',
        'terms',
        'rent_type',
        'payment_method',
        'penalty',
        'discount',
        'deposit',
        'amount',
        'rent',
        'status',
        'notes',
        'property_id',
        'tenants_id',
    ];


    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenants::class,'tenants_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(RentPayments::class,'rent_id');
    }

    public function scopeFilter($query, array $filter){
        if(!empty($filter['search'])){
            $query->with('property:id,property_name','tenant:id,name')
                ->where(function ($query) use ($filter) {
                    $query->whereHas('property', function ($q) use ($filter) {
                        $q->where('property_name', 'like', '%' . $filter['search'] . '%');
                    })->orWhereHas('tenant', function ($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter['search'] . '%');
                    });
                })
                ->orWhere('start_date', 'like', '%' . $filter['search'] . '%')
                ->orWhere('end_date', 'like', '%' . $filter['search'] . '%')
                ->orWhere('rent_type', 'like', '%' . $filter['search'] . '%')
                ->orWhere('discount', 'like', '%' . $filter['search'] . '%')
                ->orWhere('status', 'like', '%' . $filter['search'] . '%')
                ->orWhere('amount', 'like', '%' . $filter['search'] . '%');
        }

        if(!empty($filter['from_date'])){
            $query->with('property:id,property_name','tenant:id,name')
            ->whereBetween('start_date', [$filter['from_date'], $filter['to_date']]);
        }
    }
    
} 