<?php

/**
*
* Display Guillotine Image Editor linked to BeDev ImageMagick
*
* This function is intended to generate the markup for the BeDev ImageMagick montage generator
* It can be called using the [bedev_show_guillotine] shortcode or by calling directly in php
*
* @param $args arr an array of arguments 
*
* @since 0.0.1
*
**/

function bedev_show_guillotine( $args = null ) {
	
	//get the options
	$imagick_options = new bedev_imagemagick_options;
	
	//get the facebook details
	//later to be replaced with an option sent in the ajax request
	$imagic_details = $imagick_options->get_social_network_info( 'facebook' );
	
	//load the images
	
	//check if image ids have been provided in $args, if not use the demo images stored in the DB
	if( !isset( $args['images'] ) ) {
		$images = $imagick_options->options['montage-images'];
	} else {
		
		//check if an array of image IDs has been provided in $args, if so, use it
		if( is_array( $args['images'] ) ) {
			
			if( count( $args['images'] !== 2 ) ) { return 'Please provide 2 image IDs if providing an array.'; }
			$images = $args['images'];
			
		//else if a string has been provided, check if it's appropriate to convert to an array
		} else {
			
			$array_check = substr_count( $args['images'] , ',' );
			if( $array_check !== 1 ) { return 'Please check your image request and only provide 2 image IDs separated by a comma, or an array of image IDs'; }
			$images = explode( ',' , $args['images'] );
			
		}
		
	}
	
	//load the overlay IDs
	if( !isset( $args['overlay'] ) ) {
		$overlay = $imagic_details['montage-overlay'];
	} else {
		$overlay = $args['overlay'];
	}
	
	
  ob_start(); 
	
	//create a wrapper for the ImageMagick elements
	?>
	<img id="bedev-imagemagick-loader" alt="bedev-imagemagick-loader" src="<?php echo plugins_url() . '/bedev-imagemagick/inc/images/loading-gif-1.gif'; ?>" style="display:none;"/>
	<div id="bedev-imagemagick-container">
		<div id="bedev-imagemagick-response" style="display:none;"></div>
		<?php

	foreach( $images as $key => $image ) {

		//create one image and button set per image
		$image_url = wp_get_attachment_url( $image ); ?>

		<div id="theparent-<?php echo $key; ?>" class="bedev-image-parent" style="width: 48%; float: left;margin:2px;">
			<img id="thepicture-<?php echo $key; ?>" class="bedev-image-picture" data-image-control="<?php echo $key; ?>" data-image-id ="<?php echo $image; ?>" src="<?php echo $image_url; ?>">
		</div>

		<?php } ?>
		
		<div id="bedev-available-actions" style="clear:both;padding:10px;">
			<button class="button bedev-imagick-share btn btn-danger" id="facebook-guillotine"onClick="activateGuillotine( 'facebook' )">Share on Facebook</button>
		</div>
		
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
		
		$imagick_options = new bedev_imagemagick_options;
		$social_site = $imagick_options->options['bedev_registered_social_sites'];
		
	}
	
	if( is_array( $social_site ) ) {
		
		foreach( $social_site as $key => $site ) {
			
			$html .= bedev_generate_social_share_html( $attachment_id , $key );
			
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
			
				?>

				<div id="bedev-available-actions" style="clear:both;padding:10px;">
					<input type="submit" id='bedev-imagick-facebook-share' class="bedev-imagick-share btn btn-danger" value="Share on Facebook" onClick="bedev_generate_fb_share(<?php echo $image_reference; ?>)">
				</div>	

				<?php
			
			$html = ob_get_contents();
			if( $html ) ob_end_clean();
			return $html;
			
		break;
			
		default:
		return false;
			
	}
	
}