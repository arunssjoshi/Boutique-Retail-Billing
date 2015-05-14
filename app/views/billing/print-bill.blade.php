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
                                        <th style="width:90px">Category</th>
                                        <th style="width:30px">Qty</th>
                                        <th style="width:70px">Rate</th>
                                        <th style="width:30px">Discount</th>
                                        <th style="width:50px">Tax</th>
                                        <th style="width:80px">Total</th>
                                    </tr>
                                    
                                        <tr class="rowProduct" id="tr-SREE4"><td class="colNo">1</td><td class="colCode" id="col-SREE4-code">SREE4</td><td class="colCategory" id="col-SREE4-category">Saree</td><td class="colQuantity" id="col-SREE4-quantity">1</td><td class="colMRP" id="col-SREE4-mrp">515</td><td class="colDiscount" id="col-SREE4-discount"><label id="discount-amount-SREE4" class="discount-amount">206</label></td><td class="colTax" id="col-SREE4-tax"><label id="tax-amount-SREE4">37.08</label> </td><td class="colTotal" id="col-SREE4-total">1854</td></tr>
                                        <tr class="rowProduct" id="tr-SREE1"><td class="colNo">2</td><td class="colCode" id="col-SREE1-code">SREE1</td><td class="colCategory" id="col-SREE1-category">Saree</td><td class="colQuantity" id="col-SREE1-quantity">1</td><td class="colMRP" id="col-SREE1-mrp">515</td><td class="colDiscount" id="col-SREE1-discount"><label id="discount-amount-SREE1" class="discount-amount"> - </label><label id="discount-SREE1" class="hide"></label></td><td class="colTax" id="col-SREE1-tax"><label id="tax-amount-SREE1">10.3</label></td><td class="colTotal" id="col-SREE1-total">515</td></tr>
                                        <tr class="rowProduct" id="tr-SREE2"><td class="colNo">3</td><td class="colCode" id="col-SREE2-code">SREE2</td><td class="colCategory" id="col-SREE2-category">Saree</td><td class="colQuantity" id="col-SREE2-quantity">1</td><td class="colMRP" id="col-SREE2-mrp">515</td><td class="colDiscount" id="col-SREE2-discount"><label id="discount-amount-SREE2" class="discount-amount"> - </label><label id="discount-SREE2" class="hide"></label></td><td class="colTax" id="col-SREE2-tax"><label id="tax-amount-SREE2">10.3</label> </td><td class="colTotal" id="col-SREE2-total">515</td></tr>
                                        <tr class="rowProduct" id="tr-SREE3"><td class="colNo">4</td><td class="colCode" id="col-SREE3-code">SREE3</td><td class="colCategory" id="col-SREE3-category">Saree</td><td class="colQuantity" id="col-SREE3-quantity">1</td><td class="colMRP" id="col-SREE3-mrp">515</td><td class="colDiscount" id="col-SREE3-discount"><label id="discount-amount-SREE3" class="discount-amount"> - </label><label id="discount-SREE3" class="hide"></label></td><td class="colTax" id="col-SREE3-tax"><label id="tax-amount-SREE3">10.3</label> </td><td class="colTotal" id="col-SREE3-total">515</td></tr>
                                        <tr class="rowProduct" id="tr-SREE5"><td class="colNo">5</td><td class="colCode" id="col-SREE5-code">SREE5</td><td class="colCategory" id="col-SREE5-category">Saree</td><td class="colQuantity" id="col-SREE5-quantity">1</td><td class="colMRP" id="col-SREE5-mrp">575</td><td class="colDiscount" id="col-SREE5-discount"><label id="discount-amount-SREE5" class="discount-amount"> - </label><label id="discount-SREE5" class="hide"></label></td><td class="colTax" id="col-SREE5-tax"><label id="tax-amount-SREE5">11.5</label> </td><td class="colTotal" id="col-SREE5-total">575</td></tr>
                                        <tr class="rowProduct" id="tr-SREE6"><td class="colNo">65</td><td class="colCode" id="col-SREE6-code">SREE6</td><td class="colCategory" id="col-SREE6-category">Saree</td><td class="colQuantity" id="col-SREE6-quantity">1</td><td class="colMRP" id="col-SREE6-mrp">670</td><td class="colDiscount" id="col-SREE6-discount"><label id="discount-amount-SREE6" class="discount-amount">134</label></td><td class="colTax" id="col-SREE6-tax"><label id="tax-amount-SREE6">24.12</label> </td><td class="colTotal" id="col-SREE6-total">1206</td></tr>
                                        
                                        <tr><td colspan="9">&nbsp;</td>
                                    </tr>
                                    
                                    <tr id="rowProductSummary">
									    <td colspan="2">Total Items: <label id="lblTotalProducts">10</label></td>
									    <td colspan="2">Discount: <label id="lblTotalDiscount">340</label></td>
									    <td colspan="4">Total Amount: ₹ <label id="lblTotalAmount"><strong>5180/-</strong></label></td>
									</tr>    
                                    
                                </table>
                            </div>
	</div>
	
</body>
</html>