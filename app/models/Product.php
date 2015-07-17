<?php
class Product extends Eloquent
{

    protected $table = 'product';

    public function getProductDetails($filter=array())
    {
        //var_dump($filter); exit;
        $sortColumns =   array('1'=>'p.id', '2'=>'p.product_code','3'=>'p.name', '4'=>'p.group_id', '5'=>'c.category', '6'=>'p.quantity', '7'=>'p.selling_price');

        $subQuery    =   (isset($filter['productId'] ) && $filter['productId'] > 0)? " AND p.id = ".$filter['productId']:"";
        $subQuery    .=   (isset($filter['categoryId'] ) && $filter['categoryId'] > 0)? " AND c.id = ".$filter['categoryId']:$subQuery;
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (p.id LIKE '".$filter['search']."%' OR 
                                                            p.product_code LIKE '".$filter['search']."%' OR 
                                                            p.name LIKE '".$filter['search']."%' OR 
                                                            p.group_id LIKE '".$filter['search']."%' OR 
                                                            c.category LIKE '".$filter['search']."%' OR 
                                                            p.selling_price LIKE '".$filter['search']."%')":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   isset($sortColumns[$filter['sortField']])?$sortColumns[$filter['sortField']]:'p.created_at';
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' DESC';

        if($filter['sortField']==0)
            $sortDir = 'DESC';

        if(isset($filter['listType']) && $filter['listType'] == 'queue') {
            $fromQuery = "barcode_queue bq JOIN  product p ON bq.product_id=p.id";
            $extraFields = ', bq.id as barcode_queue_id';
            $subQuery    .= " AND bq.status='Queue'";
            $sortField = 'p.id';
            $sortDir = 'ASC';
        } else if(isset($filter['listType']) && $filter['listType'] == 'printed') {
            $fromQuery = "barcode_queue bq JOIN  product p ON bq.product_id=p.id";
            $extraFields = ', bq.id as barcode_queue_id';
            $subQuery    .= " AND bq.status='Printed'";
            $sortField = 'bq.id';
            $sortDir = 'DESC';
        }  else if(isset($filter['listType']) && $filter['listType'] == 'tobe_queued') {
            $fromQuery = " product p LEFT  JOIN barcode_queue bq ON bq.product_id=p.id JOIN batch_shops bs ON p.batch_shop_id=bs.id";
            $extraFields = ', bq.id as barcode_queue_id';
            $subQuery    .= " AND bs.batch_id=8  AND bq.id IS NULL";
            $sortField = 'bq.id';
            $sortDir = 'DESC';
        }else {
            $fromQuery = "product p";
            $extraFields = '';
        }
        
        $query =    "SELECT SQL_CALC_FOUND_ROWS  p.id as product_id $extraFields, p.product_code, p.group_id, p.name as product, p.quantity, 
                    p.model, p.model_no, p.purchase_price, p.margin, p.selling_price, p.description, 
                    p.group_id, c.category, c.unit, p.batch_shop_id , p.company_id, p.status as product_status, c.id category_id
                    FROM  $fromQuery 
                    JOIN category c ON p.category_id=c.id 
                    WHERE p.status<>'Deleted' $subQuery 
                    ORDER BY $sortField  $sortDir " ;

        //die($query)           ;
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

    public function getCategoryPropertiesForProduct($categoryId, $productId='')
    {
        $subQuery = !empty($productId)? " AND ppo.product_id=".$productId:"";
       
        if ($productId > 0 ) {
               $query = "SELECT c.id AS category_id, p.id AS property_id, p.property , po.id AS option_id, po.option, ppo.id AS property_option_id, PPO.property_option_id
                    FROM category c
                    LEFT JOIN category_property cp ON c.id=cp.category_id
                    LEFT JOIN property p ON cp.property_id=p.id AND cp.category_id='$categoryId'
                    LEFT JOIN property_option po ON p.id=po.property_id 
                    LEFT JOIN product_property_option ppo ON po.id=ppo.property_option_id  AND ppo.product_id=".$productId."  
                    WHERE P.id IS NOT NULL 
                    ORDER BY p.property, po.option";
        } else {
               $query = "SELECT c.id AS category_id, p.id AS property_id, p.property , po.id AS option_id, po.option 

                    FROM category c
                    LEFT JOIN category_property cp ON c.id=cp.category_id
                    LEFT JOIN property p ON cp.property_id=p.id AND cp.category_id='$categoryId'
                    LEFT JOIN property_option po ON p.id=po.property_id 
                    WHERE P.id IS NOT NULL 
                    ORDER BY p.property, po.option";
        }
       
        return   DB::select(DB::raw($query ));
    }

    public function createProductPropertyOptions($productPropertyInput) 
    {
        DB::table('product_property_option')->insert( 
            $productPropertyInput
        );
    } 

    public function deleteProductPropertyOptions($productId, $propertiesToDelete)
    {
        foreach($propertiesToDelete as $propertyOptionID) {
            $query = "DELETE FROM product_property_option WHERE product_id=$productId AND property_option_id=$propertyOptionID";
            DB::select(DB::raw($query ));
        }
    }

    public function getProductsForBarcode($productIds)
    {
        $query = "SELECT p.id, p.product_code, c.category, p.selling_price, GROUP_CONCAT(pr.property,': ',po.option SEPARATOR ', ') AS property
                FROM barcode_queue bq JOIN  product p ON bq.product_id=p.id
                LEFT JOIN category c ON p.category_id=c.id
                LEFT JOIN product_property_option ppo ON ppo.product_id=p.id
                LEFT JOIN property_option po ON ppo.property_option_id=po.id
                LEFT JOIN property pr ON po.property_id=pr.id AND pr.printable='Yes'
                WHERE bq.id IN ($productIds) AND 
                p.status<>'Deleted' AND bq.status='Queue' 
                GROUP BY bq.id 
                ORDER BY p.id
                LIMIT 0, 30";
        return   DB::select(DB::raw($query ));

    }

    public function addToBarcodeQueue($products)
    {
        DB::table('barcode_queue')->insert(
            $products
        );
    }

    public function markAsPrinted($barcode_queue_ids)
    {
        $query = "UPDATE barcode_queue SET status='Printed' WHERE id IN ($barcode_queue_ids)";
        DB::select(DB::raw($query ));
    }
    public function deleteBarcodeQueueItem($barcode_queue_id)
    {
        $query = "DELETE FROM barcode_queue  WHERE id = $barcode_queue_id";
        DB::select(DB::raw($query ));
    }

    public function getTobeQueuedCount($batch_id)
    {
        $query = "
                SELECT p.id, p.product_code,bq.id , SUM(p.quantity) AS to_be_queued
                FROM product p 
                JOIN batch_shops bs ON p.batch_shop_id=bs.id
                LEFT JOIN barcode_queue bq ON p.id=bq.product_id 
                WHERE bs.batch_id= ?  AND bq.id IS NULL
                  ";
        return   DB::select($query, [$batch_id]);
    }


    /*BEGIN BILLING FUNCTIONS*/
    public function getBillProductDetails($product_id)
    {
        $query = "
                SELECT p.id AS product_id, p.product_code, p.selling_price , p.quantity AS available_quantity, c.category, d.discount_unit, IFNULL(d.discount,'') AS discount, c.tax
                FROM product p 
                JOIN category c ON p.category_id=c.id 
                LEFT JOIN discount_product dp ON p.id=dp.product_id
                LEFT JOIN discount d ON dp.discount_id=d.id AND (CURRENT_DATE() >= DATE(d.start_date)   AND CURRENT_DATE() <= DATE(d.end_date))
                WHERE p.product_code = ? ";
        return   DB::select($query, [$product_id]);
    }

    public function getBillProductDetailsByProductCodes($product_codes)
    {
        $query = "
                SELECT p.id AS product_id, p.product_code, p.selling_price , p.quantity AS available_quantity, c.category, d.id AS discount_id, d.discount_unit, IFNULL(d.discount,'') AS discount, c.tax
                FROM product p 
                JOIN category c ON p.category_id=c.id 
                LEFT JOIN discount_product dp ON p.id=dp.product_id
                LEFT JOIN discount d ON dp.discount_id=d.id AND (CURRENT_DATE() >= DATE(d.start_date)   AND CURRENT_DATE() <= DATE(d.end_date))
                WHERE p.product_code IN ($product_codes)  ";
        return   DB::select($query);
    }
    /*END BILLING FUNCTIONS*/
}
