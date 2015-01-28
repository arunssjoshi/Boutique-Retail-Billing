<?php
class Property extends Eloquent
{

    protected $table = 'properties';

    public function getPropertiesDetails($filter=array())
    {

        $sortColumns =   array('0'=>'p.property', '1'=>'p.property');

        $subQuery    =   (isset($filter['propertyId'] ) && $filter['propertyId'] > 0)? " AND property_id = ".$filter['propertyId']:"";
        $subQuery    .=   ((isset($filter['search']) && $filter['search']!='' ))? " AND (p.property LIKE '".$filter['search']."%' OR 
                                                            po.option LIKE '".$filter['search']."%')":"";

        $filter['sortField']    =   isset($filter['sortField'])?$filter['sortField']:0;

        $sortField   =   $sortColumns[$filter['sortField']];
        $sortDir     =   isset($filter['sortDir'])?$filter['sortDir']:' ASC';

        $query =    "SELECT SQL_CALC_FOUND_ROWS   p.id AS property_id, p.property, GROUP_CONCAT(po.option ORDER BY po.id SEPARATOR ', ') AS property_options
                    FROM property p 
                    LEFT JOIN property_option po ON p.id=po.property_id 
                    WHERE p.status='Active' AND po.status='Active' $subQuery
                    GROUP BY p.id
                    ORDER BY $sortField  $sortDir " ;
                    //die($query);
        if (isset($filter['offset']) && is_numeric($filter['offset']) && isset($filter['limit']) && is_numeric($filter['limit'])) {
            $query .= " LIMIT ".$filter['offset']." , ".$filter['limit'];
        }

        $result['properties']    =   DB::select(DB::raw($query ));
        $result['total_rows']   =    DB::select(DB::raw("SELECT FOUND_ROWS()  as total_rows"));
        $result['total_rows']   =  $result['total_rows'][0]->total_rows;

        return $result;

    }

    public function createProperty($propertyInput)
    {
        return DB::table('property')->insertGetId(
            $propertyInput
        );
    }

    public function createPropertyOptions($propertyOptionsInput)
    {
        
        DB::table('property_option')->insert(
            $propertyOptionsInput
        );
    }
}
