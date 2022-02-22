<?php

if ( !defined( 'ABSPATH' ) ) exit;


add_action( 'template_redirect', 'adjust_page_content' );


function adjust_page_content() {

	ob_start();

	ob_start( 'move_components_assets_to_header' );

}
 
function move_components_assets_to_header($content){


	$footer_content = explode('</footer>', $content)[1];

	$components_assets_array = get_components_scripts( $footer_content );

	$components_assets_array = array_merge( $components_assets_array,  get_components_styles( $footer_content ) );

	$content = remove_footer_components_assets( $components_assets_array , $content );

	$content = add_assets_to_header( $components_assets_array , $content );

	return $content; 
	
}

function get_components_scripts( $footer_content ){

	preg_match_all('/<script.+?<\/script>/', $footer_content, $output_array);

	foreach (reset($output_array) as $script){

		if ( is_component_asset( $script ) ) $result[] = $script;
	
	}

	return $result ?? array();
}

function get_components_styles( $footer_content ){

	preg_match_all('/<link.+?>/', $footer_content, $output_array);

	foreach (reset($output_array) as $script){

		if ( is_component_asset( $script ) ) $result[] = $script;
	
	}

	return $result ?? array();
}


function is_component_asset( $asset_string ){

	return is_int(strpos( $asset_string, '/components/') );

}

function remove_footer_components_assets( $components, $content ){

	foreach ($components as $component) {
		
		$content=str_replace($component, '', $content);
	}

	return $content;
}

function add_assets_to_header($components,$content){

	$components_string = implode( PHP_EOL, $components );

	return	str_replace('</head>', $components_string.PHP_EOL.'</head>', $content);
}
