@extends('layout.admin.default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Products
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Products</li>
                        
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- box start -->
                    <div class="box">
                        <div id="categoryHolder" class="hide">
                            <div class="row marginBottom10">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <select id="ddCategory" name="ddCategory"    class="form-control"  tabindex="7" >
                                            <?php if($categories['total_rows'] > 0):?>
                                                    <option value="">Category</option>
                                                  <?php foreach($categories['categories'] as $category):?>
                                                        <option  value="<?php echo $category->category_id;?>"><?php echo $category->category;?></option>
                                                    <?php endforeach;?>
                                                    <?php endif;?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                           
                        </div>         
                        <div class="box-body table-responsive">
                            <h3>
                                <a href="<?php echo base_url();?>/admin/products/new" class="btn btn-primary btn-sm" id="btnNewProduct"> + New Product</a>
                                <a href="javascript:;" class="btn btn-primary btn-sm " id="btnAddQueue"> + Add to Queue (<span id="queueCount"><?php echo DB::table('barcode_queue')->where('status', '=', 'Queue')->count();?></span>)</a> 
                                <a href="javascript:;" class="btn btn-primary btn-sm queueLink hide" id="btnGenerateBarcode"> ^ Generate Barcode</a>
                                <a href="javascript:;" class="btn btn-primary btn-sm queueLink hide" id="btnMarkAsPrinted"> Mark Printed</a>
                                
                            </h3>
                            To be Queued: <?php echo $tobe_queued[0]->to_be_queued ;?>
                            <div>
                                <select id="productListType" class="">
                                    <option value="product">Product</option>
                                    <option value="queue">Queue</option>
                                    <option value="printed">Printed</option>
                                    <option value="tobe_queued">To Be queued</option>
                                </select>
                                
                            </div><br/>
                            <div class="clear"></div>
                            <table id="tblProducts" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="20"><input type="checkbox" id="chkAllProduct"></th>
                                        <th width="60">Product&nbsp;ID</th>
                                        <th>Product Code</th>
                                        <th>Product</th>
                                        <th width="80">Group</th>
                                        <th width="80">Category</th>
                                        <th width="60">Quantity</th>
                                        <th width="80">Selling&nbsp;Price</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                <!-- box end -->
                
                </section><!-- /.content -->
                

@stop
