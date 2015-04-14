<?php
class Product extends Eloquent
{

    protected $table = 'product';

    public function getProductDetails($filter=array())
    {
        //var_dump($filter); exit;
        $sortColumns =   array('0'=>'p.id','1'=>'c.tax', '2'=>'c.category', '3'=>'c.category');

        $subQuery    =   (isset($filter['categoryId'] ) && $filter['categoryId'] > 0)? " AND c.id = ".$filter['categoryId']:"";
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (c.category LIKE '".$filter['search']."%' )":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   $sortColumns[$filter['sortField']];
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' DESC';

        if($filter['sortField']==0)
            $sortDir = 'DESC';

        $query =    "SELECT SQL_CALC_FOUND_ROWS  p.id as product_id, p.product_code, p.name as product, p.quantity, p.selling_price, 
                    p.group_id, c.category, c.unit, p.batch_shop_id , p.company_id
                    FROM product p 
                    JOIN category c ON p.category_id=c.id 
                    WHERE p.status<>'Deleted' $subQuery 
                    ORDER BY $sortField  $sortDir " ;

                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['products']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }

    /********************************/

    public function createCategoryProperties($categoryPropertyInput) 
    {
        DB::table('category_property')->insert( 
            $categoryPropertyInput
        );
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

    public function getCompanies($company_id = 0)
    {
        if ($company_id > 0) {
            return DB::table('company')->where('status','Active')->where('id', $company_id )->get();
        } else {
            return DB::table('company')->where('status','Active')->get();
        }
    }
}
