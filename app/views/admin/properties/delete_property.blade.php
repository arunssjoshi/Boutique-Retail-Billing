@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <div class="box box-solid bg-red">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-trash"></i> Delete this Property?</h3>
                        </div>
                    </div>
                   
                    <div class="tab-content">
                        <p class="message">
                            This Property has been using for # products. Are you sure you want to delete this Property and its options?
                        </p>
                        <div id="tab_1-1" class="tab-pane active">
                           
                            <div class="form-group" style="overflow:hidden;">
                                <div class="box-footer">
                                    <a id="btnPropertyDelete" class="btn btn-primary  pull-right" type="button">Delete</a>
                                    <input type="hidden" id="hdnPropertyId" value="<?php echo $propertyId;?>">
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div>
            </div>
    </div>   <!-- /.row -->
</section>
<script type="text/javascript">
    $(document).ready(function(){
         $(document).on('click','#btnPropertyDelete',function(){
            properties.deleteProperty();
         });
    })
</script>
@stop