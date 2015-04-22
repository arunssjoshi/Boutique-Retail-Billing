<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Print Barcodes</title>
 
<link rel="stylesheet" href="/styles/barcode.css" type="text/css" />
<link rel="stylesheet" href="/styles/barcode.css" type="text/css" media="print" /> 
<style type="text/css">
	
</style>
</head>
 
<body id="index" class="home">
	<?php if($products):?>
		<div id="barcodePageWrap">
		<?php foreach($products as $product):?>
				<div class='barcode-box'>
					<div class="header">Daavani Ladies Point</div>
					<div class="subHeader hide"> Attingal Road. Venjaramoodu</div>
					<div class="subHeader">Ph: 09048614877, 09446127327</div>
					<div class="row"></div>
					<div class="category">Churidar</div>
					<div class="properties">Size: XXL, Color: Red</div>
					<div class="mrpBarcode">
						<div class="mrpWrap">
							<div class="mrp">MRP  ₹. <?php echo ceil($product->selling_price / 5) * 5; ?>/-</div>
						</div>
						<div class="barcodeWrap">
							<img class="barcode" src='http://billing.lh/barcode/core/image.php?filetype=PNG&dpi=72&scale=1.9&rotation=0&font_family=Arial.ttf&font_size=8&text=<?php echo $product->product_code;?>
							5&thickness=30&start=NULL&code=BCGcode128' />
						</div>
					</div>
				</div>
		<?php endforeach;?>
		</div>
	<?php endif;?>
	
</body>
</html>