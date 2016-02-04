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
* Include the required scrips and CSS for the Guillotine jQuery App
*
* @since 0.0.1
*
**/

function bedev_include_guillotine() {
	wp_enqueue_style( 'guillotine-css' , plugins_url() . '/bedev-imagemagick/apps/guillotine/css/jquery.guillotine.css' );
	wp_enqueue_style( 'bedev-imagemagick-css' , plugins_url() . '/bedev-imagemagick/inc/css/bedev-imagemagick.css' );
	wp_enqueue_script( 'guillotine-js', plugins_url() . '/bedev-imagemagick/apps/guillotine/js/jquery.guillotine.js' , array( 'jquery' ) , '1.0.0' , true  );
	wp_enqueue_script( 'bedev-imagemagick-js', plugins_url() . '/bedev-imagemagick/inc/js/bedev-imagemagick.js' , array( 'jquery' , 'guillotine-js' ) , '0.0.1' , true  );
	wp_enqueue_script( 'jquery-form', array( 'jquery' ) , false , true ); 
	
	$variables = array(
		'url' => admin_url( 'admin-ajax.php' ),
	);

	wp_localize_script( 'guillotine-js' , 'ajax' , $variables );
	
}


add_action( 'wp_enqueue_scripts', 'bedev_include_guillotine' );


/**
*
* Shortcode to display Guillotine Image Editor
*
* @since 0.0.1
*
**/

function bedev_show_guillotine() {
  
  ob_start(); ?>
  
  <div id="theparent" style="width: 100%;">
    <img id="thepicture" src="http://bedevious.wmdstudios.netdna-cdn.com/wp-content/uploads/2015/12/web-background.jpg">
    </div>
      <div id='controls'>
        <button id='rotate-left'  type='button' title='Rotate left'> &lt; </button>
        <button id='zoom-out'     type='button' title='Zoom out'> - </button>
        <button id='fit'          type='button' title='Fit image'> [ ]  </button>
        <button id='zoom-in'      type='button' title='Zoom in'> + </button>
        <button id='rotate-right' type='button' title='Rotate right'> &gt; </button>
      </div>
			<form role="form" id="bedev-image-magick-form" action="#" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="action" value="bedev_do_imagemagick"/>
				<?php wp_nonce_field( 'bedev_do_imagemagick' , '_wp_nonce_bedev_imagemagick' , false , true ) ?>
				<input type="submit" id='imagemagick-submit' title='imagemagick-submit'>
			</form>

  <?php
  $html = ob_get_contents();
	if( $html ) ob_end_clean();
	return $html;
  
}

add_shortcode( 'bedev_show_guillotine' , 'bedev_show_guillotine' );


/**
*
* Handle the AJAX request containing image chop instructions
*
* @since 0.0.1
*
**/

function bedev_do_imagemagick() {
  
	if ( 
	! isset( $_POST['_wp_nonce_bedev_imagemagick'] ) 
	|| ! wp_verify_nonce( $_POST['_wp_nonce_bedev_imagemagick'], 'bedev_do_imagemagick' ) 
	) {

		print 'Security error: either something has gone wrong, or you are being very naughty.';
		exit;

	} else {
	
		echo "What up son?";
		die();
		
	}
  
}

add_action( 'wp_ajax_bedev_do_imagemagick', 'bedev_do_imagemagick' );
add_action( 'wp_ajax_nopriv_bedev_do_imagemagick', 'bedev_do_imagemagick' );
