jQuery( document ).ready( function() {
  
  jQuery.ajaxSetup({ cache: true });
  
  jQuery.getScript( '//connect.facebook.net/en_US/sdk.js' , function() {
    
    FB.init({
      appId: facebook.appID,
      version: 'v2.5'
    });
    
  });
  
});
  
function bedev_generate_fb_share( image_id ) {

  FB.ui({
    method: 'share',
    href: ajax.path + '?bedev-share-id=' + image_id,
  }, function( response ){ });
  
}