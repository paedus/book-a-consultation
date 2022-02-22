<?php

if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Returns ACF field content in set language version.
 * @param Input string ACF name for English version.
 * @param Output string
 *
 **/
function get_acf_field( $acf_name, $post_id=null ){

	$result = get_field( add_language_suffix($acf_name),$post_id );

	if ( empty( $result ) ) $result = get_field( $acf_name,$post_id );

	return $result;
}

function get_acf_repeater( $repeater_name, $subfields, $page_id=null ){

	if ( have_rows( add_language_suffix( $repeater_name ), $page_id ) ) {

	 return get_acf_repater_loop( add_language_suffix($repeater_name), $subfields, $page_id );

	}

	return have_rows( $repeater_name ) ? get_acf_repater_loop( $repeater_name, $subfields, $page_id ) : array();
}

function get_acf_repater_loop( $repeater_name, $subfields, $page_id=null ){

	$i=0;

	while( have_rows( $repeater_name , $page_id ) ){

		the_row();

		foreach ( $subfields as $subfield ) {


			$result[$i][$subfield] = get_sub_field( $subfield, $page_id );
		
		}

		$i++;
	}

	return $result;
}

function add_language_suffix( $string ){

	return IS_DEFAULT_LANGUAGE ? $string : $string.'_cz';
}

function primary_content_czech_translation($content, $post_id=null ) {

	if ( IS_DEFAULT_LANGUAGE ) return $content;

	$cz_content = get_field('primary_content_cz',$post_id);

	if(is_singular('post')) $cz_content = get_field('primary_content_cz', $post_id, false);

	return empty($cz_content) ? $content : $cz_content;
}

add_filter( 'the_content', 'primary_content_czech_translation',0);

function get_secondary_content_current_lang_version(){

	echo get_acf_field( 'secondary_content' );
}



function get_opinion_content_current_lang_version(){

	?>
	<hr class="just-hr">
	<?=get_acf_field( 'our_opinion' )?>
	<?php

}


if (! is_excluded_from_content_hooks() ){ //deprecated

	//add_action( 'astra_entry_content_after', 'get_opinion_content_current_lang_version',10);

	// add_action( 'astra_entry_content_after', 'get_secondary_content_current_lang_version',10);


}


function is_excluded_from_content_hooks(){ //deprecated

	$excluded_strings = [
		'/accommodations/','/travel/','/lokace/','/locations/','/ubytovani/',
		'/experiences/'

	];

	return has_string( $_SERVER['REQUEST_URI'], $excluded_strings);

}


function get_cz_title( $title ){

	$decoded_title = replace_special_characters_in_title(html_entity_decode($title));

	global $post;

	if ( replace_special_characters_in_title($post->post_title) !== $decoded_title ) return $title;

	$title_cz = get_title_cz( $post->ID );

	return empty($title_cz) ? $title : $title_cz ;
}

//replacement is to match $post->post_title as WP previously manipulate post title characters
function replace_special_characters_in_title($title){

	$swap_characters = array(	'’'	=>	'\'',
								'-'	=>	'–',
								'…'	=> '...'
							);

	foreach ($swap_characters as $search => $replace) {

		$title = str_replace($search, $replace, $title );

	}

	return $title;
}

function get_title_cz( $post_id ){

	return get_metadata('post',$post_id,'title_cz',true);
}

function get_explore_title_cz( $post_id ){

	$title_explore_cz = get_acf_repeater( 'description', ['title','text','country'], $post_id )[1]['country'];

	return empty($title_explore_cz) ?  get_title_cz( $post_id ) : $title_explore_cz  ;
}
if ( !IS_DEFAULT_LANGUAGE ) {

	add_filter ( 'the_title', 'get_cz_title' );

}

function get_title_cz_when_visit_the_place( $description ){

	if ( IS_DEFAULT_LANGUAGE ) return $description['title'];

	return str_replace('[kdy_krajinu_navstivit]', $description['country'], $description['title']);
}

function get_post_lang_version( $post_id ){

	$result['title'] = get_the_title($post_id);

	$result['primary-content'] = get_the_content( null, false, $post_id);

	return $result; 
	
}

function get_post_lang_data( $post_id ){ //deprecated

	$post_data = get_post( $post_id );

	// $featured_image_id = get_post_thumbnail_id($post_id);

	// $excerpt = get_post_excerpt_by_sentences( $post_data['primaty-content'], 200 );

	$date = $post_data['post_date'];

	?><div style="white-space: break-spaces;background-color:#222;color:#ddd;font-family: monospace;"><?php
	var_dump($post_data, 'post data' );
	?></div><?php
	
}

function get_cpt_gallery_lang_data( $posts_ids, $display_location_type='countries' ){

	foreach ( $posts_ids as $key => $post_id ) {

		$result[] = get_single_cpt_gallery_lang_data( $post_id, $display_location_type);

	}
	
	return $result; 
}

function get_single_cpt_gallery_lang_data( $post_id, $display_location_type='countries' ){

	$post_data = get_post( $post_id );

	$post_image_id = get_post_image_id( $post_data->ID );

	$title = get_acf_relationship_title( $post_data );

	$country = $display_location_type ? get_object_name($post_data->ID,$display_location_type) : false;

	return  [	'title'		=> $title,
				'img-id'	=> $post_image_id,
				'country'	=> $country,
				'url' 		=> get_permalink( $post_data->ID)
			];
}

function get_acf_relationship( $field_name ){

	$posts_data = get_acf_field( $field_name );

	foreach ($posts_data as $post_data) {

		$img_id = get_post_thumbnail_id($post_data->ID);
		
		if ( !$img_id ) $img_id = MISSING_IMAGE_PLACEHOLDER;

		$title=get_acf_relationship_title( $post_data );

		$result[]= [	'title'=> $title,
						'img-id'=> $img_id,
						'url' => get_permalink( $post_data->ID)
					];
	}

	return $result; 
	
}

function get_acf_relationship_title( $post_data ){

	if (IS_DEFAULT_LANGUAGE) return $post_data->post_title;

	$title_cz = get_field('title_cz', $post_data->ID );

	return empty($title_cz) ? $post_data->post_title : $title_cz;

}

function get_share_button_lang_version( $text ){

	if (IS_DEFAULT_LANGUAGE) return $text;

	$translations = array( 
		'Share'				=>	'Sdílejte',
		'Share the article'	=>	'Sdílejte článek' 

	);

	foreach ( $translations as $needle => $replacement ){
		
		if ( $text === $needle ) return $replacement;

	}

	return $text;
}

function get_cz_month_name($month_number){

	$months_names = array('leden','únor','březen','duben','květen','červen','červenec','srpen','září','říjen','listopad','prosinec');

	return $months_names[$month_number-1];
}