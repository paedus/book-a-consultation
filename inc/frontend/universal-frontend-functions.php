<?php

if ( !defined( 'ABSPATH' ) ) exit;

add_filter( 'astra_single_post_navigation_enabled', '__return_false' );


function get_post_location_name( $post_id = false ){

	if ( !$post_id ) {

		$post_id = get_the_ID();
	}

	return get_object_name($post_id,'cities');
}

function get_post_country_name( $post_id = false ){

	if ( !$post_id ) {

		$post_id = get_the_ID();
	}

	return get_object_name($post_id,'countries');
}

function get_object_name($post_id,$post_type){

	return wp_get_object_terms( $post_id, $post_type )[0]->name;
}

function get_post_country_id( $post_id = false ){

	if ( !$post_id ) {

		$post_id = get_the_ID();
	}

	return wp_get_object_terms( $post_id,'countries')[0]->term_id;
}

function the_missing_data($data_type='unknown') {

	if ( IS_PRODUCTION ) return;
	
	?><br>Missing data: <?=$data_type?><br><?php

}

function get_ev_social_links(){

	if (IS_DEFAULT_LANGUAGE) return array(
											'fb'=>'https://www.facebook.com/EliteVoyageIntl',
											'ig'=>'https://www.instagram.com/elitevoyageintl'
										);

	return array(
			'fb'=>'https://www.facebook.com/EliteVoyageIntl',
			'ig'=>'https://www.instagram.com/elitevoyagecz'
		);
}

function get_ev_policy_links(){

	if (IS_DEFAULT_LANGUAGE) return array(
			'terms' => '/wp-content/themes/elitevoyage/assets/pdfs/eve_vseobecne_podminky_en.pdf',
			'data-protection' => '/wp-content/themes/elitevoyage/assets/pdfs/eve_zpracovani_udaju_en.pdf',
			'insurance'=>'/wp-content/themes/elitevoyage/assets/pdfs/pojisteni_en.pdf'
		);

	return array(
			'terms' => '/wp-content/themes/elitevoyage/assets/pdfs/eve_vseobecne_podminky.pdf',
			'data-protection' => '/wp-content/themes/elitevoyage/assets/pdfs/eve_zpracovani_udaju.pdf',
			'insurance'=>'/wp-content/themes/elitevoyage/assets/pdfs/pojisteni.pdf'
		);

}

function append_classes_to_content($content, $class_list, $has_download_link = false) {

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

    $document = new DOMDocument();

    libxml_use_internal_errors(true);

    $document->loadHTML(utf8_decode($content));

    foreach( $class_list as $tag => $classes ) {

        $content = add_class_to_element($document, $tag, $classes, $has_download_link);

    }

    return $content;

}


function add_class_to_element($document, $tag, $classes, $is_download_link) {

    $elements = $document->getElementsByTagName($tag);

    foreach ($elements as $element) {

        $existing_classes = $element->getAttribute('class');

        $element->setAttribute('class', $classes . ' ' . $existing_classes);

        if( $is_download_link && $tag == 'a') $element->setAttribute('download', '');

    }

    $html = $document->saveHTML();

    return $html;
	}

	function set_language_cookie(){
		?>
	<script type="text/javascript">
		function setCookie(cname, cvalue, exdays) {

	    const d = new Date();

	    d.setTime(d.getTime() + (exdays*24*60*60*92)); // Set expires days

	    let expires = "expires="+ d.toUTCString();

	    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

	}

	function is_czech_url() {

	    var pos = location.href.indexOf('cz/')

	    return pos != '-1';

	}

	function set_language_cookie() {

	    if( is_czech_url() ) return setCookie('trp_language', 'cs_CZ', 1);

	    return setCookie('trp_language', 'en_US', 1);

	}

	set_language_cookie();
	</script>

	<?php
}

add_action('wp_footer','set_language_cookie');


function get_var($name) {

    if( isset($_GET[$name]) ) return esc_html( strip_tags($_GET[$name]) );

    return false;

}

function replace_form_language_links( $form_content ){

	if (IS_DEFAULT_LANGUAGE) return $form_content;

	$replace_string = array(	'eve_zpracovani_udaju_en.pdf'	=>	'eve_zpracovani_udaju.pdf'

							);

	foreach ($replace_string as $search => $replace) {

		$form_content = str_replace($search, $replace, $form_content );

	}

	return $form_content;

}