@extends('layout.admin.default')
@section('content')

<section class="content-header">
    <h1>
        New Product
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo admin_url();?>/products"><i class="fa fa-toggle-down"></i> Products</a></li>
        <li class="active">New Product</li>
        
    </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- box start -->
    <div class="box">
        <form method="POST" id="frmNewProduct">        
        <div class="box-body table-responsive">
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Product</span>
                        <input type="text" id="product" name="product" tabindex="1"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="product"></label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Company</span>
                        <input type="text" id="company" name="company" tabindex="2"   class="form-control">
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Brand</span>
                        <input type="text" id="brand" name="brand" tabindex="3"   class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Brand No</span>
                        <input type="text" id="brand_no" name="brand_no" tabindex="4"   class="form-control">
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Batch&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddBatch" name="ddBatch"    class="form-control"  tabindex="5" >
                            <option value="1">Eranakulam</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Shop&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddBatchShop" name="ddBatchShop"    class="form-control"  tabindex="6" >
                        <?php foreach($shops as $shop):?>
                            <option value="<?php echo $shop->batch_shop_id;?>"><?php echo $shop->shop;?></option>
                        <?php endforeach;?>
                                                        
                        </select>
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Cateogory&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddCategory" name="ddCategory"    class="form-control"  tabindex="7" >
                            <?php if($categories['total_rows'] > 0):?>
                                  <?php foreach($categories['categories'] as $category):?>
                                        <option value="<?php echo $category->category_id;?>"><?php echo $category->category;?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Quantity</span>
                        <input type="text" id="quantity" name="quantity" tabindex="8" value="1"   class="form-control">
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Purchase Price</span>
                        <input type="text" id="purchase_price" name="purchase_price" tabindex="9"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="purchase_price"></label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Profit Margin (%)</span>
                        <input type="text" id="profit_margin" name="profit_margin" tabindex="10" value="35"   class="form-control">
                    </div>
                </div>
            </div>

            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Customer Price</span>
                        <input type="text" id="customer_price" name="customer_price" tabindex="11"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="customer_price"></label>
                </div>
            </div>

           <div class="row marginBottom10">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">Description&nbsp;&nbsp;&nbsp;</span>
                        <textarea id="description" tabindex="12"  name="description" class="form-control"></textarea>
                    </div>
                </div>
            </div>
              
        </div><!-- /.box-body -->
        <div class="box-body table-responsive">
            <div class="row marginBottom10">
                <div class="col-md-4  ">
                    <div class="input-group pull-right">
                        <span class="input-group-addon">Duplicate #</span>
                        <input type="text" id="duplicate" name="duplicate" tabindex="13" value=0  class="form-control">
                        <br/>
                    </div>
                </div>
            </div>   
            <div class="row marginBottom10">
                <div class="col-md-8  marginBottom10">
                    <div class="input-group pull-right  marginBottom10">
                             <button id="btnProductSave" tabindex="14" class="btn btn-primary  pull-right marginLeft" type="submit">Save</button>
                             <a href="<?php echo admin_url();?>/categories" class="btn btn-primary  pull-right" type="submit">Cancel</a>
                             <label for="btnProductSave" class="error" id="btnProductSave-error"></label>
                        </div>      
                    </div>
                </div>
            </div>

            <div class="clear"></div>
         </div>
        </form>
    </div><!-- /.box -->
<!-- box end -->

</section><!-- /.content -->

@stop