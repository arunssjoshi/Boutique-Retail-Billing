<?php if(isset($product_properties)){
    $i = 0 ;
    echo '<div class="row marginBottom10">';
    foreach($product_properties as $property){
        if($i % 2 == 0)
            echo '</div><div class="row marginBottom10">';
        ?>
            <div id="" class="col-md-4">
                <div class="input-group-addon productPropertyWrap">
                    <div class="boxProperty">
                        <strong><?php echo $property[0]['property'];?></strong> <br/><br/>
                        <?php 
                        $k=1;
                        foreach($property as $property_option):?>
                              <input type="radio" <?php echo (isset($property_option['property_option_id']) && isset($product_id))?"checked='checked'":"";?> value="<?php echo $property_option['option_id'];?>"  name="<?php echo $property_option['property_id'];?>"  class="form-control simpled simpleChk"> <?php echo $property_option['option'];?>&nbsp;&nbsp;
                        <?php
                        if($k % 5 == 0)
                            echo '<br/><br/>';
                        $k++;
                        endforeach;?>
                    </div>
                </div>
                
            </div>
        <?php
        $i++;
    }
    echo '</div>';
}?>