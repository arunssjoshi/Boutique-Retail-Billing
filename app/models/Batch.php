<?php
class Batch extends Eloquent
{

    protected $table = 'batch';

    public function getBatchDetails($filter=array())
    {

        $sortColumns =   array('0'=>'b.batch','1'=>'s.shop', '2'=>'s.city', '3'=>'b.purchased_on');

        $subQuery    =   (isset($filter['batchId'] ) && $filter['batchId'] > 0)? " AND b.id = ".$filter['batchId']:"";
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (b.batch LIKE '".$filter['search']."%' OR 
                                                            s.city LIKE '".$filter['search']."%' OR s.shop LIKE '".$filter['search']."%')":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   $sortColumns[$filter['sortField']];
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' ASC';

        $query =    "SELECT SQL_CALC_FOUND_ROWS  b.id, b.batch, b.purchased_on, b.description, GROUP_CONCAT(s.shop SEPARATOR ', ') AS shops, s.city
                    FROM batch b
                    LEFT JOIN batch_shops bs ON b.id=bs.batch_id 
                    LEFT JOIN shop s ON bs.shop_id=s.id 
                    WHERE b.status='Active' $subQuery 
                    GROUP BY b.id
                    ORDER BY $sortField  $sortDir " ;

                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['batches']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }

    public function createBatch($batchInput)
    {
        return DB::table('batch')->insertGetId(
            $batchInput
        );
    }

    public function updateShop($shopInput)
    {
        return DB::table('shop')->insertGetId(
            $shopInput
        );
    }

    public function getCitySuggestions($city='')
    {
        return DB::table('shop')->distinct('city')->where('city','like',$city.'%')->get();
    }

    public function createBatchShop ($batchshops) 
    {
        DB::table('batch_shops')->insert( 
            $batchshops
        );
    }

    public function getBatchShopDetails ($batchId)
    {
        $query = "SELECT s.id as shop_id, s.shop, s.city, bs.id as batch_shop_id
                    FROM batch_shops bs
                    LEFT JOIN shop s  ON s.id=bs.shop_id 
                    WHERE bs.batch_id='$batchId'";
        return $result['shops']    =   DB::select(DB::raw($query ));
    }

    public function getShopsByCity ($city,$batchId=0)
    {
        $query = "SELECT s.id, s.shop, s.city, bs.id  AS batch_shop_id
                FROM shop s 
                LEFT JOIN batch_shops bs ON s.id=bs.shop_id AND bs.batch_id='$batchId'
                WHERE s.city = '$city'";
        return $result['shops']    =   DB::select(DB::raw($query ));
    }

    public function deleteBatchShops($batchId, $shopsToDelete)
    {
        foreach($shopsToDelete as $shopId) {
            $query = "DELETE FROM batch_shops WHERE batch_id=$batchId AND shop_id=$shopId";
            DB::select(DB::raw($query ));
        }
    }
}
