<?php
/*
*	Template Name: Accommodation
*/

if ( !defined( 'ABSPATH' ) ) exit;

require ( __DIR__ . '/templates/single-product-functions.php');

function the_you_might_also_like(){
 	
	$related_accomodations_ids = get_tag_related_accomodations_ids();

	if ( empty($related_accomodations_ids) ) return the_missing_data('recommended accommodations');

	$args = array(

		'posts_ids'		=>	$related_accomodations_ids,
		
		'sec_title'	=>	'You might also like',
		
		'color_css_class'	=>	''
		);

	the_post_grid_section_with_load_more($args);
}

function the_page_content(){
	
	$short_accomm_name = get_short_accomm_name();

	the_accomm_quick_access('accommodation');

	the_our_opinion();

	the_accomodation_description( $short_accomm_name );

	the_accomodation_gallery("<span>$short_accomm_name</span> <span>Photo Gallery<span>");

	the_video_gallery_section("<span>Watch</span> <span>$short_accomm_name</span> <span>Video</span>", $video_id=false, $color_css_class='ter-bg secon');

	the_cta_section("<span>Do you like</span> <span>$short_accomm_name</span>?");
	
	the_you_might_also_like();

	the_explore_similar_accommodation( $short_accomm_name );

	the_newsletter_sign_up();
	
}

add_action('the_content','the_page_content');

header_footer_container();
