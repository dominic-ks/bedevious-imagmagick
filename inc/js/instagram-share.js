function bedev_generate_instagram_share( image_id ) {
 
  instagramShareText = '<p style="text-align:center;margin-top:10px;">Currently you can only share images via the Instagram app. Use the link to download the image and share via the app.</p>';
  jQuery( instagramShareText ).appendTo( '#bedev-imagemagick-response' );
  
  instagramLink = '<a id="bedev-imagick-instagram-share" ';
  instagramLink += 'class="bedev-imagick-share btn btn-danger" ';
  instagramLink += 'href="' + response.src + '" ';
  instagramLink += 'download="">';
  instagramLink += 'Share on instagram';
  instagramLink += '</a>';
  
  jQuery( '#bedev-available-actions' ).html( instagramLink );
  
}