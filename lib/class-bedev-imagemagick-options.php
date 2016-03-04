<?php

/**
*
* BeDev ImageMagick Options
*
* Class to load the options from the DB
*
* @since 0.0.1
*
**/

class bedev_imagemagick_options {
  
  
  public function __construct() {
    
    //load the options
    $this->options = get_option( 'bedev-imagemagick-options' );
    
    //load Facebook details
    $this->registered_sites = $this->options['bedev_registered_social_sites'];
    
    //load social details
    foreach( $this->registered_sites as $site => $registered_site ) {
      $this->$site = $this->registered_sites[ $site ];
    }
    
    //get the front-end path
    $this->front_end_path = $this->options['front-end-path'];
    
    //get the link share description 
    $this->link_description = $this->options['description'];
  
  }
  
  
  /**
  *
  * Get the image info for a given social network
  *
  * @param str $social_site the social site to get details for
  * @return arr an array of image and app details
  *
  * @since 0.0.1
  *
  **/
  
  public function get_social_network_info( $social_site ) {
        
    $social_array = $this->$social_site;
    
    $social_details = array(
      'app_id' => $social_array['app_id'],
      'montage-overlay' => $social_array['montage-overlay'],
      'image_sizes' => array(
        'width' => $social_array['image-dimensions']['width'],
        'height' => $social_array['image-dimensions']['height'],
      ),
    );
    
    return $social_details;
    
  }
  
  
}