<?php

/**
*
* Include all required scripts and styles
*
* @since 0.0.1
*
**/

function bedev_include_files() {
	wp_enqueue_style( 'guillotine-css' , plugins_url() . '/bedev-imagemagick/apps/guillotine/css/jquery.guillotine.css' );
	wp_enqueue_style( 'bedev-imagemagick-css' , plugins_url() . '/bedev-imagemagick/inc/css/bedev-imagemagick.css' );
	wp_enqueue_style( 'bedev-font-awesome' , 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	wp_enqueue_script( 'guillotine-js', plugins_url() . '/bedev-imagemagick/apps/guillotine/js/jquery.guillotine.js' , array( 'jquery' ) , '1.0.0' , true  );
	wp_enqueue_script( 'bedev-imagemagick-js', plugins_url() . '/bedev-imagemagick/inc/js/bedev-imagemagick.js' , array( 'jquery' , 'guillotine-js' , 'bedev-facebook-share' ) , '0.0.1' , true  );
	wp_enqueue_script( 'jquery-form', array( 'jquery' ) , false , true ); 
	wp_enqueue_script( 'bedev-facebook-share', plugins_url() . '/bedev-imagemagick/inc/js/facebook-share.js' , array( 'jquery' ) , '0.0.1' , true  );
	
	//get the options
	$imagick_options = get_option( 'bedev-imagick-options' );

	//get the montage dimensions
	$imagick_dimensions = $imagick_options['image-dimensions'];
	
	//get the front end path for the image editor
	$path = $imagick_options['front-end-path'];
	
	$variables = array(
		'url' => admin_url( 'admin-ajax.php' ),
		'image_width' => $imagick_dimensions['width'] / 2,
		'image_height' => $imagick_dimensions['height'],
		'path' => $path,
	);

	wp_localize_script( 'guillotine-js' , 'ajax' , $variables );
	
}

add_action( 'wp_enqueue_scripts', 'bedev_include_files' );