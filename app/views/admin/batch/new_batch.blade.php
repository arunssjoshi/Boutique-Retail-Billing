@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
        <form method="POST" id="frmNewShop">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-shopping-cart"></i>Batch and Shops</li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active marginBottom10">
                            <div class="input-group">
                                <span class="input-group-addon">Batch</span>
                                <input type="text" id="shop" name="shop" tabindex="1"   class="form-control">
                            </div>
                            <label id="shop-error" class="error softHide" style="" for="shop"></label>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Purchase Date</span>
                                <input type="text" id="shop" name="shop" tabindex="1"   class="form-control">
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Summary&nbsp;&nbsp;&nbsp;</span>
                                <textarea  class="form-control"></textarea>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">City&nbsp;&nbsp;&nbsp;</span>
                                <select id="ddCity" name="ddCity"    class="form-control">
                                </select>
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

@stop