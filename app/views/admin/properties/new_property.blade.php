@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
        <form method="POST" id="frmNewProperty">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-check-circle"></i>Property and Options</li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active">
                            <div class="input-group">
                                <span class="input-group-addon">Property</span>
                                <input type="text" id="property" name="property" tabindex="1"   class="form-control">
                            </div>
                            <label id="property-error" class="error softHide" style="" for="property"></label>
                        </div><!-- /.tab-pane -->

                        <div id="tab_1-1" class="tab-pane active">
                            <br/>
                            <b>Property Options:</b>
                            <div class="form-group" id="optionWrap">
                            </div>
                            <div class="form-group" style="overflow:hidden;">
                                <div class="box-footer">
                                    <button id="btnPropertySave" class="btn btn-primary  pull-right" type="submit">Save</button>
                                    <label for="btnPropertySave" class="error" id="btnPropertySave-error"></label>
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div>
            </div>
        </form>
    </div>   <!-- /.row -->
</section>
<div id="optionHtml" class="hide">
    <div class="optionRow">
        <div class="row">
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon">Option</span>
                    <input type="text" id="option[]" name="option[]" tabindex="2"  class="form-control  txtPropertyOption">
                </div>
                <label id="option[]-error" class="error softHide" for="option[]"></label>
            </div>
            <div class="col-xs-2">
                <button class="btn btn-danger  btn-sm btnDeleteOption"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
@stop