<?php

/*
 * Plugin Name: BeDeViouS ImageMagick
 * Plugin URI: TBC
 * Description: WordPress plugin allowing users to edit images on the front end using the ImageMagick Library
 * Author: BeDevious Web Development
 * Version: 0.0.1
 * Author URI: http://www.bedevious.co.uk
 * License: GPL2+
 * Text Domain: bedev-imagemagick
 * Domain Path: TBC
 */

/**
*
* Load all of the plugin files
*
**/

include_once( 'lib/script-style-loader.php' );
include_once( 'lib/front-end.php' );
include_once( 'lib/ajax-handlers.php' );
include_once( 'lib/class-bedev-imagemagick.php' );
include_once( 'lib/class-bedev-imagemagick-options.php' );
include_once( 'lib/seo-overrides.php' );


/**
*
* Add options into the DB
*
* Placeholder until admin options page is created
*
**/

$bedev_registered_soical_sites = array(
	'facebook' => array(
		'app_id' => '1516280175338077',
		'montage-overlay' => 6126,
		'image-dimensions' => array( 'width' => 1200 , 'height' => 628 ), 
	),
	'twitter' => array(
		'app_id' => 'N/A',
		'montage-overlay' => 6148,
		'image-dimensions' => array( 'width' => 1024 , 'height' => 512 ), 
	),
	'instagram' => array(
		'app_id' => 'N/A',
		'montage-overlay' => 6146,
		'image-dimensions' => array( 'width' => 1080 , 'height' => 1080 ), 
	),
);

$options = array(
	'montage-images' => array( 718 , 719 ), //the IDs of the two images to use in the montage
	'front-end-path' => 'https://stage.bedevious.co.uk/pilatespt/try-the-model-method-for-free/', //the path to the page that you are using for the front end editor
	'description' => 'Try The Model Method Online for free and get two exclusive workouts and sample recipes!', //the description to use when sharing a link
	'bedev_registered_social_sites' => $bedev_registered_soical_sites, //the sites that the admin wants to offer users to share images on
);

update_option( 'bedev-imagemagick-options' , $options );


/**
*
* Re-add ImageMagick Defauilt for WordPress
*
* Specifically to override default to GD by Force Regenerate Thumbnails and use bedev_image_magick to extend functionality
*
* @since 0.0.1
*
**/

function bedev_readd_imagemagick( $image_editors ) {
	
	$imagemagick_ref = 'WP_Image_Editor_Imagick';

	if( !in_array( $imagemagick_ref , $image_editors ) ) {
		array_unshift( $image_editors , $imagemagick_ref );
	}
	
	$image_editors = array( 'bedev_image_magick', 'WP_Image_Editor_GD' );

	return $image_editors;

	}

add_filter( 'wp_image_editors', 'bedev_readd_imagemagick' , 20 );