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
<?php $excludes = explode(',','8,9,10,11,14,15,16,17,20,21,22,23') ;?>
<body id="index" class="home">
	<?php if($products):?>
		<div id="barcodePageWrap">
		<?php foreach($products as $key => $product):?>
				<div class='barcode-box'>
				<?php if(in_array(7+1, $excludes)):?>
						<div class="header">Daavani Ladies Point</div>
						<div class="subHeader hide"> Attingal Road. Venjaramoodu</div>
						<div class="subHeader">Ph: 09048614877, 09446127327</div>
						<div class="row"></div>
						<div class="category"><?php echo $product->category;?>&nbsp;</div>
						<div class="properties"><?php echo $product->property;?>&nbsp;</div>
						<div class="mrpBarcode">
							<div class="mrpWrap">
								<div class="mrp">MRP  ₹. <?php echo ceil($product->selling_price / 5) * 5; ?>/-</div>
							</div>
							<div class="barcodeWrap">
								<img class="barcode" src='http://billing.lh/barcode/core/image.php?filetype=PNG&dpi=72&scale=1.9&rotation=0&font_family=Arial.ttf&font_size=8&text=<?php echo $product->product_code;?>
								&thickness=30&start=NULL&code=BCGcode128' />
							</div>
						</div>
					<?php endif;?>
				</div>
		<?php endforeach;?>
		</div>
	<?php endif;?>
	
</body>
</html>