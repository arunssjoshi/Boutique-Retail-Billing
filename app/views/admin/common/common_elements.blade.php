@extends('layout.admin.popup')
@section('content')
<section class="content">
<?php 
if($type == 'message-danger'):?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $message;?>
</div>

<?php endif;?>
<?php if (isset($filter['resize_popup'])):?>
	<script type="text/javascript">
		$(document).ready(function(){
			parent.$.fn.colorbox.resize({innerHeight:$('.alert').height()+95});
		})
		
	</script>
<?php endif;?>
@stop