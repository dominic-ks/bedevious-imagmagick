jQuery( document ).ready( function() {
 
  
  //initiate the guillotine plugin
  picture = jQuery( '#thepicture' );
  
  //set the starting dimensions
  picture.guillotine( { width: 400 , height: 300 } );
  picture.guillotine( 'fit' );

  //bind all the button actions
  jQuery( '#rotate-left' ).click( function() {
    picture.guillotine( 'rotateLeft' );
  });

  jQuery( '#rotate-right' ).click( function() {
    picture.guillotine( 'rotateRight' );
  });

  jQuery( '#zoom-in' ).click( function() {
    picture.guillotine( 'zoomIn' );
  });

  jQuery( '#zoom-out' ).click( function() {
    picture.guillotine( 'zoomOut' );
  });

  jQuery( '#fit' ).click( function() {
    picture.guillotine( 'fit' );
  });
  
  //set up submit form
  var options = {
    url: ajax.url,
    //beforeSubmit: showRequest,
    success: imagemagickSuccess,
    //uploadProgress: onProgress,
   // error: onError
  }; 

  // bind form using 'ajaxForm' 
  jQuery( '#bedev-image-magick-form' ).ajaxForm( options ); 
  
  
});

  
function imagemagickSuccess( responseText ) {

  alert( responseText );

}