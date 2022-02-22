<?php
/*
*	Template Name: Country
*/

if ( !defined( 'ABSPATH' ) ) exit;

require ( __DIR__ . '/templates/single-product-functions.php');



function the_recommended_itineraries(){
 		
 	//deb(get_post_location_id(),'');

	return;


	if ( empty($related_accomodations_ids) ) {
	
		?>Main tag is empty, section is not displayed. This is a message just for debugging purposes.<?php

		return;
	}

	?>
	<section class="you-might-also-like row-fullwidth element-ll">
		<div class="ast-container">
			<h2 class="heading2 mb20 div-center txt-center">You might also like</h2>
		</div>
		<div class="ast-container">
			<input id="load-more-checkbox" class="hide" type="checkbox" name="">

			<div class="ast-row you-might-also-like-row">
				
				<?php
				foreach ($related_accomodations_ids as $post_id){
				?>
				<div class="ast-col-md-6 ast-col-lg-4 mb35">
					<?php the_related_accommodation_card($post_id); ?>
				</div>
				<?php } ?>
			</div>

			<div class="load-more-btn">
				<label class="load-more-label" for="load-more-checkbox"></label>
				<?php the_button( 'Load more', 'javascript:void(0)', $args = array('type'=>'prim','outlined'=> true, 'class'=> 'hide-desktop')); ?>
			</div>
			
		</div>
	</section>
	<?php
}

function get_locations_of_the_country(){

	$cities_terms = get_the_terms( get_the_ID(), 'cities');

	if ( empty($cities_terms) ) return false;

	foreach($cities_terms as $city) {
	
		$slug = $city->slug;
		
		$args = array(
		'name' => $slug,
		'post_type' => 'landing-page-cities'
		);
		
		$result[] =  get_posts($args)[0]->ID;
	}

	return $result; 

}

function the_country_locations(){

	$locations_of_the_country_ids = get_locations_of_the_country();

	if ( empty($locations_of_the_country_ids) ) {
		
		the_missing_data('Cities of the Country');

		return;
	}

	$locations_of_the_country_data = get_cpt_gallery_lang_data( $locations_of_the_country_ids, $display_country = false);

	$country = get_post_country_name();

	$slug = get_current_post_slug();

	$args = array(
					'ids'			=>	$locations_of_the_country_data,
					'sec-class'		=>	'white-bg secon',
					'title'			=>	'Popular regions <span>of '. $country .'</span>',
					'button-text'	=>	'View all regions',
					'button-link'	=>	'/destinations/?location=' . $slug,
                    'slider-type'   =>  'cpt-gallery-not-loop'
	);

	the_accommodation_gallery_section( $args );

}

function the_page_content(){
	
	$short_accomm_name = get_short_accomm_name();

	the_accomm_quick_access( 'destination', 'countries' );

	the_our_opinion();

	the_country_locations();

	the_accomodation_description( $short_accomm_name );

	the_accomodation_gallery( "<span>Photos from</span> <span>$short_accomm_name</span>");

	the_video_gallery_section("<span>Watch</span> <span>$short_accomm_name</span> <span>Video</span>", $video_id=false, $color_css_class='ter-bg secon');

	the_cta_section("<span>Do you like</span> <span>$short_accomm_name</span>?", $img_id=25090);
	
	the_handpicked_accommodation(  );
 
	// the_recommended_itineraries(); // itineraries are empty

	the_recommended_exepriences();

	the_newsletter_sign_up();

}

add_action('the_content','the_page_content');

header_footer_container();