<?php  
	if( isset( $notice ) ):
		if ( is_array( $notice['message'] ) ): 
			foreach( $notice['message'] as $each ):
?>
<div class="alert alert-<?php echo $notice['type'];?> alert-dismissable fade in">
	<button data-dismiss="alert" class="close">×</button>
	<strong><?php echo $notice['sub'];?></strong> <?php echo $each;?>
</div>
<?php endforeach;endif;endif;?>