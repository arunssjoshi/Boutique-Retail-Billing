<?php
class PropertyOption extends Eloquent
{

    protected $table = 'property_option';


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

}
