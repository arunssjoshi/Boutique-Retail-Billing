<?php
    
return array(
        'scripts'=>array('colorbox'		=>
        							array('file'=>base_url().'/assets/colorbox/jquery.colorbox-min.js'),
        				 'validator'		=>
        							array('file'=>base_url().'/assets/validator/jquery.validate.min.js'),
        				 'properties'	=>
        				 			array('file'=>base_url().'/scripts/properties/properties.js'),
        				 'add_property'	=>
        				 			array('file'=>base_url().'/scripts/properties/addProperty.js'),
        				 'edit_property'	=>
        				 			array('file'=>base_url().'/scripts/properties/editProperty.js'),
                         'shops'   =>
                                    array('file'=>base_url().'/scripts/shops/shops.js'),    
                         'add_shop' =>
                                    array('file'=>base_url().'/scripts/shops/addShop.js'),                  
        				 ),
        'styles'=>array('colorbox'		=>
        							array('file'=>base_url().'/assets/colorbox/colorbox.css','type'=>'media'),
        				'properties'	=>
        							array('file'=>base_url().'/scripts/properties.js')),

    );
