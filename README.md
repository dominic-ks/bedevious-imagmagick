# bedevious-imagmagick
WordPress plugin allowing users to edit images on the front end using the ImageMagick Library

Version 0.1 is focused on creating branded montages, example uses are for creating before and after shots

Demo of current version can be seen here: http://stage.bedevious.co.uk/imagemagick/
 - NB. due to Facebooks caching of link share images, this may appear to not work, it depends if I've recently been deleing montages!
 
 IMPORTANT:
 - Must have ImageMagick library installed and imagick modules enabled for php
 - Currently relies on the site using Yoast's WordPress SEO plugin that can be downloaded for free here - https://en-gb.wordpress.org/plugins/wordpress-seo/


Contents of this file:
 - CONTRIBUTIONS - how to contribute to this project
 - USAGE INSTRUCTIONS - how to use the current version of this plugin
 - CURRENT FEATURES - a list of the current features in the master branch
 - ROADMAP - my current to do list!
 - OTHER NOTES AND CREDITS - as it says

//////////////////////////
///////CONTRIBUTIONS//////
//////////////////////////
1. I welcome contributions and working with others. Please send any comments or feedback to contact@bedevious.co.uk
2. If you wish to work on the plugin directly please contact me first at contact@bedevious.co.uk
3. Please read and follow the usage instructions and test the plugin before contacting me


//////////////////////////
////USAGE INSTRUCTIONS////
//////////////////////////

1. Upload the project file to a WordPress installation into /wp-content/plugins
2. Activate the Be Devious ImageMagick plugins
3. Add the shortcode [bedev_show_guillotine] to a page where you want the editor to appear
4. Set the options in the $options array in bedev-imagemagick.php 
  a) NB. 1200 x 628 are given as default dimensions as these are ideal for link share images on Facebook
  b) I have included my Be Devious test overlay in /inc/images/overlay-2.png as an example. 
  c) The 'front-end-path' option is the URL for the page where you placed the plugin
  d) You need a Facebook app ID ( default permissions are fine ), I have left mine as default
4. Go to the the page where you have placed your editor and go


//////////////////////////
/////CURRENT FEATURES/////
//////////////////////////
 - Select two images to make a montage of
 - Rotate, crop and zoom on the front end
 - Submit the images to the server for processing
 - Overlay will be added if specified
 - Montage with overlay will be saved to the WordPress Media Library
 - Upon completion of processing, a Facebook share dialogue will appear showing the montage
 
 
/////////////////////////////////
/////////////ROADMAP/////////////
/////////////////////////////////
 - Create an admin screen to manage options
 - Add various ways of selecting images for montage, e.g. 
    via shortcode, 
    specified in a function that calls the image editor
    pulling Facebook images via the Graph API or other Social Media sites
 - Allow admin users to create their own overlay images in the admin screen
 - Improve overriding of SEO image tags and remove dependancy on Yoast WP SEO plugin
 - Improve overall UX and UI of the image editor


/////////////////////////////////
/////OTHER NOTES AND CREDITS/////
/////////////////////////////////

This plugin makes use of the jQuery Guillotine Plugin - https://github.com/matiasgagliano/guillotine
This plugin contains a gull copy of the jQuery Guillotine Plugin including it's licence detais can be found in /apps/guillotine/README.md