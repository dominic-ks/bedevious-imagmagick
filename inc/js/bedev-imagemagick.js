jQuery( document ).ready( function() {
  
  pictures = jQuery( '.bedev-image-picture' );
  
  var imageData = Object();
  var availableActions = {
    0: 'rotateLeft',
    1: 'rotateRight',
    2: 'zoomIn',
    3: 'zoomOut',
    4: 'fit'
  };
  
  jQuery.each( pictures , function( value ) {
    
    //initiate the guillotine plugin
    picture = jQuery( pictures[ value ] );

    //set the starting dimensions
    picture.guillotine( { width: ajax.image_width  , height: ajax.image_height } );
    //picture.guillotine( 'fit' );
    
    //get the picture number
    number = jQuery( picture ).attr( 'data-image-control' );

    //bind all the button actions
    /*jQuery.each( availableActions , function( action ) {
      
      element = '#' + availableActions[ action ] + '-' + number;
      console.log( jQuery( element ) );
      console.log( availableActions[ action ] );
      
      jQuery( element ).click( function() {
        jQuery( pictures[ value ] ).guillotine( availableActions[ action ] );
      });
      
    });*/
    
    jQuery( '#rotateLeft-' + number ).click( function() {
      jQuery( pictures[ value ] ).guillotine( 'rotateLeft' );
    });

    jQuery( '#rotateRight-' + number ).click( function() {
      jQuery( pictures[ value ] ).guillotine( 'rotateRight' );
    });

    jQuery( '#zoomIn-' + number ).click( function() {
      jQuery( pictures[ value ] ).guillotine( 'zoomIn' );
    });

    jQuery( '#zoomOut-' + number ).click( function() {
      jQuery( pictures[ value ] ).guillotine( 'zoomOut' );
    });

    jQuery( '#fit-' + number ).click( function() {
      jQuery( pictures[ value ] ).guillotine( 'fit' );
    });

    imageData[ 'image-' + number ] = picture.guillotine('getData');
    
  });
  
 
  var options = {
    url: ajax.url,
    beforeSubmit: imagemagickBefore,
    success: imagemagickSuccess,
    data: imageData,
  }; 

  // bind form using 'ajaxForm' 
  jQuery( '#bedev-image-magick-form' ).ajaxForm( options ); 
  
  
});


function imagemagickBefore() {
  
  console.log( picture.guillotine('getData') );
  
}

  
function imagemagickSuccess( responseText ) {
  
  console.log( responseText );
  
  response = JSON.parse( responseText );
  
  if( response.status == 'success' ) {
    bedev_generate_fb_share( response.montage );
  }
  
}