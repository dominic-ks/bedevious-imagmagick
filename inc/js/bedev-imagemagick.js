var imageData = Object();
var imageFiles = Object();

function activateGuillotine( socialSite ) {
  
  //lock the height of the imagemagick container
  currentHeight = jQuery( '#bedev-imagemagick-container' ).height();
  jQuery( '#bedev-imagemagick-container' ).css( 'min-height' , currentHeight );
  
  jQuery( '#bedev-imagemagick-container' ).children().fadeOut( 400 , function() {
    jQuery( '#bedev-imagemagick-loader' ).delay( 500 ).fadeIn( 400 ).promise().done( function() {
      
      var availableActions = {
        0: 'rotateLeft',
        1: 'fit',
        2: 'rotateRight',
        3: 'zoomIn',
        4: 'zoomOut',
      };
      var actionSymbols = {
        'rotateLeft' : 'fa-undo',
        'zoomOut' : 'fa-search-minus',
        'fit' : 'fa-refresh',
        'zoomIn' : 'fa-search-plus',
        'rotateRight' : 'fa-repeat',
      }

      //prepare the images
      pictures = jQuery( '.bedev-image-picture' );

      jQuery.each( pictures , function( value ) {
        
        //this picture
        image = jQuery( pictures[ value ] );

        //Arbitrary ID counter
        x = jQuery( image ).attr( 'data-image-control' );

        //generate a new JS image so we can hang functions on it
        newImg = new Image();
        newImg.src = jQuery( image ).attr( 'src' );
        newImg.id = jQuery( image ).attr( 'id' );
        newImg.setAttribute( 'class' , jQuery( image ).attr( 'class' ) + '-guillotine' );
        newImg.setAttribute( 'data-image-control' , x );
        newImg.setAttribute( 'data-image-id' , jQuery( image ).attr( 'data-image-id' )  );
        newImg.imageHold = image;
        
        //ID the starting dimensions
        guillotineWidth = ajax[socialSite].image_sizes.width / 2;
        guillotineHeight = ajax[socialSite].image_sizes.height;
        
        //get the height and width of the image file to help manage the UI later
        imageDimensions = {
          'width' : newImg.width,
          'height' : newImg.height,
        }
        imageFiles[ x ] = imageDimensions;

        //generate uillotine controls
        var controls = '';
        var y = 0;
        controls += '<div class="controls">';
        while( availableActions[ y ] ) {
          controls += '<button id="' + availableActions[y] + '-' + x + '" class="bedev-guillotine-button btn-danger" data-image-control="' + x + '" data-image-action="' + availableActions[y] + '" type="button" title="Rotate left"><i class="fa ' + actionSymbols[ availableActions[y]  ] + '"></i></button>';
          y = y + 1;
        }
        controls += '</div>';

        //place the new image in the parent element
        parentIdentifier = jQuery( image ).parent( '.bedev-image-parent' );
        jQuery( parentIdentifier ).html( newImg );
        jQuery( parentIdentifier ).append( controls );

        //when the src is loaded, guillotine it
        newImg.onload = function() {

          //get the picture number
          number = jQuery( this.imageHold ).attr( 'data-image-control' );
          picture = jQuery( '#thepicture-' + number );

          //initiate the guillotine plugin
          picture.guillotine( { width: guillotineWidth , height: guillotineHeight } );
          jQuery( picture ).css( 'max-width' , 'initial' );
          picture.guillotine( 'fit' );

          //set the button action functions
          var y = 0;
          while( availableActions[ y ] ) {

            jQuery( '#' + availableActions[ y ] + '-' + number ).click( function() {
              action = jQuery( this ).attr( 'data-image-action' );
              number = jQuery( this ).attr( 'data-image-control' );
              jQuery( '#thepicture-' + number ).guillotine( action );
            });

            y = y + 1;

          }

          imageData[ 'image-' + number ] = picture.guillotine('getData');

        }

      });

      //create the montage submission form
      var montageForm = '';
      montageForm += '<form role="form" id="bedev-image-magick-form" action="#" method="post"  enctype="multipart/form-data">';
      montageForm += '<input type="hidden" name="action" value="bedev_do_imagemagick"/>';

      pictures = jQuery( '.bedev-image-picture-guillotine' );
      jQuery.each( pictures , function( value ) {
        arbID = jQuery( pictures [ value ] ).attr( 'data-image-control' );
        wpID = jQuery( pictures [ value ] ).attr( 'data-image-id' );
        montageForm += '<input type="hidden" name="attachment-' + arbID + '" value="' + wpID + '"/>';
      });

      montageForm += '<input type="hidden" name="network" value="' + socialSite + '"/>';
      montageForm += '<input type="hidden" name="number-images" value="2"/>';
      montageForm += '<input type="submit" class="btn btn-danger" id="imagemagick-submit" title="imagemagick-submit">';
      montageForm += '</form>';

      //add the montage submission form
      jQuery( '#bedev-available-actions' ).html( montageForm );

      //bind it's actions
      var options = {
        url: ajax.url,
        beforeSubmit: imagemagickBefore,
        success: imagemagickSuccess,
        data: imageData,
        dataType: 'json',
      }; 

      // bind form using 'ajaxForm' 
      jQuery( '#bedev-image-magick-form' ).ajaxForm( options );
  
      jQuery( '#bedev-imagemagick-loader' ).fadeOut( 400 , function() {
        
        //manage the height of the window
        windowHeight = jQuery( window ).height() * 0.8;
        console.log( 'window: ' + windowHeight );
        
        //use the smaller of the guillotine dimensions and the current width of the container
        currentWidth = jQuery( '#bedev-imagemagick-outer' ).width();
        if( guillotineWidth * 2 > currentWidth ) { widthToUse = currentWidth } else { widthToUse = guillotineWidth * 2 }
        console.log( 'width to use: ' + widthToUse );
        
        //check the height using the estimated current height of the elemtn
        //NB. if widthToUse = guillotineWidth, then heightToCheck will = guillotineHeight
        heightToCheck = guillotineHeight * ( guillotineWidth * 2 / widthToUse );
        console.log( 'height to check: ' + heightToCheck );
        
        jQuery.each( imageFiles , function( imageFile ) {
          if( heightToCheck > windowHeight ) {
            maxWidth = widthToUse * 2 / ( guillotineHeight / windowHeight );
            console.log( 'max width: ' + maxWidth );
            jQuery( '#bedev-imagemagick-container' ).css( 'max-width' , maxWidth + 'px' );
            jQuery( '#bedev-imagemagick-container' ).children().css( 'max-width' , ( maxWidth * 0.6 ) + 'px' );
          } 
        });
        
        jQuery( '#bedev-imagemagick-container' ).delay( 500 ).children().fadeIn( 400 );
        
      });
      
    });
    
  });
  
}


function imagemagickBefore() {
  
  console.log( imageData );
  
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
        
        if( jQuery( window ).width() < 380 ) {
          jQuery( '#bedev-imagemagick-response' ).css( 'max-width' , '100%' );
        }
        
        jQuery( '#bedev-imagemagick-response' ).fadeIn();
      });
      
    }
    
  }
  
}