<?php

if ( !defined( 'ABSPATH' ) ) exit;


function custom_image_sizes() {

	add_image_size('smartphone',414,0, false );
	add_image_size('smartphone-vertical',414,470, true );

	remove_image_size( 'trp-custom-language-flag' );
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );

}

add_action('init', 'custom_image_sizes');

// Add custom sizes to WordPress Media Library
function add_thumbnain_into_menu( $sizes ) {
    return array_merge( $sizes, array(
   	 'smartphone' => __('Smartphone landscape'),
   	 'smartphone-vertical' => __('Smartphone portrait'),
    ) );
}
add_filter( 'image_size_names_choose', 'add_thumbnain_into_menu' );

