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
    dataType: 'json',
  }; 

  // bind form using 'ajaxForm' 
  jQuery( '#bedev-image-magick-form' ).ajaxForm( options ); 
  
  
});


function imagemagickBefore() {
  
  console.log( picture.guillotine('getData') );
  
  //lock the height of the imagemagick container
  currentHeight = jQuery( '#bedev-imagemagick-container' ).height();
  jQuery( '#bedev-imagemagick-container' ).css( 'min-height' , currentHeight );
  
  jQuery( '#bedev-imagemagick-container' ).children().fadeOut( 400 , function() {
    jQuery( '#bedev-imagemagick-loader' ).delay( 500 ).fadeIn( 400 );
  });
  
}

  
function imagemagickSuccess( responseText ) {
  
  console.log( responseText );
  
  response = responseText;
  
  //only run if the response object states success
  if( response.status == 'success' ) {
    
    //create a new JS image object and load the src from the server
    montageImage = new Image();
    montageImage.src = response.src;
    
    //set up a function to load only once the image has been downloaded...
    montageImage.onload = function() {
      
      jQuery( '#bedev-imagemagick-loader' ).delay( 500 ).fadeOut( 400 , function() {
        jQuery( '#bedev-imagemagick-response' ).append( montageImage );
        jQuery( '#bedev-imagemagick-response' ).append( response.buttons );
        jQuery( '#bedev-imagemagick-response' ).fadeIn();
      });
      
    }
    
  }
  
}