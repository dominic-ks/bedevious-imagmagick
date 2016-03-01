<?php

/**
*
* BeDev Image Magick Class 
*
* to allow use of V3.0+ params, most notably scaling images up
*
* @since 0.0.1
*
**/

require_once ABSPATH . WPINC . '/class-wp-image-editor.php';
require_once ABSPATH . WPINC . '/class-wp-image-editor-imagick.php';

class bedev_image_magick extends WP_Image_Editor_Imagick {
	
	/**
	*
	* Resize an image
	*
	* Replaces the resize() method for the WP_Image_Editor_Imagick object
	* Specifically required until WordPress supports ImageMagick $bestfit propert since V3.0.0
	*
	* @since 0.0.1
	*
	* @param int $max_w the new width for the image
	* @param int $max_h the new height for the image
	* @param bool $crop whether to crop or upsize the image as required
	* @return obj the current object with resize applied
	*
	**/
	
	public function resizeImage( $max_w, $max_h, $crop = false ) {
		
		$this->image->scaleImage( $max_w, $max_h, true );
		
		return $this->update_size( $max_w, $max_h );
		
	}
	
	
	/**
	*
	* Create a montage
	*
	* Create a montage of multiple images
	*
	* @since 0.0.1
	*
	* @param obj $additional_image the additional image to montage
	* @param arr $dimensions array containing width / height for the montage
	* @return obj a montage image
	*
	**/
	
	public function montage( $additional_image = null , $dimensions = null ) {
		
		if( ! $additional_image ) { return false; }
		
		if( ! $dimensions ) { return false; }
		
		$this->image->addImage( $additional_image->image );
		$montage = $this->image->montageImage( new ImagickDraw() , '+2' , $dimensions['width'] / 2 , 0 , '0' );
		
		return $montage;
		
	}
	
	
	/**
	*
	* Process front end instructions
	*
	* Translates image edit instructions from the front end into values that can be used by WordPress / ImageMagick
	*
	* @since 0.0.1
	*
	* @param arr $instructions instructions received from a front end editor
	* @return arr translated instructions
	*
	**/
	
	public function translate_front_end_instructions( $instructions ) {
		
		$this->bedev_new_image['x'] = $instructions['x'] / $instructions['scale'];
		$this->bedev_new_image['y'] = $instructions['y'] / $instructions['scale'];
		$this->bedev_new_image['width'] = $instructions['w'] / $instructions['scale'];
		$this->bedev_new_image['height'] = $instructions['h'] / $instructions['scale'];
		$this->bedev_new_image['rotate'] = $instructions['angle'];
		
		return $this->bedev_new_image;
		
	}
	
	
	/**
	*
	* Get the Imagick Object
	*
	* Retrieves the Imagick Object from the WP Image Editor and send that sucker back
	*
	* @since 0.0.1
	*
	* @return obj ImageMagick object for this Image Editor Object
	*
	**/
	
	public function get_imagick() {

		return $this->image;
	
	}
	
}