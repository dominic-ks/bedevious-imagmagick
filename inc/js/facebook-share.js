jQuery( document ).ready( function() {
  
  jQuery.ajaxSetup({ cache: true });
  
  jQuery.getScript( '//connect.facebook.net/en_US/sdk.js' , function() {
    
    FB.init({
      appId: ajax.facebook.app_id,
      version: 'v2.5'
    });
    
  });
  
});
  
function bedev_generate_facebook_share( image_id ) {

  FB.ui({
    method: 'share',
    href: ajax.path + '?bedev-share-id=' + image_id,
  }, function( response ){ });
  
}