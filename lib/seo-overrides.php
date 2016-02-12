<?php

/**
*
* Replace the og:image content generated by Yoast SEO
*
* If $_GET['bedev-share'] is set, replace the og:image with the image being shared.
*
* @since 0.0.1
*
* @param str $content the additional image to montage
* @return str url for the new og:image
*
**/

function bedev_replace_og_image( $content ) {
	
	if( isset( $_GET['bedev-share'] ) ) {
		$image_url = wp_get_attachment_url( $_GET['bedev-share'] );
		return $image_url;
	}
	
	return $content;
	
}

add_filter( 'wpseo_og_og_image' , 'bedev_replace_og_image' );


/**
*
* Replace the og:url and canonical url content generated by Yoast SEO
*
* If $_GET['bedev-share'] is set, replace the og:url and canconical with the image being shared.
*
* @since 0.0.1
*
* @param str $url url of the current page with query string
* @return str url of the current page with query string
*
**/

function bedev_replace_canonical( $url ) {
	
	if( isset( $_GET['bedev-share'] ) ) {
		
		//get the options
		$imagick_options = get_option( 'bedev-imagick-options' );
		
		//get the path to share
		$path = $imagick_options['front-end-path'];
		
		return $path . '?bedev-share=' . $_GET['bedev-share'];
		
	}
	
	return $url;
	
}

add_filter( 'wpseo_og_og_url' , 'bedev_replace_canonical' );
add_filter( 'wpseo_canonical' , 'bedev_replace_canonical' );


/**
*
* Add additioanl og:image:width and og:image height attributes
*
* NB. this is hooked to 'wpseo_opengraph' action from Yoast WPSEO
*
* @since 0.0.1
*
**/

function bedev_add_og_image_atts() {
	
	if( isset( $_GET['bedev-share'] ) ) {
		
		//get the options
		$imagick_options = get_option( 'bedev-imagick-options' );
		
		//get the montage dimensions
		$imagick_dimensions = $imagick_options['image-dimensions'];

		ob_start(); ?>

		<meta property="og:image:width" content="<?php echo $imagick_dimensions['width'] ?>">
		<meta property="og:image:height" content="<?php echo $imagick_dimensions['height'] ?>">
		<meta property="og:description" content="Be Devious and generate your own before and after and see how you can use the Be Devious ImageMagick plugin on your own website.">

		<?php
		$html = ob_get_contents();
		if( $html ) ob_end_clean();
		echo $html;
		
	}

}

add_action( 'wpseo_opengraph' , 'bedev_add_og_image_atts' );