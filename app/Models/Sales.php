<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'status',
        'payment_method',
        'amount',
        'transaction_date',
        'notes',
        'property_id',
        'tenant_id',
        'rent_payment_id'
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenants::class,'tenant_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(RentPayments::class,'rent_payment_id');
    }


    public function scopeFilter($query, array $filter){
        if(!empty($filter['search'])){
            $query->with('property:id,property_name','tenant:id,name','payment')
                ->where(function ($query) use ($filter) {
                    $query->whereHas('property', function ($q) use ($filter) {
                        $q->where('property_name', 'like', '%' . $filter['search'] . '%');
                    })->orWhereHas('tenant', function ($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter['search'] . '%');
                    });
                })
                ->orWhere('transaction_date', 'like', '%' . $filter['search'] . '%')
                ->orWhere('amount', 'like', '%' . $filter['search'] . '%');
            if($filter['search'] == 'done'){
                $query->orWhere('status', 'like', '%1%');
            }
        }

        if(!empty($filter['from_date'])){
            $query->with('property:id,property_name','tenant:id,name','payment')
            ->whereBetween('transaction_date', [$filter['from_date'], $filter['to_date']]);
        }
    }


    public static function get_this_year_sales(){
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $query = static::selectRaw('SUM(amount) AS total_amount')
                ->whereMonth('transaction_date',$month)
                ->whereYear('transaction_date', date('Y'));
            
            $monthlyData[] = $query->pluck('total_amount')->first() ?? 0;
        }
        return $monthlyData;
    }
    
    public static function get_previous_year_sales(){
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $query = static::selectRaw('SUM(amount) AS total_amount')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', date('Y')-1);
               
                
            $monthlyData[] = $query->pluck('total_amount')->first() ?? 0;
        }
        return $monthlyData;
    }
    
    
}