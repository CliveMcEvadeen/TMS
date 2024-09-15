<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'name',
        'contact_no',
        'email',
        'address',
        'image',
    ];

    public function properties(): HasMany
    {
        return $this->HasMany(Property::class, 'owner_id');
    }

    public function scopeFilter($query, array $filter){
        if(!empty($filter['search'])){
            $query->where('name', 'like', '%' . $filter['search'] . '%')
                ->orWhere('contact_no', 'like', '%' . $filter['search'] . '%')
                ->orWhere('email', 'like', '%' . $filter['search'] . '%')
                ->orWhere('address', 'like', '%' . $filter['search'] . '%');
        }
    }
}