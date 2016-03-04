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
	
	//get all the social network details
	//later to be replaced with an option sent in the ajax request
	$all_social_sites = $imagick_options->registered_sites;	
	
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
	
  ob_start(); 
	
	//create a wrapper for the ImageMagick elements
	?>
	<div id="bedev-imagemagick-outer">
		<img id="bedev-imagemagick-loader" alt="bedev-imagemagick-loader" src="<?php echo plugins_url() . '/bedev-imagemagick/inc/images/loading-gif-1.gif'; ?>" style="display:none;"/>
		<div id="bedev-imagemagick-container">
			<div id="bedev-imagemagick-response" style="display:none;"></div>
			<div id="bedev-image-container">
			<?php

		foreach( $images as $key => $image ) {

			//create one image and button set per image
			$image_url = wp_get_attachment_url( $image ); ?>

			<div id="theparent-<?php echo $key; ?>" class="bedev-image-parent">
				<img id="thepicture-<?php echo $key; ?>" class="bedev-image-picture" data-image-control="<?php echo $key; ?>" data-image-id ="<?php echo $image; ?>" src="<?php echo $image_url; ?>">
			</div>

			<?php } ?>

			</div>
			<div id="bedev-available-actions">

				<?php

				foreach( $all_social_sites as $site => $all_social_site ) { ?>

					<button class="button bedev-imagick-share btn btn-danger" onClick="activateGuillotine( '<?php echo $site; ?>' )">Share on <?php echo $site; ?></button>

				<?php } ?>

			</div>

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
* This function generates HTML markup for social share buttons as requested. Called from the ajax handlers file
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
			
		ob_start();

			?><div id="bedev-available-actions"><?php
	
			switch( $social_site ) {
					
				case 'twitter':
					?>
						<script>bedev_generate_twitter_share(<?php echo $image_reference; ?>)</script>
					<?php
					break;
					
				case 'instagram':
					?>
						<script>bedev_generate_instagram_share(<?php echo $image_reference; ?>)</script>
					<?php
					break;
					
				default:
					?>
						<input type="submit" id='bedev-imagick-<?php echo $social_site; ?>-share' class="bedev-imagick-share btn btn-danger" value="Share on <?php echo $social_site; ?>" onClick="bedev_generate_<?php echo $social_site; ?>_share(<?php echo $image_reference; ?>)">
					<?php
					break;
					
			}
			?></div><?php

		$html = ob_get_contents();
		if( $html ) ob_end_clean();
		return $html;
	
}