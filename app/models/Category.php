<?php
class Category extends Eloquent
{

    protected $table = 'category';

    public function createCategoryProperties($categoryPropertyInput) 
    {
        DB::table('category_property')->insert( 
            $categoryPropertyInput
        );
    } 
    public function getCategoryDetails($filter=array())
    {

        $sortColumns =   array('0'=>'c.category','1'=>'c.tax', '2'=>'c.category', '3'=>'c.category');

        $subQuery    =   (isset($filter['categoryId'] ) && $filter['categoryId'] > 0)? " AND c.id = ".$filter['categoryId']:"";
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (c.category LIKE '".$filter['search']."%' )":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   $sortColumns[$filter['sortField']];
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' ASC';

        $query =    "SELECT SQL_CALC_FOUND_ROWS  c.id AS category_id, c.category, c.tax AS tax, c.description, c.unit, c.category_short_code, 
                    SUM(p.quantity) AS total_product, 
                    SUM(p.quantity*p.selling_price) AS total_price 
                    FROM category c 
                    LEFT JOIN product p ON c.id=p.category_id
                    WHERE c.status='Active'
                    GROUP BY c.id 
                    HAVING 1 $subQuery 
                    ORDER BY $sortField  $sortDir " ;

                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['categories']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }

    public function getCategoryProperties($categoryId)
    {
        $query =    "SELECT SQL_CALC_FOUND_ROWS
                      p.id       AS property_id,  p.property,
                      GROUP_CONCAT(po.option ORDER BY po.id SEPARATOR ', ') AS property_options, cp.id AS category_property_id
                    FROM property p
                    LEFT JOIN property_option po ON p.id = po.property_id 
                    LEFT JOIN category_property cp ON p.id=cp.property_id AND cp.category_id='$categoryId'
                    WHERE p.status = 'Active' AND IF(po.id IS NOT NULL, po.status = 'Active',1)
                    GROUP BY p.id
                    ORDER BY p.property ASC";
        $result['properties']  =  DB::select(DB::raw($query ));
        $result['total_rows']   =  DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;
    }

    public function deleteCategoryProperties($categoryId, $propertiesToDelete)
    {
        foreach($propertiesToDelete as $propertyID) {
            $query = "DELETE FROM category_property WHERE category_id=$categoryId AND property_id=$propertyID";
            DB::select(DB::raw($query ));
        }
    }

    /**********************************************************************************************/
    

    
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

    
}
