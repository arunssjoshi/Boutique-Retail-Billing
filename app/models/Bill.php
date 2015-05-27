<?php
class Bill extends Eloquent
{

    protected $table = 'bill';

    
    public function saveBillProducts($bill_product_input) 
    {
        DB::table('bill_product')->insert( 
            $bill_product_input
        );
    } 

  
}
