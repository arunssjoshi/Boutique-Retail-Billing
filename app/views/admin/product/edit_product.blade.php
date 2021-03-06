@extends('layout.admin.default')
@section('content')

<section class="content-header">
    <h1>
        Edit Product
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo admin_url();?>/products"><i class="fa fa-toggle-down"></i> Products</a></li>
        <li class="active">New Product</li>
        
    </ol>
</section>
<?php 
    
    
   
?>
<!-- Main content -->
<section class="content">
<!-- box start -->
    <div class="box">
        <form method="POST" id="frmEditProduct">        
        <div class="box-body table-responsive">
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Product Code</span>
                        <input type="text" id="brand" name="brand" tabindex="1" value="<?php echo $product_info->product_code;?>"  class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Product Group</span>
                        <input type="text" id="group_id" name="group_id" tabindex="1"  value="<?php echo $product_info->group_id;?>"   class="form-control">
                    </div>
                </div>
            </div>

            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Product</span>
                        <input type="text" id="product" value="<?php echo $product_info->product;?>" name="product" tabindex="1"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="product"></label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Company&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddCompany" name="ddCompany"    class="form-control"  tabindex="2" >
                            <?php if($companies):?>
                                    <option value=""></option>
                                <?php foreach($companies as $company):?>
                                    <option  <?php echo ($product_info->company_id == $company->id)?"selected='selected'":""; ?>  value="<?php echo $company->id;?>"><?php echo $company->company;?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                         </select>
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Brand</span>
                        <input type="text" id="brand" name="brand" tabindex="3"  value="<?php echo $product_info->model;?>"   class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Brand No</span>
                        <input type="text" id="brand_no" name="brand_no" tabindex="4"  value="<?php echo $product_info->model_no;?>"   class="form-control">
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Batch&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddBatch" name="ddBatch"    class="form-control"  tabindex="5" >
                            <?php if($batches['total_rows'] > 0):?>
                                <?php foreach($batches['batches'] as $batch):?>
                                    <option <?php echo ($product_batch->id == $batch->id)?"selected='selected'":""; ?> value="<?php echo $batch->id;?>"><?php echo $batch->batch;?></option>
                                <?php endforeach;?>$
                            <?php endif;?>
                         </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Shop&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddBatchShop" name="ddBatchShop"    class="form-control"  tabindex="6" >
                        <?php foreach($shops as $shop): ?>
                            <option <?php echo ($product_info->batch_shop_id == $shop->batch_shop_id)?"selected='selected'":""; ?> value="<?php echo $shop->batch_shop_id;?>"><?php echo $shop->shop;?></option>
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
                                        <option <?php echo ($product_info->category_id == $category->category_id)?"selected='selected'":""; ?>  value="<?php echo $category->category_id;?>"><?php echo $category->category;?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Quantity</span>
                        <input type="text" id="quantity" name="quantity" tabindex="8" value="<?php echo $product_info->quantity;?>"  value="<?php echo $product_info->product_code;?>"   class="form-control">
                    </div>
                </div>
            </div>
            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Purchase Price</span>
                        <input type="text" id="purchase_price" name="purchase_price" tabindex="9"  value="<?php echo $product_info->purchase_price;?>"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="purchase_price"></label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Profit Margin (%)</span>
                        <input type="text" id="profit_margin" name="profit_margin" tabindex="10" value="35"   value="<?php echo $product_info->margin;?>"  class="form-control">
                    </div>
                </div>
            </div>

            <div class="row marginBottom10">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Customer Price</span>
                        <input type="text" id="customer_price" name="customer_price" tabindex="11"  value="<?php echo $product_info->selling_price;?>"   class="form-control">
                    </div>
                    <label id="lbl-product" class="error softHide" style="" for="customer_price"></label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Status&nbsp;&nbsp;&nbsp;</span>
                        <select id="ddStatus" name="ddStatus"    class="form-control"  tabindex="5" >
                            <?php 
                            $status_list = explode(',', 'Active,Hold,Damaged,Deleted,Owned,Soldout');
                            foreach($status_list as $status):?>
                                <option <?php echo ($product_info->product_status == $status)?"selected='selected'":""; ?> value="<?php echo $status;?>"><?php echo $status;?></option>
                            <?php endforeach;?>
                         </select>
                    </div>
                </div>
            </div>

           <div class="row marginBottom10">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">Description&nbsp;&nbsp;&nbsp;</span>
                        <textarea id="description" tabindex="12"  name="description" class="form-control"><?php echo $product_info->description;?></textarea>
                    </div>
                </div>
            </div>
              
        </div><!-- /.box-body -->
        <div class="box-body table-responsive">
           
            <div class="input-group" >
                <br/>
                <h4>Product Properties</h4>
                </div>
                <div  id="wrapProductProperties">
                    
                </div>
            <div class="row marginBottom10">
                <div class="col-md-8  marginBottom10">
                    <div class="input-group pull-right  marginBottom10">
                            <input type="hidden" name="hdnProductId" id="hdnProductId" value="<?php echo $product_info->product_id;?>">
                             <button id="btnProductSave" tabindex="14" class="btn btn-primary  pull-right marginLeft" type="submit">Update</button>
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