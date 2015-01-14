@extends('layout.admin.default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Properties
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Properties</li>
                        
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- box start -->
                    <div class="box">
                                
                        <div class="box-body table-responsive">
                            <table id="tblProperties" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Options</th>
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

@section('ScriptIncludes')
    <script type="text/javascript" src="<?php echo base_url();?>/scripts/properties.js"></script>
    
@stop

@section('StyleIncludes')
    
@stop
