@extends('layout.ui-default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        New Bill
                    </h1>
                   
                </section>

                <section class="content">
<?php

?>
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
                                    <span class="input-group-addon">Name</span>
                                    <input type="text" id="customer" name="customer" tabindex="3"   class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Phone</span>
                                    <input type="text" id="phone" name="phone" tabindex="4"   class="form-control">
                                </div>
                            </div>
                        </div>
                        
                       <div class="row marginBottom10">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">Description/Address&nbsp;&nbsp;&nbsp;</span>
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
                                    <tbody id="newBillBody">
                                        <tr id="newProductEntry">
                                            <td>&nbsp;</td>
                                            <td><input type="text" id="txtNewProductEntry" class="txtBillProductCode txtBillTBox" value=""></td>
                                            <td></td>
                                            <td id=""><input type="text"  id="txtNewProductQuanity"  class="txtBillProductQuantity txtBillTBox"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr><td colspan="9">&nbsp;</td></tr>
                                        <tr id="rowProductSummary">
                                            <td >&nbsp;</td>
                                            <td colspan="2">Total Items: <label id="lblTotalProducts">0</label></td>
                                            <td colspan="2">Discount: <label id="lblTotalDiscount">0</label></td>
                                            <td colspan="2">Total Amount: <label id="lblTotalAmount">0</label></td>
                                            <td colspan="2">Paid Amount: <input id="lblPaidAmount" value="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br/><br/>
                        <div class="row marginBottom10">
                            <div class="col-md-8  marginBottom10">
                                <div class="input-group pull-right  marginBottom10">
                                        <button id="btnGenerateBill" rel="Sold" tabindex="14" class="btn btn-primary  pull-right marginLeft" type="button">Generate Bill</button>
                                        <button id="btnHold" rel="Hold" tabindex="14" class="btn btn-primary  pull-right marginLeft" type="button">Hold</button>
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