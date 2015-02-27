<?php
    
return array(
        'scripts'=>array('colorbox'		=>
        							array('file'=>base_url().'/assets/colorbox/jquery.colorbox-min.js'),
        				 'validator'		=>
        							array('file'=>base_url().'/assets/validator/jquery.validate.min.js'),
                         'typehead'     =>
                                    array('file'=>base_url().'/assets/bootsrap/js/typeahead.min.js'),



        				 'properties_js'	=>
        				 			array('file'=>base_url().'/scripts/properties/properties.js'),
        				 'add_property_js'	=>
        				 			array('file'=>base_url().'/scripts/properties/addProperty.js'),
        				 'edit_property_js'	=>
        				 			array('file'=>base_url().'/scripts/properties/editProperty.js'),

                         'shops_js'   =>
                                    array('file'=>base_url().'/scripts/shops/shops.js'),    
                         'add_shop_js' =>
                                    array('file'=>base_url().'/scripts/shops/addShop.js'),     
                         'edit_shop_js' =>
                                    array('file'=>base_url().'/scripts/shops/editShop.js'),             
        				 ),
        'styles'=>array('colorbox'		=>
        							array('file'=>base_url().'/assets/colorbox/colorbox.css','type'=>'media'),
        				'properties'	=>
        							array('file'=>base_url().'/scripts/properties.js')),

    );
