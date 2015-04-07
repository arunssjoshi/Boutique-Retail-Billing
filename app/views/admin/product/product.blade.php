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
                                
                        <div class="box-body table-responsive">
                            <h3>
                                <a href="<?php echo base_url();?>/admin/products/new" class="btn btn-primary btn-sm" id="btnNewProduct"> + New Product</a>
                            </h3>
                            <div class="clear"></div>
                            <table id="tblCategories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Tax</th>
                                        <th>Total Products</th>
                                        <th>Total Price</th>
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
