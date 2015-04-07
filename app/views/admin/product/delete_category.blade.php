@extends('layout.admin.popup')
@section('content')
<section class="content">
    <div class="row">
            <div class="col-md-6">
                <div class="nav-tabs-custom noMarginBottom">
                    <div class="box box-solid bg-red">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-trash"></i> Delete this Category?</h3>
                        </div>
                    </div>
                   
                    <div class="tab-content">
                        <p class="message">
                            This Category has been using for # products. Are you sure you want to delete this Category?
                        </p>
                        <div id="tab_1-1" class="tab-pane active">
                           
                            <div class="form-group" style="overflow:hidden;">
                                <div class="box-footer">
                                    <a id="btnCategoryDelete" class="btn btn-primary  pull-right" type="button">Delete</a>
                                    <input type="hidden" name="hdnCategoryId" id="hdnCategoryId" value="<?php echo $category_info->category_id;?>">
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
         $(document).on('click','#btnCategoryDelete',function(){
            categories.deleteCategory();
         });
    })
</script>
@stop