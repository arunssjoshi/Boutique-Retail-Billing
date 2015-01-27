<?php
class Property extends Eloquent
{

    protected $table = 'properties';

    public function getPropertiesDetails($dtFilter=array())
    {

        $sortColumns = array('0'=>'p.property', '1'=>'p.property');
        //$subQuery .=   ($notification_id != 0 )? " AND n.id='$notification_id'":""
        $sortField   = $sortColumns[$dtFilter['sortField']];
        $sortDir     = $dtFilter['sortDir'];
        $query =    "SELECT SQL_CALC_FOUND_ROWS   p.id AS property_id, p.property, GROUP_CONCAT(po.option ORDER BY po.id SEPARATOR ', ') AS property_options
                    FROM property p 
                    LEFT JOIN property_option po ON p.id=po.property_id 
                    WHERE p.status='Active' AND po.status='Active'
                    GROUP BY p.id
                    ORDER BY $sortField  $sortDir " ;
                    //die($query);
        if (is_numeric($dtFilter['offset']) && is_numeric($dtFilter['limit'])) {
            $query .= " LIMIT ".$dtFilter['offset']." , ".$dtFilter['limit'];
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
