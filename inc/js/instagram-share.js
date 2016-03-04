function bedev_generate_instagram_share( image_id , uniqueID ) {
 
  instagramShareText = '<p id="instagram-share-' + uniqueID + '" style="text-align:center;margin-top:10px;">Currently you can only share images via the Instagram app. Use the link to download the image and share via the app.</p>';
  jQuery( '#' + uniqueID ).parent( '#bedev-available-actions' ).html( instagramShareText );
  
  instagramLink = '<a id="bedev-imagick-instagram-share" ';
  instagramLink += 'class="bedev-imagick-share btn btn-danger" ';
  instagramLink += 'href="' + response.src + '" ';
  instagramLink += 'download="">';
  instagramLink += 'Share on instagram';
  instagramLink += '</a>';
  
  jQuery( '#' + uniqueID ).parent( '#bedev-available-actions' ).html( instagramLink );
  jQuery( instagramLink ).insertAfter( '#instagram-share-' + uniqueID );
  
  jQuery( '#instagram-share-' + uniqueID ).parent( '#bedev-available-actions' ).css( '-webkit-flex-wrap' , 'wrap' ).css( 'flex-wrap' , 'wrap' )
  
}