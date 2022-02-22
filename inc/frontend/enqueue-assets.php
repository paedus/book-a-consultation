<?php

if ( !defined( 'ABSPATH' ) ) exit;

require (__DIR__.'/enqueue-assets-functions.php');

require ( __DIR__ . '/move-components-assets-to-header.php');


/**
 * Static CSS load based on page ID or template 
**/

function enqueue_static_css() {


	$css_to_enqueue = array(	'main-style' => 'style.css' ,
								'default-styles'=>'assets/css/default-styles.css'
							);

	foreach ($css_to_enqueue as $handle => $filename ) {
		
		enqueue_my_style( $handle, $filename );
	
	}
	

}

add_action( 'wp_print_styles', 'enqueue_static_css',10 );


function load_website_fonts(){
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,300&display=swap" rel="stylesheet">
	<?php
}

add_action ('wp_head','load_website_fonts');

function disable_already_enqueued_styles() {

	/* 0 disable everywhere*/
	/* positive ID of the page that is ALLOWED otherwise disabled*/
	/* negative ID of the page will DISABLE only on given page*/
	$page_id = get_the_ID();
	// deb($page_id);

	$css_disable=array(
			'wp-block-library'=> 0,
			'astra-theme-css' => 0,
			'astra-menu-animation' => 0,
			'astra-contact-form-7' => 0,
			'trp-language-switcher-style'=>0,
			/*'um_fonticons_ii' => 0,
			'um_fonticons_fa' => 0,
			'select2' => -693,
			'um_crop' => -693,
			'um_modal' => -693,
			'um_styles'=> -693,
			'um_profile'=> -693,
			'um_account'=> -693,
			'um_misc'=> -693,
			'um_fileupload'=> -693,
			'um_datetime'=> -693,
			'um_datetime_date'=> -693,
			'um_raty'=> -693,
			'um_scrollba'=> -693,
			'um_tipsy'=> -693,
			'um_responsive'=> -693,
			'um_default_css' => -693,*/

			);

	foreach ($css_disable as $key => $value) {
		
		if (!is_numeric($key)) { //deb('pos');
			$handler = $key;
			$disable_style=false;
			$disabled_style_already = false;
		}
		
		if ($value>=0) { //deb('neg');
			if ($value != $page_id or $value=0) { //disable if page ID is not on list
				$disable_style = true;
			} 
		} else {    
			$value = abs($value); //turn negative number to positive    
			if ($value == $page_id) { //disable if psge ID is on the list
				$disable_style = true;
			}
		}

		if ($disable_style and !$disabled_style_already) {
			wp_dequeue_style($handler); 
			wp_deregister_style($handler);
			$disabled_style_already = true;
			//deb( $handler,$page_id); //debug
		}
	}
}

add_action( 'wp_print_styles', 'disable_already_enqueued_styles', 100 );




// update to public.js
//enqueue_js_footer_assets('js-update','js-update.js');

// enqueue_css_footer_assets('css','image-slider.css');





// function remove_unnecessary_css(){

// 	$handles = array( 'astra-theme-css', 'wp-block-library','astra-contact-form-7' );

// 	foreach ($handles as $handle) {

// 		wp_dequeue_style( $handle );

// 	}
// }

// add_action( 'wp_print_styles', 'remove_unnecessary_css', 10 );




