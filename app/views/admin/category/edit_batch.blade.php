@extends('layout.admin.popup')
@section('content')

<section class="content">
    <div class="row">
        <form method="POST" id="frmEditBatch">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-shopping-cart"></i>Batch and Shops</li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active marginBottom10">
                            <div class="input-group">
                                <span class="input-group-addon">Batch</span>
                                <input type="text" id="batch" name="batch" tabindex="1" value="<?php echo $batch_info->batch;?>"  class="form-control">
                            </div>
                            <label id="lbl-batch" class="error softHide" style="" for="batch"></label>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Purchase Date</span>
                                <input type="text" id="purchaseDate" name="purchaseDate" tabindex="1"  value="<?php echo $batch_info->purchased_on;?>"   class="form-control">
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Summary&nbsp;&nbsp;&nbsp;</span>
                                <textarea id="summary" name="summary" class="form-control"><?php echo $batch_info->description;?></textarea>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">City&nbsp;&nbsp;&nbsp;</span>
                                <select id="ddCity" name="ddCity"    class="form-control">
                                    <option value="">--Select City--</option>
                                    <?php if(!empty($cities)): ?>
                                        <?php foreach($cities as $city):
                                        $selCity = (isset($shops[0]) && $city->city==$shops[0]->city)?"selected='selected'":'';
                                        ?>
                                            <option <?php echo $selCity; ?> value="<?php echo $city->city;?>"><?php echo $city->city;?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>
                            <label id="lbl-ddCity" class="error softHide" style="" for="ddCity"></label>
                            <div class="input-group fullWidth">
                                <div id="shopWrap">
                                    
                                </div>
                            </div>
                            <br/>
                            

                        </div><!-- /.tab-pane -->

                        <div id="tab_1-1" class="tab-pane active">
                          
                            <div class="form-group" style="overflow:hidden;">
                                <div class="box-footer">
                                    <input type="hidden" name="hdnBatchId" id="hdnBatchId" value="<?php echo $batch_info->id;?>">
                                    <button id="btnBatchSave" class="btn btn-primary  pull-right" type="submit">Save</button>
                                    <label for="btnBatchSave" class="error" id="btnBatchSave-error"></label>
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div>
            </div>
        </form>
    </div>   <!-- /.row -->
</section>
<div class="bfh-datepicker" data-format="y-m-d" data-date="today">
</div>
@stop