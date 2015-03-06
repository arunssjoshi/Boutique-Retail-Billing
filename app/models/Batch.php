<?php
class Shop extends Eloquent
{

    protected $table = 'shop';

    public function getShopsDetails($filter=array())
    {

        $sortColumns =   array('0'=>'s.shop', '1'=>'s.city');

        $subQuery    =   (isset($filter['shopId'] ) && $filter['shopId'] > 0)? " AND id = ".$filter['shopId']:"";
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (s.shop LIKE '".$filter['search']."%' OR 
                                                            s.city LIKE '".$filter['search']."%')":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   $sortColumns[$filter['sortField']];
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' ASC';

        $query =    "SELECT SQL_CALC_FOUND_ROWS   s.*
                    FROM shop s 
                    WHERE s.status='Active' $subQuery
                    GROUP BY s.id
                    ORDER BY $sortField  $sortDir " ;
                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['shops']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }

    public function createShop($shopInput)
    {
        return DB::table('shop')->insertGetId(
            $shopInput
        );
    }

    public function updateShop($shopInput)
    {
        return DB::table('shop')->insertGetId(
            $shopInput
        );
    }


    public function getPropertyOptions($propertyId, $filter=array())
    {

        $sortColumns =   array('0'=>'p.property', '1'=>'p.property');

        $subQuery    =   (isset($propertyId ) && $propertyId > 0)? " AND po.property_id = ".$propertyId:"";


        $query =    "SELECT SQL_CALC_FOUND_ROWS po.*   
                    FROM property_option po
                    WHERE po.status='Active'  $subQuery
                    ORDER BY po.option  ASC " ;
                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['property_options']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }


    public function getCitySuggestions($city='')
    {
        return DB::table('shop')->distinct('city')->where('city','like',$city.'%')->get();
    }
}
