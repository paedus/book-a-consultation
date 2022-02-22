<?php
/*
Template Name: Homepage
*/

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'slider/slider.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );

require_once (COMPONENTS_PATH.'buttons/button.php' );

require_once ( COMPONENTS_PATH.'hero/hero.php' );

enqueue_my_style('home-page','/assets/css/home-page.css');

add_action('astra_content_before','hero_homepage');

function hero_homepage(){

	$args = [
		'title'	=>	get_acf_field('banner_title'),
		'sub-title'=>	get_acf_field('banner_subtitle'),
		'video-url'=>	get_acf_field('banner_video'),
		'type'		=>	'homepage'

						];

	the_hero_static( $args );
}

function the_home_features_loop(){

	$repeater_array = get_acf_repeater('features',['title','image','description']);

	foreach ($repeater_array as $key => $value) {
		
		?>
		<div class="ast-col-md-4 px10">
			<h3 class="about-subtitle heading3 prim mb16 div-center"><?=$value['title']?></h3>
			<?php if( !empty($value['image']) ) the_media_image($value['image'],'feature-loop-img');?>
			<p class="body-txt white div-center"><?=$value['description']?></p>
		</div>
		<?php
	
	}
}


function the_home_features_section(){

	?>
	<section class="home-about sec-pd secon-grad row-fullwidth">
		<div class="ast-container txt-center">
			<div class="paragraph-span prim"> <?=get_acf_field('features_small_title')?></div>
			<h2 class="heading2 white"> <?=get_acf_field('features_main_title')?></h2>
			<?php
			the_media_image(get_field('features_image'),'home-about-img','medium');
			?>
			<div class="ast-row mb24">
				<?php
				the_home_features_loop();
				?>
			</div>
			<?php
				the_button( 'Book a call', '#', $args = array('type'=>'prim','outlined'=> false, 'cta-button'=> 'bookacall' ));
			?>
		</div>		
	</section>
<?php
}



function the_home_how_we_work_loop(){

	$repeater_array = get_acf_repeater('process_steps',['step','icon','title']);

	foreach ($repeater_array as $key => $value) {
		
		?>
		<div class="home-we-work-block div-center mb24">
			<?php the_media_image( $value['icon'],'steps-img','full'); ?>
			<h3 class="heading3 prim mb8"><?=$value['step']?></h3>
			<div class="body-txt white"><?=$value['title']?></div>
		</div>
		<?php	
	}
}


function the_home_how_we_work(){
	?>
	<section class="home-we-work sec-pd secon-grad row-fullwidth">
		<div class="ast-container txt-center d-block">
			<div class="paragraph-span prim"><?=get_acf_field('process_title')?></div>
			<h2 class="heading2 white"><?=get_acf_field('process_main_title')?></h2>
				<?php

					the_home_how_we_work_loop(); 

					the_button( 'Book a call', '#', $args = array('type'=>'prim','outlined'=> false, 'cta-button'=> 'bookacall' ));
				?>
		</div>	
	</section>
	<?php
}


function the_home_testimonials(){
	
			$args = array(

				'type'=>'customer-review',

				'slider-wrap-css' => 'testimonials-slider',

				'posts-object' => get_acf_repeater('testimonials',['testimonial','name'])

				);
	?>
	
	<section class="home-testimonials sec-pd row-fullwidth ter-bg">
		<div class="ast-container">
			<div class="testimonials-wrap txt-center div-center">
				<div class="paragraph-span prim"><?=get_acf_field('testimonials_title')?></div>
				<h2 class="heading2 mb32 "><?=get_acf_field('testimonials_main_title')?></h2>
				<?php 

				the_media_image(21930,'icon-quotemarks-left div-center d-block mb32');

				the_slider($args);
				
				?>
			</div>
		</div>
	</section>
	<?php
}


function the_home_engage_loop(){
	
	$value_acf_array = get_acf_repeater('enjoy_features',['title','text']);

	if ( empty( $value_acf_array ) ) return;

	foreach ($value_acf_array as $value) {

		?>
		<h3 class="heading3 prim"><?=$value['title']?></h3>
		<div class="body-txt engage-text div-center mb24"><?=$value['text']?></div>
		<?php
	}
}

function the_home_engage(){
	?>
	<section class="home-engage sec-pd ter-bg row-fullwidth">
		<div class="ast-container txt-center">
			<div class="paragraph-span prim"><?=get_acf_field('engage_subtitle')?></div>
			<h2 class="heading2 black mb16"><?=get_acf_field('engage_title')?></h2>
			<?php

				the_media_image(get_field('engage_image'),'mb16');

				the_home_engage_loop(); 

				the_button( 'Book a call', '#', $args = array('type'=>'prim','outlined'=> false,  'button-type'=> true, 'cta-button'=> 'bookacall' ));
			?>
		</div>
	</section>
	<?php
}

function the_home_sustainable_travel(){
	?>
	<section class="home-engage sec-pd ter-bg row-fullwidth">
		<div class="ast-container txt-center">
			<div class="paragraph-span prim"><?=get_acf_field('sustainable_subtitle')?></div>
			<h2 class="heading2 black"><?=get_acf_field('sustainable_title')?></h2>
			<div class="body-txt engage-text div-center"><?=get_acf_field('sustainable_text')?></div>
		</div>
	</section>
	<?php
}

function the_home_our_work(){
	
	$repeater_data = get_acf_repeater('our_work_links',['image','title','link']);

	$args = array(

		'type'=>'our-work-gallery',

		'posts-object' => $repeater_data,

		'slider-wrap-css' => 'cpt-gallery-slider'
	);

	?>
	<section class="home-our-work sec-pd row-fullwidth white-bg">
		<div class="txt-center d-block">
			<div class="paragraph-span prim"><?=get_acf_field('our_work_title')?></div>
			<h2 class="heading2 black mb20"><?=get_acf_field('our_work_main_title')?></h2>

			<?php


			the_slider($args);

			/*the_button( 'Book a consultation', '#', $args = array('type'=>'prim','outlined'=> true, 'button-type'=> true ));*/

			?>
		</div>
	</section>
	<?php
}

function the_home_team(){
	
	$repeater_data = get_acf_repeater( 'our_team',['name','designation','image']);

	$args = array(

		'type'=>'team-gallery',

		'posts-object' => $repeater_data
	);

	?>
	<section class="home-team sec-pd row-fullwidth secon-grad">
		<div class="txt-center d-block">
			<div class="paragraph-span prim"><?=get_acf_field('our_team_title')?></div>
			<h2 class="heading2 white mb20"><?=get_acf_field('our_team_main_title')?></h2>
			<?php
				the_slider($args);
			?>
		</div>
	</section>
	<?php 
}

function get_last_3_posts_data(){
	
	$posts_data = get_posts( ['numberposts' => 3 ] );

	return array_map( 'get_post_data_for_homepage', $posts_data );
}

function get_post_data_for_homepage( $post ){

	$title = IS_DEFAULT_LANGUAGE ? $post->post_title : get_title_cz( $post->ID );

	return 	[	/*'id'		=>	$post->ID,*/
				'url'		=>	get_permalink($post->ID),
				'text'	 	=>	$title,
				'subtitle'	=>	get_post_display_date( $post->post_date),
				'subtitle-icon'	=>	'calendar',
				'img-id'	=>	get_post_thumbnail_id($post->ID)
			];
}	

function get_comments_data( $post_id ){//deprecated?

	$comments_data = get_comments( array( 'post_id' => $post_id ) );

	$comment_like_count = get_comment_likes_count( $comments_data );

	return ['comment_count'=>count($comments_data ).' Comments', 'likes_count' => $comment_like_count.' Likes'];
}

function get_comment_likes_count( $comments_data ){

	$likes_count =0;
	
	foreach ($comments_data as $comment) {

		$likes_count += (int) get_comment_meta( $comment->comment_ID , 'cld_like_count' )[0];
	}

	return $likes_count;
}

function get_post_display_date( $date ){

	$phptime = strtotime( $date );

	if ( IS_DEFAULT_LANGUAGE ) return date('j F', $phptime );

	$post_month = (int) date( 'm', $phptime );

	return date('j', $phptime ).' '.get_cz_month_name($post_month); 
	
}

function the_home_inspiration(){

	$last_3_posts_data = get_last_3_posts_data();

	?>
	<section class="home-inspiration sec-pd white-bg">
		<div class="paragraph-span prim txt-center"><?=get_acf_field('inspiration_subtitle')?></div>
		<h2 class="heading2 black mb20 txt-center"><?=get_acf_field('inspiration_title')?></h2>
		<?php
		the_homepage_inspiration_posts( $last_3_posts_data );

		the_button( 'Get More Inspiration', '/the-explorer/', $args = array('type'=>'prim','outlined'=> true ));
		?>
	</section>
	<?php
}

function the_homepage_inspiration_posts( $posts_data ){
	
	?>
	<div class="ast-row">
	<?php
	foreach ( $posts_data as $post_data ){

		?>
		<div class="ast-col-lg-4 mb35">
			<?php the_card_product($post_data); ?>
			<?php //the_post_with_custom_subtile($post_data); ?>
		</div>
		<?php

	}
	?>
	</div>
	<?php
}

function homepage_content(){

	the_destination_gallery_section( 

		get_acf_field('main_title_destinations'),
		get_acf_field('small_title_destinations')
		/*,$cta_link='#'*/
		);

	the_home_features_section();
	
	the_home_our_work();

	the_home_how_we_work();

	the_home_testimonials();

	the_home_team();

	the_home_inspiration();

	the_home_engage();
	
	//the_home_sustainable_travel();

	the_newsletter_sign_up();
}

add_action('the_content','homepage_content');

get_header(); ?>

<div id="primary" <?php astra_primary_class(); ?>>

	<?php astra_primary_content_top(); ?>

	<?php astra_content_page_loop(); ?>
	
	<?php astra_primary_content_bottom(); ?>

</div><!-- #primary -->



<?php get_footer(); 


?>
