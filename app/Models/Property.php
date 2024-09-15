<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'property_name',
        'location',
        'price',
        'monthly',
        'yearly',
        'status',
        'image',
        'owner_id'
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function rent(): HasOne
    {
        return $this->hasOne(Rents::class);
    }

    public function rents()
    {
        return $this->hasMany(Rents::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Rents::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class);
    }

    public function scopeFilter($query, array $filter){
        if(!empty($filter['search'])){
            $query->with('owner')
                    ->where(function ($query) use ($filter) {
                        $query->whereHas('owner', function ($q) use ($filter) {
                            $q->where('name', 'like', '%' . $filter['search'] . '%');
                        });
                    })
                ->orWhere('property_name', 'like', '%' . $filter['search'] . '%')
                ->orWhere('location', 'like', '%' . $filter['search'] . '%')
                ->orWhere('price', 'like', '%' . $filter['search'] . '%')
                ->orWhere('monthly', 'like', '%' . $filter['search'] . '%')
                ->orWhere('yearly', 'like', '%' . $filter['search'] . '%')
                ->orWhere('status', 'like', '%' . $filter['search'] . '%')
                ->orWhere('price', 'like', '%' . $filter['search'] . '%');
        }
    }
}