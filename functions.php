<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


//Constatnts, exeptions, hardcoded settings and IDs here: 
require ( __DIR__ . '/inc/constatnts.php');

//ONLY universal PHP functions here that can be used in any part.
require ( __DIR__ . '/inc/universal-functions.php');

if ( is_admin() ){ // load only back end code



} else { // load only front-end code

	require ( __DIR__ . '/inc/frontend/universal-frontend-functions.php');
	
	require ( __DIR__ . '/inc/frontend/enqueue-assets.php');

	//disable ultimate member CSS and JS on pages that is not used
	require ( __DIR__ . '/inc/frontend/disable-ultimate-member-assets.php');

	require ( __DIR__ . '/inc/frontend/header/header-parts.php');

	require ( __DIR__ . '/inc/frontend/header/mobile-header.php');

	require ( __DIR__ . '/templates/components/icons/icons.php');

	require ( __DIR__.'/inc/lang/czech-translation.php');

	require ( __DIR__ . '/inc/frontend/images-functions.php');

	require ( __DIR__ . '/inc/frontend/analytics.php');
}

// Require here only code you're sure you need on front-end and back-end too

require ( __DIR__ . '/inc/wp-image-thumbnails.php');

require ( __DIR__ . '/inc/query-functions.php');


// Adjust language url, if disabled it breaks website. 
add_filter('flush_rewrite_rules_hard','__return_false'); 



/****************IMPORTANT************************
 * 
 * NO CODE BELOW THIS LINE!!!
 * 
 * ALL CODE HAS TO GO TO INC FOLDER, TO PARTICULAR PART AND
 *
 * SHOULD BE BUNDELED WITH OTHER CODE FOR THE SAME FUNCTIONALITY
 *
 * KEEP THEME CODE CLEAN, TIDY AND EASY TO READ!!!
 *  
 */