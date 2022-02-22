<?php
/*
Template Name: About us
*/

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'slider/slider.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );

require_once (COMPONENTS_PATH.'buttons/button.php' );

require_once ( COMPONENTS_PATH.'hero/hero.php' );



function enqueue_page_css(){

	enqueue_my_style('home-page','/assets/css/about-page.css');
}

add_action('wp_head', 'enqueue_page_css', 20);




add_action('astra_content_before','hero_about_us');

function hero_about_us(){

	the_hero_reduced(
		$args=[	'title'				=> 'About us',
				'img-id' 			=> get_field('header_image_desktop'),
				'img-mobile-id'		=> get_field('header_image_mobile'),
				'display-country'	=> false ]
	);
}


function intro_blocks() {

	$blocks = get_acf_repeater( 'introduction_blocks', ['title','text'] );

	?>

	<section class="about-us-intro-blocks row-fullwidth">

		<?php foreach($blocks as $block) : ?>

			<div class="about-us-intro-block txt-center">
				<h3 class="heading3 prim mb10"><?= $block['title'] ?></h3>
				<p>
					<?= $block['text'] ?>
				</p>
			</div>

		<?php endforeach; ?>

	</section>

	<?php
}


function team_slider() {

	$frontpage_id = get_option('page_on_front');

	global $post;

	$about_page_id = $post->ID;

	$post->ID = $frontpage_id;

	$repeater_data = get_acf_repeater( 'our_team',['name','designation','image'],$frontpage_id);

    $post->ID = $about_page_id;

	$args = array(

		'type'=>'team-gallery',

		'posts-object' => $repeater_data

	);

	?>

	<section class="our-team row-fullwidth mb32">
		<div class="txt-center d-block mb24">
			<div class="paragraph-span prim"><?= get_acf_field('team_carousel_subtitle'); ?></div>
			<h2 class="heading2 black mb20"><?= get_acf_field('team_carousel_title'); ?></h2>
			<?php the_slider($args); ?>
		</div>
		<?php if(false){ //disabled temporarily ?>

		<div class="txt-center">
			<?php the_button('We are hiring','#',$args = array('type'=>'primary','outlined'=> true ));?>
		</div>

		<?php }//end disabled temporarily ?>
	</section>

	<?php
}


function remove_wp_stylistic_from_content($content) {

	$content = preg_replace("/<(p|br|h1|h2|h3|span)[^>]*?(\/?)>/si",'<$1$2>', $content);

	$content = preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);

	$content = str_replace(array( '<span>', '</span>' ), '', $content);

	return $content;

}


function add_classes_to_content_elements($content) {

	$class_list = array( // 'tag' => 'class list'
		'p'                 => 'body-txt mb16 div-center about-default-paragraph',
		'h2'                => 'heading2',
		'h3'                => 'heading3 prim mt24',
		'img'               => 'about-content-img mb10',
		'a'                 => 'prim txt-link',
		'strong'            => 'paragraph-bold'
	);

	$content = append_classes_to_content($content, $class_list, true);

	return $content;

}


function the_section_content( $field_slug ) {

	$content = get_acf_field($field_slug);

	$content = remove_wp_stylistic_from_content($content);

	$content = add_classes_to_content_elements($content);

	echo $content;

}


function our_mission() {
	?>

	<section class="secon-grad about-default-section txt-center row-fullwidth our-mission white sec-pd">

		<div class="container">

			<h2 class="heading2 mb24"><?= get_acf_field('our_mission_title') ?></h2>

			<div class="our-mission-content mb32">
				<?php the_section_content('our_mission_content') ?>
			</div>

			<?php the_media_image(get_field('first_logo'), 'mb24 about-content-logo div-center'); ?>
			<?php the_media_image(get_field('second_logo'), 'about-content-logo div-center mb32'); ?>

		</div>

	</section>

	<?php
}


function our_commitment() {
	?>

		<section class="ter-bg txt-center about-default-section our-commitment row-fullwidth">

			<div class="container">

				<h2 class="heading2 mb24"><?= get_acf_field('our_commitment_title') ?></h2>

				<?php the_section_content('our_commitment_content'); ?>

			</div>

		</section>

	<?php
}


function about_us_content_top() {

	intro_blocks();

	team_slider();

	our_mission();

	our_commitment();

}

add_action('astra_primary_content_top','about_us_content_top');


function about_us_content($content) {

	$content = remove_wp_stylistic_from_content($content);

	$content = add_classes_to_content_elements($content);

	return $content;

}


add_action('the_content','about_us_content');


function the_contact_card_section() {
	?>

	<section class="contact-card-section txt-center mb35">

		<h2 class="heading2"><?= get_acf_field('contact_card_title') ?></h2>

		<p class="about-default-paragraph div-center mb32"><?= get_acf_field('contact_card_text') ?></p>

		<?php the_contact_card('Petr Udavský','co-owner', 'spolumajitel','+420 605 994 655', 21291); ?>

	</section>

	<?php
}


function about_us_content_bottom() {

	the_contact_card_section();

	the_newsletter_sign_up();

}

add_action('astra_primary_content_bottom','about_us_content_bottom');


get_header(); ?>

<div id="primary" <?php astra_primary_class(); ?>>

	<?php astra_primary_content_top(); ?>

	<div class="about-us-main-content sec-pd mb20 txt-center">
		<?php astra_content_page_loop(); ?>
	</div>
	
	<?php astra_primary_content_bottom(); ?>

</div><!-- #primary -->



<?php get_footer(); 


?>
