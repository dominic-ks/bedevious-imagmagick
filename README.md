# bedevious-imagmagick
WordPress plugin allowing users to edit images on the front end using the ImageMagick Library

Version 0.1 is focused on creating branded montages, example uses are for creating before and after shots

Demo of current version can be seen here: http://stage.bedevious.co.uk/imagemagick/
 
 IMPORTANT:
 - Must have ImageMagick library installed and imagick modules enabled for php, there is currently no check built in to the plugin. You can check if you have the imagemagick extension included using phpinfo();
 - Currently relies on the site using Yoast's WordPress SEO plugin that can be downloaded for free here - https://en-gb.wordpress.org/plugins/wordpress-seo/
 - There are a number of sub-dependancies with the Yoast SEO plugin, for example, you must:
 * Set up Facebook and Twitter settings in the SEO section of the menu
 * Ensure that a Facebook description is included on the page you are using the shortcode on


Contents of this file:
 - CONTRIBUTIONS - how to contribute to this project
 - USAGE INSTRUCTIONS - how to use the current version of this plugin
 - CURRENT FEATURES - a list of the current features in the master branch
 - ROADMAP - my current to do list!
 - OTHER NOTES AND CREDITS - as it says


///////CONTRIBUTIONS//////
1. I welcome contributions and working with others. Please send any comments or feedback to contact@bedevious.co.uk
2. If you wish to work on the plugin directly please contact me first at contact@bedevious.co.uk
3. Please read and follow the usage instructions and test the plugin before contacting me


////USAGE INSTRUCTIONS////

1. Upload the project file to a WordPress installation into /wp-content/plugins
2. Activate the Be Devious ImageMagick plugins
3. Add the shortcode [bedev_show_guillotine] to a page where you want the editor to appear
 - You can use the "images" argument in the shortcode - this must be two attachment IDs separated by a comma, e.g. [bedev_show_guillotine images="123,456"]
4. Set the options in the $options array in bedev-imagemagick.php 
  a) NB. 1200 x 628 are given as default dimensions as these are ideal for link share images on Facebook
  b) I have included my Be Devious test overlay in /inc/images/overlay-2.png as an example. 
  c) The 'front-end-path' option is the URL for the page where you placed the plugin, or a URL which you wish to share with your generated image
  d) You need a Facebook app ID ( default permissions are fine ), I have left mine as default
4. Go to the the page where you have placed your editor and go


/////CURRENT FEATURES/////
 - Select two images to make a montage of
 - Rotate, crop and zoom on the front end
 - Submit the images to the server for processing
 - Overlay will be added if specified
 - Montage with overlay will be saved to the WordPress Media Library
 - Share a link on Facebook with the og tags replaced with the specified montage image and description
 
 
/////////////ROADMAP/////////////
 - Create an admin screen to manage options
 - Add various ways of selecting images for montage, e.g. 
    via shortcode, 
    specified in a function that calls the image editor
    pulling Facebook images via the Graph API or other Social Media sites
 - Allow admin users to create their own overlay images in the admin screen
 - Add sharing for other social networking sites, e.g. Twitter, Instagram
 - Improve overriding of SEO image tags and remove dependancy on Yoast WP SEO plugin
 - Improve overall UX and UI of the image editor


/////OTHER NOTES AND CREDITS/////

This plugin makes use of the jQuery Guillotine Plugin - https://github.com/matiasgagliano/guillotine
This plugin contains a full copy of the jQuery Guillotine Plugin including it's licence detais can be found in /apps/guillotine/README.
Yoast are awesome and so is their SEO plugin. Even the free version rocks and is developer friendly enough to be fiddled by this here plugin