@extends('layout.admin.default')
@section('content')

<section class="content-header">
    <h1>
        Edit Category
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo admin_url();?>/categories"><i class="fa fa-toggle-down"></i> Categories</a></li>
        <li class="active">Edit Category</li>
        
    </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- box start -->
    <div class="box">
        <form method="POST" id="frmEditCategory">        
        <div class="box-body table-responsive">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">Category</span>
                    <input type="text" id="category" name="category" tabindex="1" value="<?php echo $category_info->category;?>"  class="form-control">
                </div>
                <label id="lbl-category" class="error softHide" style="" for="category"></label>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon">Description&nbsp;&nbsp;&nbsp;</span>
                    <textarea id="description" tabindex="2"  name="description" class="form-control"><?php echo $category_info->description;?></textarea>
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon">Tax (%)</span>
                    <input type="text" id="tax" name="tax" tabindex="3"   value="<?php echo $category_info->tax;?>"  class="form-control">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon">Unit&nbsp;&nbsp;&nbsp;</span>
                    <select id="ddUnit" name="ddUnit"    class="form-control"  tabindex="4" >
                        <option value="Nos" <?php echo ($category_info->unit=='Nos'?"selected='selected'":"");?>>Nos</option>
                        <option value="Meter" <?php echo ($category_info->unit=='Meter'?"selected='selected'":"");?>>Meter</option>
                    </select>
                </div>

                <div class="input-group">
                <br/>
                <h4>Category Properties</h4>
                </div>

                <div class="row">
                <?php if($properties['total_rows'] > 0):?>
                    <?php foreach($properties['properties'] as $property):?>
                        <div class="col-lg-6 marginBottom10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo ($property->category_property_id!=''?"checked='checked'":"");?> value="<?php echo $property->property_id;?>"> <strong> <?php echo $property->property;?></strong>
                                </span>
                                <input type="text" value="<?php echo $property->property_options;?>" disabled="" class="form-control">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->  
                    <?php endforeach;?>
                <?php endif;?>
                </div><!-- /.row -->
                <div>
                <div class="input-group pull-right">
                         <input type="hidden" name="hdnCategoryId" id="hdnCategoryId" value="<?php echo $category_info->category_id;?>">
                         <button id="btnCategorySave" class="btn btn-primary  pull-right marginLeft" type="submit">Save</button>
                         <a href="<?php echo admin_url();?>/categories" class="btn btn-primary  pull-right" type="submit">Cancel</a>
                         <label for="btnCategorySave" class="error" id="btnCategorySave-error"></label>
                    </div>      
                </div>
            </div>
            <div class="clear"></div>
        </div><!-- /.box-body -->
        </form>
    </div><!-- /.box -->
<!-- box end -->

</section><!-- /.content -->

@stop