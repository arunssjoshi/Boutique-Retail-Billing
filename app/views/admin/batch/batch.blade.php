@extends('layout.admin.default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Batches
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Batches</li>
                        
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- box start -->
                    <div class="box">
                                
                        <div class="box-body table-responsive">
                            <h3>
                                <button rel="<?php echo base_url();?>/admin/batch/new" class="btn btn-primary btn-sm" id="btnNewBatch"> + New Batch</button>
                            </h3>
                            <div class="clear"></div>
                            <table id="tblShops" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Batch</th>
                                        <th>Shop</th>
                                        <th>City</th>
                                        <th>Purchase Date</th>
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
