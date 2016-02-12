jQuery( document ).ready( function() {
  
  jQuery.ajaxSetup({ cache: true });
  
  jQuery.getScript( '//connect.facebook.net/en_US/sdk.js' , function() {
    
    FB.init({
      appId: 1516280175338077,
      version: 'v2.5'
    });
    
  });
  
});
  
function bedev_generate_fb_share( image_id ) {

  FB.ui({
    method: 'share',
    href: ajax.path + '?bedev-share=' + image_id,
  }, function( response ){ });
  
}