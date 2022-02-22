<?php

if ( !defined( 'ABSPATH' ) ) exit;

function enqueue_my_style( $handler=false, $file=false ) {

	if (!$handler || !$file ) return;

	$timestamp_query_string = filemtime( get_asset_path( $file ) );

	wp_enqueue_style( $handler, get_asset_uri( $file ), array( ), $timestamp_query_string, false );

}

function enqueue_my_script( $handler=false, $file=false ) {

	if (!$handler || !$file ) return;

	$timestamp_query_string = filemtime( get_asset_path( $file ) );

	wp_enqueue_script( $handler, get_asset_uri( $file ), array( ), $timestamp_query_string, false );

}


// function enqueue_footer_js( $handle=false, $assets_filename=false) {

// 	if (!$handle || !$assets_filename) return;

// 		$script_uri =  trailingslashit( get_stylesheet_directory_uri() ) . $assets_filename;

// 		$script_path = trailingslashit( get_stylesheet_directory() ) . $assets_filename;

// 		$script_query_string = filemtime( $script_path );

// 		wp_enqueue_script( $handle, $script_uri, array() , $script_query_string, true );

// 	}

// add_action ('wp_footer', 'enqueue_footer_js');

function get_asset_uri( $filename ){

	return trailingslashit( get_stylesheet_directory_uri() ) . $filename;
}

function get_asset_path( $filename ){

	return trailingslashit( get_stylesheet_directory() ). $filename;
}

// function enqueue_footer_css( $handle=false, $assets_filename=false) {

// 	if (!$handle || !$assets_filename) return;

// 	enqueue_my_style( $handle, $assets_filename );

// 	}
//add_action ('wp_footer', 'enqueue_footer_css');


function enqueue_component_css( $filepath ){

	$handle = basename($filepath,'.css');

	$filename = get_component_asset_uri( $filepath );
	
	enqueue_my_style( $handle, $filename );
}

function enqueue_component_js( $filepath ){

	$handle = basename($filepath,'.js');

	$filename = get_component_asset_uri( $filepath );
	
	enqueue_my_script( $handle, $filename );
}

function get_component_asset_uri( $filepath ){

	$result = explode('themes/elitevoyage/', str_replace( '\\', '/', $filepath))[1];

	return $result;
}


?>