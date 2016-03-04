jQuery( document ).ready( function() {
  
  window.twttr = ( function( d , s , id ) {
    var js, fjs = d.getElementsByTagName( s )[0],
    t = window.twttr || {};
    if ( d.getElementById( id ) ) return t;
    js = d.createElement( s );
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore( js , fjs );

    t._e = [];
    t.ready = function( f ) {
      t._e.push( f );
    };

    return t;
  }( document , "script" , "twitter-wjs" ) );
  
});

function bedev_generate_twitter_share( image_id , uniqueID ) {
  
  var shareText = encodeURIComponent( ajax.description );
  var shareLink = encodeURIComponent( ajax.path + '?bedev-share-id=' + image_id );
  var twitterLink = 'https://twitter.com/intent/tweet?text=' + shareText + '&url=' + shareLink;
  var linkElement = '<a id="bedev-twitter-link" class="bedev-imagick-share btn btn-danger" href="' + twitterLink + '">Share on twitter</a>';
  
  jQuery( '#' + uniqueID ).parent( '#bedev-available-actions' ).html( linkElement );
  
}