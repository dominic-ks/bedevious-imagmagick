<?php

/**
*
* Do ImageMagick
*
* Handle the AJAX request containing image chop instructions, then create and save a branded montage
*
* @since 0.0.1
*
**/

function bedev_do_imagemagick() {
  
	if (
	! isset( $_POST['_wp_nonce_bedev_imagemagick'] ) 
	|| ! wp_verify_nonce( $_POST['_wp_nonce_bedev_imagemagick'], 'bedev_do_imagemagick' ) 
	) {

		$response = array( 
			'status' => 'error',
			'message' => 'Security error: either something has gone wrong, or you are being very naughty.',
		);

	} else {
		
		//get the options
		$imagick_options = get_option( 'bedev-imagick-options' );
		
		//get the montage dimensions
		$imagick_dimensions = $imagick_options['image-dimensions'];
		
		//create and process all images received according to their received instructions
		for( $x = 0; $x < $_POST['number-images']; $x++ ) {
		
			//get the path to the file
			$bedev_new_image_path = get_attached_file( $_POST['attachment-' . $x] );

			//get the image editor
			$bedev_image_edit['image-' . $x] = wp_get_image_editor( $bedev_new_image_path );
			
			//get the edit instructions
			$bedev_new_image = $bedev_image_edit['image-' . $x]->translate_front_end_instructions( $_POST['image-' . $x] );

			//process the image according to instructions
			//rotate
			$bedev_image_edit['image-' . $x]->rotate( 360 - $bedev_new_image['rotate'] );

			//crop
			$bedev_image_edit['image-' . $x]->crop( 
				$bedev_new_image['x'],
				$bedev_new_image['y'],
				$bedev_new_image['width'],
				$bedev_new_image['height']
			);

			//resize it to the required size, N.B. image will be enlarged if required
			$resize = $bedev_image_edit['image-' . $x]->resizeImage( $imagick_dimensions['width'] / 2 , $imagick_dimensions['height'] , true );
			
		}
		
		//create the montage
		$master_image = $bedev_image_edit['image-0'];
		$additional_image = $bedev_image_edit['image-1'];
		$montage = $master_image->montage( $additional_image );
		
		//add the overlay if there is one
		if( isset( $_POST['overlay'] ) ) {
			$overlay_path = new Imagick ( get_attached_file( $_POST['overlay'] ) );
			$montage->compositeImage( $overlay_path , Imagick::COMPOSITE_DEFAULT , 0 , 0 );
		}
		
		$path = wp_upload_dir();
		$path = $path['path'];
		
		//save the result temporarily
		$bedev_image_path = $master_image->generate_filename( 'montage' , $path , 'jpg' );
		$montage->writeImage( $bedev_image_path );
		
		//process into WordPress
		if ( !function_exists('media_handle_upload') ) {
			require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
		}
		
		//store and process the image into WordPress
		//NB it's expected that media_handle_sideload() will also delete the tmp file we save earlier
		$file_array = array(
			'tmp_name' => $bedev_image_path,
			'name' => basename( $bedev_image_path ),
			'type' => 'image/jpeg',
			'error' => 0,
			'size' => filesize( $bedev_image_path ),
		);
		$id = media_handle_sideload( $file_array , 0 );
		
		$unique_ref = time();
		
		//save a random identifier in the images meta data
		update_post_meta( $id , 'share-identifier' , $unique_ref );
		
		//get the image src
		$image_src = wp_get_attachment_url( $id );
		
		//generate social share buttons that have been registered by the administrator
		$social_buttons = bedev_get_social_share_button( $id );
		
		$response = array(
			'status' => 'success',
			'montage' => $unique_ref,
			'src' => $image_src,
			'buttons' => $social_buttons,
		);
		
	}

		echo json_encode( $response );
		die();
  
}

add_action( 'wp_ajax_bedev_do_imagemagick', 'bedev_do_imagemagick' );
add_action( 'wp_ajax_nopriv_bedev_do_imagemagick', 'bedev_do_imagemagick' );