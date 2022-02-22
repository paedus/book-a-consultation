<?php

if ( !defined( 'ABSPATH' ) ) exit;


/**
 * @param string $haystack
 * @param string|array $needle
 *
 * @param output boolean
**/

function has_string( $haystack, $needle ){

	if ( !is_array($needle) ) return is_int( strpos($haystack, $needle) );

	foreach ($needle as $value) {

		if ( strpos( $haystack, $value) !== false ) return true;
	
	}

	return false;
}


//Contact Form Confirmation Translate
add_filter('fluentform_submission_confirmation', 'custom_code_before_confirmation_msg_function', 10, 3);

function custom_code_before_confirmation_msg_function($returnData, $form, $confirmation )
{

    $ty_messages = explode('[cz_version]', $returnData['message']); // [0] - english version // [1] Czech version

    $returnData['message'] = $ty_messages[1];

    if( strpos($_SERVER['HTTP_REFERER'], 'cz') === false ) $returnData['message'] = $ty_messages[0];

    return $returnData;
}

