<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Print Bill</title>
 
<link rel="stylesheet" href="/styles/print-bill.css" type="text/css" />
<link rel="stylesheet" href="/styles/print-bill.css" type="text/css" media="print" /> 
<style type="text/css">
	
</style>
</head>
<body id="index" class="home">
	<div id="bill-print-wrap">
		<div id="bill-header"> 
			<div id="shop-info">
				<div id="logo-wrap"><img src="/images/barcode-logo.png"></div>
				<div id="shop-text">
					Daavani Ladies Point<br/>
					Attingal Road, Venjaramoodu<br/>
					Ph: 09048614877, 09446127327
				</div>
				<div class="clear"></div>
			</div>
			<div id="bill-info">
				Bill No: 91985<br/>
				Date: 18/5/2015 3:15PM
			</div>
			<div class="clear"></div>
		</div>
		<div id="BillitemWrap">
                                <table border="1" id="tblPrintBill" cellspacing="0">
                                    <tbody>
                                    <tr style="">
                                        <th style="width:10px">No.</th>
                                        <th style="width:60px">Code</th>
                                        <th style="width:90px">Item</th>
                                        <th style="width:30px">Qty</th>
                                        <th style="width:70px">MRP</th>
                                        <th style="width:30px">Discount</th>
                                        <th style="width:50px">Tax</th>
                                        <th style="width:80px">Total</th>
                                    </tr>
                                    	<?php 
                                    	$total_items = 0;
                                    	$sub_total = 0;
                                    	$total_discount = 0;
                                    	$grant_total =0;
                                    	foreach($bill_products as $key=> $product):

	                                    	$discount = $product->discount;
	                                    	$quantity = $product_quantity[$product->product_code];
	                                    	$mrp      = $product->selling_price;

	                                    	$total_items = $total_items + $quantity;

	                                    	if($discount) {
	                                    		$discountAmount = ($mrp * $quantity) * $discount/100;
	                                    	} else {
	                                    		$discountAmount = '-';
	                                    	}

	                                    	$tax = ($mrp*$quantity- $discountAmount) *  $product->tax/100 ;
	                                    	$total = $quantity * $mrp - $discountAmount;
	                                    	$grant_total = $grant_total + $total;
	                                    	$total_discount = $total_discount + $discountAmount;
	                                    	$sub_total = $sub_total+ ($mrp * $quantity);
	                                    	//
	                                    	
	                                    	// Total Amount: ₹ <label id="lblTotalAmount"><strong>5180/-</strong></label>
                                    	?>
                                    		<tr class="rowProduct" id="tr-SREE4">
                                    			<td class="colNo"><?php echo ++$key;?></td>
                                    			<td class="colCode" id="col-SREE4-code"><?php echo $product->product_code;?></td>
                                    			<td class="colCategory" id="col-SREE4-category"><?php echo $product->category;?></td>
                                    			<td class="colQuantity" id="col-SREE4-quantity"><?php echo $product_quantity[$product->product_code];?></td>
                                    			<td class="colMRP" id="col-SREE4-mrp"><?php echo $product->selling_price;?></td>
                                    			<td class="colDiscount" id="col-SREE4-discount">
                                    				<label id="discount-amount-SREE4" class="discount-amount"><?php echo $discountAmount;?></label>
                                    			</td>
                                    			<td class="colTax" id="col-SREE4-tax">
                                    				<label id="tax-amount-SREE4"><?php echo $tax;?></label> 
                                    			</td><td class="colTotal" id="col-SREE4-total"><?php echo $total;?></td>
                                    		</tr>
                                    	<?php endforeach;
                                    		$grant_total = $sub_total - $total_discount;
                                    	?>
                                       
                                    </tr>
                                    
                                    <tr id="rowProductSummary">
									    <td class="colTotalItems" colspan="4" align="" valign="top">Total Items: <label id="lblTotalProducts"><?php echo $total_items;?></label></td>
									    <td colspan="1">&nbsp;</td>
									    <td colspan="3">
									    	<table id="tblBillSummary" align="right">
									    		<tr><td height="10px">Total</td><td><?php echo $sub_total;?> - </td></tr>
									    		<tr><td>Discount</td><td><?php echo $total_discount;?></td></tr>
									    		<tr id="trGrantTotal"><td>Grant Total</td><td>₹ <?php echo $grant_total;?></td></tr>
									    	</table>
									    </td>
									</tr>    
                                    
                                </table>
                            </div>
	</div>
	
</body>
</html>