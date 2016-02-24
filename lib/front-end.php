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
	
	//create a wrapper for the ImageMagick elements
	?>
	<div id="bedev-imagemagick-container">
		<img id="bedev-imagemagick-loader" alt="bedev-imagemagick-loader" src="<?php echo plugins_url() . '/bedev-imagemagick/inc/images/loading-gif-1.gif'; ?>" style="display:none;"/>
		<div id="bedev-imagemagick-response" style="display:none;"></div>
	<?php

	foreach( $images as $key => $image ) {

		//create one image and button set per image
		$image_url = wp_get_attachment_url( $image ); ?>

		<div id="theparent-<?php echo $key; ?>" class="bedev-image-parent" style="width: 48%; float: left;margin:2px;">
			<img id="thepicture-<?php echo $key; ?>" class="bedev-image-picture" data-image-control="<?php echo $key; ?>" src="<?php echo $image_url; ?>">
			<div id="controls">
				<button id="rotateLeft-<?php echo $key; ?>" class="rotate-left" data-image-control="rotate-left-<?php echo $key; ?>" type='button' title='Rotate left'><i class="fa fa-undo"></i></button>
				<button id="zoomOut-<?php echo $key; ?>" class="zoom-out" data-image-control="zoom-out-<?php echo $key; ?>" type='button' title='Zoom out'><i class="fa fa-search-minus"></i></button>
				<button id="fit-<?php echo $key; ?>" class="fit" data-image-control="fit-<?php echo $key; ?>" type='button' title='Fit image'><i class="fa fa-refresh"></i></button>
				<button id="zoomIn-<?php echo $key; ?>" class="zoom-in" data-image-control="zoom-in-<?php echo $key; ?>" type='button' title='Zoom in'><i class="fa fa-search-plus"></i></button>
				<button id="rotateRight-<?php echo $key; ?>" class="rotate-right" data-image-control="rotate-right-<?php echo $key; ?>" type='button' title='Rotate right'><i class="fa fa-repeat"></i></button>
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
		
	</div>
		
	<?php
  $html = ob_get_contents();
	if( $html ) ob_end_clean();
	return $html;
  
}

add_shortcode( 'bedev_show_guillotine' , 'bedev_show_guillotine' );


/**
*
* Social share button generator
*
* This function generates HTML markup for social share buttons as requested
*
* @since 0.0.1
*
* param str $attachment_id the ID of the image that is to be shared
* param str|arr $social_site the social site(s) that a button is requested for default 'all'
* return str HTML markup for a social share button
*
**/

function bedev_get_social_share_button( $attachment_id , $social_site = 'all' ) {
	
	if( $social_site == 'all' ) {
		
		$options = $imagick_options = get_option( 'bedev-imagick-options' );
		$social_site = $options['bedev_registered_social_sites'];
		
	}
	
	if( is_array( $social_site ) ) {
		
		foreach( $social_site as $site ) {
			
			$html .= bedev_generate_social_share_html( $attachment_id , $site );
			
		}
		
	} elseif( is_string( $social_site ) ) {
		
		$html = bedev_generate_social_share_html( $attachment_id , $social_site );
		
	}
	
	return $html;
	
}


/**
*
* Generate social share mark-up
*
* This function generates HTML markup for a requested social share button
*
* @since 0.0.1
*
* param str $attachment_id the ID of the image that is to be shared
* param str $social_site the social site(s) that a button is requested for
* return str HTML markup for a social share button
*
**/

function bedev_generate_social_share_html( $attachment_id = null , $social_site = null ) {
	
	if( $attachment_id === null || $social_site === null ) {
		return false;
	}
	
	//get the unique image ref
	$image_reference = get_post_meta( $attachment_id , 'share-identifier' , true );
	
	switch( $social_site ) {
		
		case 'facebook':
			
			ob_start();
			
				?><input type="submit" id='bedev-idimagick-facebook-share' class="bedev-idimagick-share" value="Share on Facebook" onClick="bedev_generate_fb_share(<?php echo $image_reference; ?>)"><?php
			
			$html = ob_get_contents();
			if( $html ) ob_end_clean();
			return $html;
			
		break;
			
		default:
		return false;
			
	}
	
}