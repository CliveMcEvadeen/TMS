<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentPayments extends Model
{
    use HasFactory;

    protected $table = 'rent_payments';

    protected $fillable = [
        'rent_id',
        'amount',  
        'status',
        'due_date',
        'date_paid',
    ];

    public function rent(): BelongsTo
    {
        return $this->belongsTo(Rents::class,'rent_id');
    }

    public function scopeFilter($query, array $filter){
        if(!empty($filter['search'])){
            $query->with(['rent.tenant']) // Eager load the rent and tenant relationships
                ->where(function ($query) use ($filter) {
                    $query->whereHas('rent', function ($q) use ($filter) {
                        $q->whereHas('tenant', function ($qq) use ($filter) {
                            $qq->where('name', 'like', '%' . $filter['search'] . '%');
                        });
                    });
                })
                ->orWhere('amount', 'like', '%' . $filter['search'] . '%')
                ->orWhere('status', 'like', '%' . $filter['search'] . '%')
                ->orWhere('due_date', 'like', '%' . $filter['search'] . '%')
                ->orWhere('date_paid', 'like', '%' . $filter['search'] . '%');
        }

        if(!empty($filter['from_date'])){
            $query->with(['rent.tenant'])
            ->whereBetween('due_date', [$filter['from_date'], $filter['to_date']]);
        }
    }
    
    
}