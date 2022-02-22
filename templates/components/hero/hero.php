<?php


if ( !defined( 'ABSPATH' ) ) exit;

function enqueue_hero_css(){

	enqueue_component_css( __DIR__.'/hero.css' );
}

add_action('wp_head', 'enqueue_hero_css', 20);

function the_hero_slider( $img_ids, $args=array() ){

	require_once ( COMPONENTS_PATH.'slider/slider.php');

	// enqueue_component_css( __DIR__.'/hero.css' );


	$args['overlay'] = false;

	?>

<section class="hero-sec">

	<?php

		$args['type'] = 'hero';
		$args['img-ids'] = $img_ids;

		the_slider( $args );

		the_hero_overlay( $args );

	?>

</section>

	<?php	

}

/**
 * @param args:array
 * 
 * 'img-id' 		desktop/mobile thumbnail
 * 'img-mobile-id'	mobile specific image
 * 'title'			hero title
 * 'sub-title'		hero subtitle
 * 'video-url'		hero video url
 * 'type'			type of overlay, type function starts with "overlay_subheading_"
 **/ 


function the_hero_reduced( $args ){

	// enqueue_component_css( __DIR__.'/hero.css' );

	$images_array = array( 

		'desktop' 	=> $args['img-id'] ?? get_post_image_id(),
		'mobile'	=> $args['img-mobile-id'] ?? null
	
		);

	?>

<div class="hero-wrap hero-reduced">

	<?php

	the_hero_reponsive_image( $images_array, $class='hero-img-reduced',$sizes=array('full','large','smartphone-vertical') );

	the_hero_overlay( $args );

	?>

</div>

	<?php

}

function the_hero_static( $args=false ){

	// enqueue_component_css( __DIR__.'/hero.css' );

	?>

<div class="hero-wrap hero-static">

	<?php

	// 'urll' is way to disable video, change to 'url' and video will work
	if ( !empty($args['video-urll'])) { 


		the_video( ['video-url'=> $args['video-url'], 'class' => 'hero-video']);

	} else {


		$args_image = get_hero_static_image_id();


		$args_image['css-class'] = 'hero-image';

		the_hero_reponsive_image( $args_image );
	
	}

	$args_overlay = [	'type' => $args['type'] ?? 'static_buttons',
						'title'=> $args['title'] ?? null,
						'sub-title' => $args['sub-title']
					];

	the_hero_overlay( $args_overlay );

	?>

</div>

	<?php

}


function get_hero_static_image_id(){

	$desktop_img_id = get_field('header_image_desktop');

	if ($desktop_img_id) return ['desktop' => $desktop_img_id, 'mobile'=> get_field('header_image_mobile')];

	return  ['desktop' => get_post_image_id()];
}

function the_hero_overlay( $args=false ){

	global $post;

	$title = $args['title'] ?? get_acf_relationship_title($post);

	$show_overlay_color = $args['overlay'] ?? true;

	$type = $args['type'] ?? 'country';

	if( $post->post_type === 'landing-page-cities' ) $type = 'country';

	$display_country = $args['display-country'] ?? true;

	if ( $show_overlay_color ) { ?>

	<div class="hero-overlay">

	<?php } ?>

		<div class="hero-content-wrap width-100">

			<h1 class="hero-title heading1 white txt-center mb24"><?=$title?></h1>

			<?php

			$subheading_function_name = 'overlay_subheading_'.$type;

			if ( $display_country === true && is_callable( $subheading_function_name) ) call_user_func( $subheading_function_name, $args );
			?>

		</div>

	<?php if ( $show_overlay_color ) { ?>
	</div><?php
		
	} 

}

function overlay_subheading_static_buttons(){
	
	require_once (COMPONENTS_PATH.'buttons/button.php' );

	?>
	<div class="ast-row div-center cta-buttons mt35">
		<div class="ast-col-sm-6">
			<?php the_button('Book a consultation','#',$args = array('type'=>'primary','class'=>'mb15' ));?>
		</div>
		<div class="ast-col-sm-6">
			<?php the_button('Be inspired','#',$args = array('type'=>'primary','outlined'=> true ));?>
		</div>
	</div>
	<?php
}

function overlay_subheading_homepage($args){

	require_once (COMPONENTS_PATH.'buttons/button.php' );
	
	$button_args = array('type'=>'primary','class'=>'mb15', 'cta-button'=> 'bookacall' );
	
	?>
	<div class="body-txt txt-center white home-subtitle">
		<?=$args['sub-title']?>
	</div>
	<div class="div-center cta-buttons">
			<?php the_button('Book a call','#', $button_args);?>
	</div>
	<?php
}

function overlay_subheading_country(){

	global $post;

	$country_name = (wp_get_post_terms($post->ID,'countries')[0]->name) ?? 'Country';

	if ( empty($country_name) ) $country_name='Country';

	?>
	<div class="hero-location div-center caption-txt white">

		<?php the_icon('map', 6 ); 

		echo $country_name;
		
		?>

	</div>
	<?php
}

//will be deprecated, use the_cta_section_enhanced
function the_cta_section( $text='', $img_id=21833 ){

	?>

<section class="cta-section secon-grad row-fullwidth sec-pd">

	<div class="sec-box div-center">

		<h2 class="cta-section-title heading2 white txt-center mb32"><?=$text?></h2>

		<?php 

//			disabled for experiences page
            if( !is_singular('moments') ) the_media_image( $img_id,'cta-section-img div-center mt16 mb16')

		?>

		<div class="cta-section-btns ast-row div-center">
<?php 
if(false){
//disabled wishlist button
//in product.css search for: remove when button add to wishlist is active  
	?>
			<div class="ast-col-sm-4 mb16-mobile">

				<?php the_button('Add to favorites','#',$args = array('type'=>'primary','outlined'=> true ));?>

			</div>
<?php } ?>
			<div class="ast-col-sm-6 mb16-mobile">

				<?php //bug here
				// the_button('Enquire','#',$args = array('type'=>'primary' ));

				the_button( 'Request', '#', $args = array('type'=>'prim','outlined'=> false, 'cta-button'=> 'sendrequest' ));
				?>

			</div>

			<div class="ast-col-sm-6 mb16-mobile">

				<?php the_share_button( $args = [
						'type'	=>	'primary',
						'text'	=>	'Share',
						'class'	=>	'mb32'
					]);
				?>

			</div>

		</div>				

	</div>

</section>

	<?php

}


function the_cta_section_blogpost( $args ){

	if ( empty( $args['img-id']) ) $args['img-id'] = 21833;

	?>

<div class="cta-section secon-grad row-fullwidth sec-pd">

	<div class="sec-box div-center">

		<h2 class="cta-section-title heading2 white txt-center mb24"><?=$args['title']?></h2>


		<?php
		    //disabled
		    //the_media_image( $args['img-id'],'cta-section-img div-center')
		?>

		<!-- <div class="cta-section-btns ast-row div-center"> -->

			<div class="mb14">

				<?php the_button('Book a call','#',$args = array('type'=>'primary', 'cta-button'=> 'bookacall' ));?>
			</div>

			<?php the_button('Read who we are', get_home_url().'/about/',$args = array('type'=>'primary','outlined'=> true ));?>

	</div>

</div>

	<?php

}



function the_explore_similar( $short_accomm_name ,$args) {

	?>

<div class="explore-similar">

	<div class="ast-container">
		<div class="ast-row">
		<h2 class="explore-similar-title heading2 black txt-center mb35"><span>Click & Explore similar to</span> <span><?=$short_accomm_name?></span></h2>
</div>
		<div class="cta-section-btns ast-flex ast-justify-content-center div-center">

			<?php

			foreach($args as $value) {

				?>

			<div class="explore-similar-btn mb16-mobile">

				<?php the_button( $value['text'], $value['url'], $args = array('type'=>'secondary','outlined'=> true )); ?>

			</div>

			<?php } ?>

		</div>				

	</div>

</div>

	<?php

}

/* <?= ?> */


function the_photo_gallery( $title, $image_ids, $color_css_class='ter-bg secon' ){

?>

<section id="photo-gallery" class="photo-gallery-wrap row-fullwidth sec-pd <?=$color_css_class?>">
	<h2 class="heading2 txt-center mb16"><?=$title?></h2>
	<?php


	require_once ( COMPONENTS_PATH.'slider/slider.php' );


	$args = array(

		'type'=>'wide-rectangle-gallery',

		'slider-wrap-css'=>'wide-rectangle-gallery-slider mb35',

		'img-ids' => $image_ids


	);


	the_slider($args);

	the_button( 'See all photos', 'javascript:void(0)', $args = array('type'=>'prim','outlined'=> true, 'button-type'=> true ));

	//slider displayed in lightbox

	$args = array(

		'type'=>'fullscreen-single',

		'img-ids' => $image_ids,

		'slider-wrap-css' => 'fullscreen-single lightbox-wrap-button hidden'

	);

	add_filter ('inside_slider_wrap', 'close_lightbox_icon_for_filter' );

	the_slider($args);

	remove_filter ('inside_slider_wrap','close_lightbox_icon_for_filter');
	?>

</section>

<?php

}

function close_lightbox_icon_for_filter(){

	the_icon('cancel-white',0,'lightbox-close');

}


/**
 * $args: array
 * 
 * 'ids'
 * 'sec-class' //section addition css classes
 * 'title'
 * 'subtitle'
 * 'button-text'
 * 'button-link'
 * 

[posts-object] => Array
        (
            [0] => Array
                (
                    [title] => Maldives
                    [img-id] => 16032
                    [url] => http://elitevoyage.local/travel/maldives/
                )


 */

function the_accommodation_gallery_section( $args = false ){

    $slider_type = $args['slider-type'] ?? 'cpt-gallery';

	if ( empty( $args ) ) return;

	$section_id_markup = empty( $args['sec-id'] ) ? '' : ' id="'.$args['sec-id'].'" ';

	?>
	<section <?=$section_id_markup?>class="sec-pd destination-gallery row-fullwidth <?=$args['sec-class']?>">
		<?php if ( isset($args['subtitle']) ) { 
			?><p class="txt-center prim mb15 paragraph-span"><?=$args['subtitle']?></p>
		<?php } ?>
		<h2 class="heading2 secon txt-center mb20"><?=$args['title']?></h2>
	<?php

	$slider_args = array(

		'type'=> $slider_type,

		'posts-object' => $args['ids'],

		'slider-wrap-css' => 'cpt-gallery-slider mb35'


	);


	the_slider( $slider_args );

	the_button( $args['button-text'], $args['button-link'] ,$button_args = array('type'=>'prim','outlined'=> true, 'button-type'=> true ));
	

	?></section><?php
}

function the_destination_gallery_section( $title, $subtitle, $cta_link='#' ){
	
		require_once ( COMPONENTS_PATH.'slider/slider.php' );

		require_once ( COMPONENTS_PATH.'cards/cards.php' );

		//Destination of tomorrow has disabled temporarelly linking.
		// to get back links, remove function remove_url_from_post_objects()

		//$post_object = remove_url_from_post_objects( get_acf_relationship( 'trending_destinations'));


		//displays cards wirh links
		$post_object = get_acf_relationship( 'trending_destinations');
		
		$args = array(

			'type'=>'cpt-gallery',

			'posts-object' => $post_object,

			'slider-wrap-css' => 'cpt-gallery-slider'


		);

	?>
	<section class="destination-gallery row-fullwidth white-bg sec-pd">
		<p class="txt-center prim mb15 paragraph-span"><?=$subtitle?></p>
		<h2 class="heading2 secon txt-center mb24"><?=$title?></h2>
		<?php



		the_slider($args);

		/*the_button( 'Explore more destinations', $cta_link , $args = array('type'=>'prim','outlined'=> true, 'button-type'=> true ));*/
		
		?>
	</section>
	<?php
}

function remove_url_from_post_objects( $post_object ){
 	return remove_key_from_multi_array( $post_object, 'url');
}

function remove_key_from_multi_array( $array, $key_to_remove ){
	
	foreach ($array as $key => $value) {
	
		unset( $array[$key][$key_to_remove] );
	
	}

	return $array;
}

function the_video_gallery_section( $title = '', $video_url = false , $color_css_class='' ){

	$youtube_url = get_youtube_url($video_url);

	if ( $youtube_url ){

		the_youtube_video( $youtube_url, $title, $color_css_class );
	
	} else {

		if ( !get_field('video_type_urlfile') ) return;

		$video_file = get_field('video_file');

		if (!$video_file) return;

		the_file_video( $video_file, $title, $color_css_class );

	}

}

function get_youtube_url( $video_url ){

	if ( $video_url ) return $video_url;

	return get_field('moment_video_url');
}

function the_file_video($video_file, $title){
	?>
	file <?=$video_file?><br>
	video section is under construction
	<?php
}

function the_youtube_video( $youtube_url, $title, $color_css_class='' ){

	$youtube_video_id = get_youtube_video_id( $youtube_url );

	?>
	<section id="video" class="video-gallery row-fullwidth sec-pd <?=$color_css_class?>">

		<div class="sec-box">

			<h2 class="heading2 txt-center mb20"><?=$title ?></h2>

			<div class="video-gallery-iframe div-center">

				<iframe class="youtube-embed" width="100%" height="100%" src="https://www.youtube.com/embed/<?=$youtube_video_id ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			</div>

		</div>

	</section>

	<?php
}

function get_youtube_video_id( $youtube_url ){

	preg_match_all('/(?:.*)\s*v=([^?&">]+)|(?:.*u.be\/)(.*)/', $youtube_url, $output_array);

	//ID from full YT video
	if (!empty($output_array[1][0])) return $output_array[1][0];

	//ID from https://youtu.be/xxxxxxxx
	if (!empty($output_array[2][0])) return $output_array[2][0];

	//assumed YT video ID is in input
	return $youtube_url;

}

function the_hero_testimonials_deprecated(){
	
			$args = array(

				'type'=>'customer-review',

				'slider-wrap-css' => 'testimonials-slider mb35',

				'posts-object' => get_acf_repeater('testimonials',['testimonial','name'])

				);
	?>
	
	<section class="testimonials">
		<div class="ast-container d-block">
			<div class="paragraph-span prim txt-center"><?=get_acf_field('testimonials_title')?></div>
			<h2 class="heading2 black mb20 txt-center"><?=get_acf_field('testimonials_main_title')?></h2>

			<?php 

			the_media_image(21930,'icon-quotemarks-left div-center d-block mb15');

			the_slider($args);

			?>
		</div>
	</section>
	<?php
}


function hero_main(){

	$hero_images_ids = get_hero_acf_images();

	if ( $hero_images_ids === false )  $hero_images_ids = array( get_post_thumbnail_id() );

	if ( count($hero_images_ids) === 1 ){
		
		the_hero_static([	'title' => get_the_title(),
							'video-urll' => get_acf_field('banner_video'),
							'img-id'=> reset($hero_images_ids)]
						);
	} else {

		global $post;

		$args['display-country'] = $post->post_type !== 'landing-page';

		$args['first-img-no-ll'] = true;

		the_hero_slider( $hero_images_ids, $args );

	}

}

function get_hero_acf_images(){

	$desktop = get_field('hero_images');

	if ( empty( $desktop ) ) return false;

	$mobile = get_field('hero_mobile');
	
	foreach ( $desktop as $key => $image_id ){

		$result[]=['desktop' => $image_id, 'mobile' => ( $mobile[$key] ?? false ) ];
	
	}

	return $result;
}


function the_our_opinion(){

	$our_opinion = get_acf_field('our_opinion');

	?>
	<section class="our-opinion-sec sec-pd">
		<?php 
		if ( $our_opinion ) the_our_opinion_text( $our_opinion ); 

		the_contact_card('Tomáš Safarik','Private Consultant', 'Private Consultant','+420 735 750 031', 30363); ?>
	</section>
	<?php
}

function the_our_opinion_text( $our_opinion ){
	?>
	<div class="our-opinion-text txt-center prim mb24">
		"<?=$our_opinion?>"
	</div>
	<?php
}

function the_newsletter_sign_up(){

	?>
	<section class="newsletter-signup sec-pd row-fullwidth">
		<div class="newsletter-signup-header txt-center ast-container">
			<div class="paragraph-span prim">Never miss a great travel idea</div>
			<h2 class="heading2 white mb24">Weekly bulletins for explorers only</h2>
			<div class="newsletter-signup-text white div-center mb24">Discover tomorrow’s destinations and travel experiences, before everybody else. Weekly inspiration.</div>
		</div>
		
		<?php

			echo do_shortcode( get_language_ver_newsletter_shortcode() );

			$bg_img_id = 29756;
			
			the_hero_reponsive_image(['desktop'=> $bg_img_id ],'res-img',$sizes=array('full','large','smartphone-vertical'));
		?>
	</section>
	<?php
}

function get_language_ver_newsletter_shortcode(){

	return IS_DEFAULT_LANGUAGE ? '[activecampaign form=76 css=0]':'[activecampaign form=72 css=0]';
}
/**
 * 
 * @param
 * $args: array
 * 
 * posts_ids	=>		posts ids
 * sec_title	=>		title text
 * color_css_class	=> 	css classes for section colors
 * 
**/
function the_post_grid_section( $args ){

	?>
	<section id="explore-similar" class="you-might-also-like row-fullwidth sec-pd <?=$args['color_css_class']?>">
		<div class="ast-container">
			<h2 class="heading2 mb16 div-center txt-center"><?=$args['sec_title']?></h2>
		</div>
		<div class="ast-container">
			<input id="load-more-checkbox" class="hide" type="checkbox" name="">

			<div class="ast-row you-might-also-like-row">
				
				<?php
				foreach ($args['posts_ids'] as $post_id){
				?>
				<div class="ast-col-md-6 ast-col-lg-4 mb35">
					<?php the_related_accommodation_card($post_id); ?>
				</div>
				<?php } ?>
			</div>

			<div class="load-more-btn">
				<label class="load-more-label" for="load-more-checkbox"></label>
				<?php the_button( 'Load more', 'javascript:void(0)', $args = array('type'=>'prim','outlined'=> true)); ?>
			</div>
			
		</div>
	</section>
	<?php

}


function the_post_grid_section_with_load_more( $args ){

	$args['sec_title'] = $args['sec_title'] ?? '';
	
	?>
	<section id="explore-similar" class="you-might-also-like row-fullwidth sec-pd <?=$args['color_css_class']?>">
		<div class="ast-container">
			<h2 class="heading2 mb16 div-center txt-center"><?=$args['sec_title']?></h2>
		</div>
		<div class="ast-container">
			
			<?php display_cards_with_load_more( $args['posts_ids'] ); ?>
			
		</div>
	</section>
	<?php

}

function display_cards_with_load_more( $posts_ids ){
	
	$row_id = rand(0,999);
	
	$post_count = count( $posts_ids );

	?>
	<div class="ast-row you-might-also-like-row">
	<?php
	foreach ( $posts_ids as $key => $post_id ){

		?>
		<div class="ast-col-lg-4 mb35">
			<?php the_related_accommodation_card($post_id); ?>
		</div>
		<?php

		if ( is_third_card($key) ) {

			the_breaker_load_more_for_three_cards ($key,$row_id,$post_count);

			$row_id = rand(0,999);
		}
	}
	?>
	</div>
	<?php
}

function the_breaker_load_more_for_three_cards( $key, $row_id=0, $post_count ){
	
	?>
	</div>
	<input id="load-more-checkbox-<?=$row_id?>" class="hide" type="checkbox" name="">
	<?php
	if ( has_more_to_display( $post_count, $key ) ) {the_load_more_button( $row_id );}
	?>
	<div class="ast-row you-might-also-like-row">
	<?php
}

function the_load_more_button( $row_id ){
	?>
	<div class="load-more-btn">
		<label class="load-more-label" for="load-more-checkbox-<?=$row_id?>"></label>
		<?php 
		the_button( 'Load more', 'javascript:void(0)', array('type'=>'prim','outlined'=> true));
		?>
	</div>
	<?php
}

function has_more_to_display( $post_count, $key ){
	return $post_count > ($key+1);
}

function is_third_card($key){
	
	if ( $key===0 ) return false;

	return ($key+1)/3 == round(($key+1)/3);
}

