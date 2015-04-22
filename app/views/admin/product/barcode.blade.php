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
					<div class="header">Daavani <span>Ladies Point</span>
						<div class="subHeader "> Attingal Road. Venjaramoodu</div>
						<div class="barcode-logo"><img src="<?php echo base_url();?>/images/barcode-logo.png" alt=""></div>
					</div>
					
					<div class="row marginLeft39"></div>
					<div class="category marginLeft39"><?php echo $product->category;?>&nbsp;</div>
					<div class="properties marginLeft39"><i><?php echo $product->property;?>&nbsp;</i></div>
					<div class="mrpBarcode ">
						<div class="mrpWrap">
							<div class="mrp">MRP. ₹ <strong> <?php echo ceil($product->selling_price / 5) * 5; ?>/-</strong></div>
						</div>
						<div class="barcodeWrap">
							<img class="barcode" src='<?php echo base_url();?>/barcode/core/image.php?filetype=PNG&dpi=72&scale=1.9&rotation=0&font_family=Arial.ttf&font_size=10&text=<?php echo $product->product_code;?>
							&thickness=32&start=NULL&code=BCGcode128' />
						</div>
					</div>
				</div>
		<?php endforeach;?>
		</div>
	<?php endif;?>
	
</body>
</html>