@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-check-circle"></i>Property and Options</li>
                </ul>
                <div class="tab-content">
                    <div id="tab_1-1" class="tab-pane active">
                        <b>Property:</b>
                        <div class="form-group">
                            <label for="exampleInputEmail1"></label>
                            <input type="text" placeholder="Property" id="property" name="property" class="form-control">
                        </div>

                    </div><!-- /.tab-pane -->

                    <div id="tab_1-1" class="tab-pane active">
                        <b>Property Options:</b>
                        <div class="form-group" id="optionWrap">
                            <br/>
                        </div>
                        <div class="form-group">
                            <div class="box-footer">
                                <button class="btn btn-primary  pull-right" type="submit">Save</button><br/>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div>
        </div>
    </div>   <!-- /.row -->
</section>
<div id="optionHtml" class="hide">
    <div class="optionRow">
        <div class="row">
            <div class="col-xs-4">
                <input type="text" placeholder="Option" class="form-control txtPropertyOption">
            </div>
            <div class="col-xs-2">
                <button class="btn btn-danger  btn-sm btnDeleteOption"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
@stop