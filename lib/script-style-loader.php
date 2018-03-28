<?php

/**
*
* Include all required scripts and styles
*
* @todo get the name of the plugin folder dynamically
*
* @since 0.0.1
*
**/

function bedev_include_files() {
	
	global $post;
	
	if( ! has_shortcode( the_content() , 'bedev_show_guillotine' ) ) {
		return;
	}
	
	wp_enqueue_style( 'guillotine-css' , plugins_url() . '/bedev-imagemagick/apps/guillotine/css/jquery.guillotine.css' );
	wp_enqueue_style( 'bedev-imagemagick-css' , plugins_url() . '/bedev-imagemagick/inc/css/bedev-imagemagick.css' );
	wp_enqueue_style( 'bedev-font-awesome' , 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	wp_enqueue_script( 'guillotine-js', plugins_url() . '/bedev-imagemagick/apps/guillotine/js/jquery.guillotine.js' , array( 'jquery' ) , '1.0.0' , true  );
	wp_enqueue_script( 'bedev-imagemagick-js', plugins_url() . '/bedev-imagemagick/inc/js/bedev-imagemagick.js' , array( 'jquery' , 'guillotine-js' , 'bedev-facebook-share' ) , '0.0.1' , true  );
	wp_enqueue_script( 'jquery-form', array( 'jquery' ) , false , true );
	
	//get the options
	$imagick_options = new bedev_imagemagick_options;
	
	//get all the social network details
	$all_social_sites = $imagick_options->registered_sites;	
	
	//get the front end path for the image editor
	$path = $imagick_options->options['front-end-path'];
	
	//get the pre-defined share text in case it's required front end
	$text = $imagick_options->link_description;
	
	$variables = array(
		'url' => admin_url( 'admin-ajax.php' ),
		'path' => $path,
		'description' => $text,
	);
	
	foreach( $all_social_sites as $site => $all_social_site ) {
		
		//set variables to send to the front end
		$variables[ $site ] = $imagick_options->get_social_network_info( $site );
		
		//enqueue social network specific scripts
		wp_enqueue_script( 'bedev-' . $site . '-share', plugins_url() . '/bedev-imagemagick/inc/js/' . $site . '-share.js' , array( 'jquery' ) , '0.0.1' , true  );
		
	}
	
	wp_localize_script( 'guillotine-js' , 'ajax' , $variables );
	
}

add_action( 'wp_enqueue_scripts', 'bedev_include_files' );