@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
        <form method="POST" id="frmEditShop">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-shopping-cart"></i>Shop and City</li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active marginBottom10">
                            <div class="input-group">
                                <span class="input-group-addon">Shop</span>
                                <input type="text" id="shop" name="shop" tabindex="1" value="<?php echo $shop_info->shop;?>"  class="form-control">
                            </div>
                            <label id="shop-error" class="error softHide" style="" for="shop"></label>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">City&nbsp;&nbsp;&nbsp;</span>
                                <input type="text" id="city" name="city" tabindex="1" value="<?php echo $shop_info->city;?>"  class="form-control">
                            </div>
                            <label id="city-error" class="error softHide" style=""   for="city">&nbsp;</label>

                        </div><!-- /.tab-pane -->

                        <div id="tab_1-1" class="tab-pane active">
                          
                            <div class="form-group" style="overflow:hidden;">
                                <div class="box-footer">
                                    <input type="hidden" name="hdnShopId" id="hdnShopId" value="<?php echo $shop_info->id;?>">
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

@stop