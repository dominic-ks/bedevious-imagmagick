<?php

/**
*
* Shortcode to display Guillotine Image Editor
*
* @since 0.0.1
*
**/

function bedev_show_guillotine() {
	
	//get the options
	$imagick_options = get_option( 'bedev-imagick-options' );
	
	//load the images and overlay IDs
	$images = $imagick_options['montage-images'];
	$overlay = $imagick_options['montage-overlay'];
	
  ob_start(); 

	foreach( $images as $key => $image ) { 

		//create one image and button set per image
		$image_url = wp_get_attachment_url( $image ); ?>

		<div id="theparent-<?php echo $key; ?>" class="bedev-image-parent" style="width: 48%; float: left;margin:2px;">
			<img id="thepicture-<?php echo $key; ?>" class="bedev-image-picture" data-image-control="<?php echo $key; ?>" src="<?php echo $image_url; ?>">
			<div id="controls">
				<button id="rotateLeft-<?php echo $key; ?>" class="rotate-left" data-image-control="rotate-left-<?php echo $key; ?>" type='button' title='Rotate left'> &lt; </button>
				<button id="zoomOut-<?php echo $key; ?>" class="zoom-out" data-image-control="zoom-out-<?php echo $key; ?>" type='button' title='Zoom out'> - </button>
				<button id="fit-<?php echo $key; ?>" class="fit" data-image-control="fit-<?php echo $key; ?>" type='button' title='Fit image'> [ ]  </button>
				<button id="zoomIn-<?php echo $key; ?>" class="zoom-in" data-image-control="zoom-in-<?php echo $key; ?>" type='button' title='Zoom in'> + </button>
				<button id="rotateRight-<?php echo $key; ?>" class="rotate-right" data-image-control="rotate-right-<?php echo $key; ?>" type='button' title='Rotate right'> &gt; </button>
			</div>
		</div>

		<?php } ?>

		<form role="form" id="bedev-image-magick-form" action="#" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="action" value="bedev_do_imagemagick"/>
			
			
			<?php foreach( $images as $key => $image ) { ?>
				<input type="hidden" name="attachment-<?php echo $key; ?>" value="<?php echo $image; ?>"/>
			<?php } ?>	
			
			<input type="hidden" name="number-images" value="<?php echo count( $images ); ?>"/>
			<input type="hidden" name="overlay" value="<?php echo $overlay; ?>"/>
			<?php wp_nonce_field( 'bedev_do_imagemagick' , '_wp_nonce_bedev_imagemagick' , false , true ) ?>
			<input type="submit" id='imagemagick-submit' title='imagemagick-submit'>
		</form>

  <?php
		
  $html = ob_get_contents();
	if( $html ) ob_end_clean();
	return $html;
  
}

add_shortcode( 'bedev_show_guillotine' , 'bedev_show_guillotine' );