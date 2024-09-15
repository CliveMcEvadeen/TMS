<?php 

namespace App\Class;

use App\Models\RentPayments;

class RentPayment{
    

    public function insert_payments($rent_id, $terms, $date, $rent_type, $amount, $discount){
        
        $type = str_replace("ly", "", $rent_type);//remove the ly in monthly and yearly

        $final_amount = $amount;

        if($discount > 0){
            $discounted =  $amount * ($discount/100);
            $final_amount = $amount - $discounted; //calculate the payment per month or year
        }
        
        for($i=0; $i < $terms; $i++){
            $data = [
                'rent_id' => $rent_id,
                'amount' => $final_amount,
                'due_date' => date('Y-m-d', strtotime('+'.($i+1).' '.$type, strtotime($date))),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            RentPayments::insert($data);
        }

    }

    public function update_payments($rent_id, $terms, $date, $rent_type, $amount, $discount){
        
        RentPayments::where('rent_id', $rent_id)->delete(); //delete the old data

        $type = str_replace("ly", "", $rent_type); //remove the ly in monthly and yearly

        $final_amount = $amount;

        if($discount > 0){
            $discounted =  $amount * ($discount/100);
            $final_amount = $amount - $discounted; //calculate the payment per month or year
        }
        
        for($i=0; $i < $terms; $i++){ 
            $data = [
                'rent_id' => $rent_id,
                'amount' => $final_amount,
                'due_date' => date('Y-m-d', strtotime('+'.($i+1).' '.$type, strtotime($date))),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            RentPayments::insert($data);
        }

    }

}


?>