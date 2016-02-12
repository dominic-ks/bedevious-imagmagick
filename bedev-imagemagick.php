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
include_once( 'lib/class-bedev-image-magick.php' );
include_once( 'lib/seo-overrides.php' );


/**
*
* Add options into the DB
*
* Placeholder until admin options page is created
*
**/

$options = array( 
	'image-dimensions' => array( 'width' => 1200 , 'height' => 628 ), //the size of the montage image that is created, each half will be half the width
	'montage-images' => array( 718 , 719 ), //the IDs of the two images to use in the montage
	'montage-overlay' => 677, //the ID of the image that will be used as an overlay
	'facebook-app' => '1516280175338077', //the ID of your Facebook app that will be used for posting
	'front-end-path' => 'http://stage.bedevious.co.uk/imagemagick/', //the path to the page that you are using for the front end editor
);

update_option( 'bedev-imagick-options' , $options );


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