@extends('layout.admin.popup')
@section('content')

<section class="content">
    <div class="row">
        <form method="POST" id="frmNewBatch">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-shopping-cart"></i>Batch and Shops</li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active marginBottom10">
                            <div class="input-group">
                                <span class="input-group-addon">Batch</span>
                                <input type="text" id="batch" name="batch" tabindex="1"   class="form-control">
                            </div>
                            <label id="lbl-batch" class="error softHide" style="" for="batch"></label>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Purchase Date</span>
                                <input type="text" id="purchaseDate" name="purchaseDate" tabindex="1"   class="form-control">
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Summary&nbsp;&nbsp;&nbsp;</span>
                                <textarea id="summary" name="summary" class="form-control"></textarea>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">City&nbsp;&nbsp;&nbsp;</span>
                                <select id="ddCity" name="ddCity"    class="form-control">
                                    <option value="">--Select City--</option>
                                    <?php if(!empty($cities)):?>
                                        <?php foreach($cities as $city):?>
                                            <option value="<?php echo $city->city;?>"><?php echo $city->city;?></option>
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
                                    <button id="btnShopSave" class="btn btn-primary  pull-right" type="submit">Save</button>
                                    <label for="btnShopSave" class="error" id="btnShopSave-error"></label>
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