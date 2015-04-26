@extends('layout.ui-default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        New Bill
                    </h1>
                   
                </section>

                <section class="content">
<!-- box start -->
    <div class="box">
        <form method="POST" id="frmNewProduct">  
            <div class="row marginBottom10">
                <div class="col-md-9">
                    <!-- item starts -->
                     <div class="box-body table-responsive">
                        <div class="input-group" >
                            <br/>
                            <h4>Customer Information</h4>
                        </div>
                        <div class="row marginBottom10">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Brand</span>
                                    <input type="text" id="brand" name="brand" tabindex="3"   class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Brand No</span>
                                    <input type="text" id="brand_no" name="brand_no" tabindex="4"   class="form-control">
                                </div>
                            </div>
                        </div>
                        
                       <div class="row marginBottom10">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">Description&nbsp;&nbsp;&nbsp;</span>
                                    <textarea id="description" tabindex="12"  name="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-body table-responsive">
            
                        <div class="input-group" >
                            <h4>Item Details</h4>
                        </div>
                            <div  id="itemWrap">
                                <table border="1" id="tblBill">
                                    <tr width="100%">
                                        <th width="3%">No.</th>
                                        <th width="5%">Code</th>
                                        <th width="5%">Category</th>
                                        <th width="5%">Quantity</th>
                                        <th width="5%">Rate</th>
                                        <th width="5%">Discount</th>
                                        <th width="5%">Tax</th>
                                        <th width="5%">Total</th>
                                        <th width="5%">Manage</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>CHUR9854</td>
                                            <td>Churidar</td>
                                            <td>2</td>
                                            <td>375</td>
                                            <td>Rs. 75 (10%)</td>
                                            <td>33.75</td>
                                            <td>675</td>
                                            <td><a href="javascript:;">Remove</a></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" class="txtBillProductCode txtBillTBox"></td>
                                            <td></td>
                                            <td><input type="text" class="txtBillProductQuantity txtBillTBox"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="javascript:;">Remove</a></td>
                                        </tr>
                                    </tbody>
                                    
                                    
                                </table>
                                

                               

                            </div>
                        <div class="row marginBottom10">
                            <div class="col-md-8  marginBottom10">
                                <div class="input-group pull-right  marginBottom10">
                                         <button id="btnProductSave" tabindex="14" class="btn btn-primary  pull-right marginLeft" type="button">Save</button>
                                         <a href="<?php echo admin_url();?>/categories" class="btn btn-primary  pull-right" type="submit">Cancel</a>
                                         <label for="btnProductSave" class="error" id="btnProductSave-error"></label>
                                    </div>      
                                </div>
                        </div>

                        <div class="clear"></div>
                     </div>
                    <!-- item ends -->
                </div>
                <div class="col-md-2">a</div>
            </div>
           
        
        </form>
    </div><!-- /.box -->
<!-- box end -->

</section><!-- /.content -->
 @stop        