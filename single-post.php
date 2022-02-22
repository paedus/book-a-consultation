<?php
/*
*   Template Name: Posts
*/

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'slider/slider.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );

require_once ( COMPONENTS_PATH.'hero/hero.php' );

function enqueue_post_css(){

	enqueue_my_style('products','/assets/css/single-post.css');
}

add_action('wp_head', 'enqueue_post_css');

function single_post_before_content_func() {

	$desktop_img_id = get_field('header_image_desktop');

	if ( empty($desktop_img_id) ) $desktop_img_id = 24243;

	the_hero_reduced(
		$args=[
			'title'             => get_the_title(),
			'img-id'            => $desktop_img_id,
			'img-mobile-id'		=> get_field('header_image_mobile'),
			'display-country' => false
		]
	);

}

add_action('astra_content_before','single_post_before_content_func');


function remove_style_attribute_by_tag($content) {

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

    $document = new DOMDocument();

    $document->loadHTML(utf8_decode($content));

    $tags_array = array('p', 'br', 'h1', 'h2', 'h3', 'span');

    foreach($tags_array as $tag) {

        $content = remove_attribute_from_tag($document, $tag);

    }

    return $content;

}


function add_class_to_tag($element, $class) {

    $existing_classes = $element->getAttribute('class');

    $element->setAttribute('class', $class . ' ' . $existing_classes);

    return $element;

}


function remove_attribute_from_tag($document, $tag) {

    $elements = $document->getElementsByTagName($tag);

    foreach ($elements as $element) {

        $element_style_attr = $element->getAttribute('style');

        if( strpos($element_style_attr, 'text-align: center') !== false ) $element = add_class_to_tag($element, 'txt-center');

        $element->removeAttribute('style');

    }

    $html = $document->saveHTML();

    return $html;

}


function remove_wp_stylistic_from_content($content) {

    $content = remove_style_attribute_by_tag($content);

//	$content = preg_replace("/<(p|br|h1|h2|h3|span)[^>]*?(\/?)>/si",'<$1$2>', $content);

	$content = preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);

	$content = str_replace(array( '<span>', '</span>' ), '', $content);

	return $content;

}


add_shortcode( 'cta_block', 'cta_block_func' );

function cta_block_func( $atts, $content ) {

    return get_cta_block_content();
}


add_shortcode( 'excerpt', 'excerpt_func' );

function excerpt_func( $atts, $content ) {
	ob_start();?>

	<div class="text_with_line">
		<h3 class="heading3"><?= $content ?></h3>
	</div>

	<?php
	$content = ob_get_clean();

	return $content;
}

add_shortcode( 'quote', 'quote_func' );

function quote_func( $atts, $content ) {
	ob_start();?>

	<div class="post_quote txt-center">
		<?php the_media_image(21930,'quotemarks-left'); ?>
		<h3 class="heading3"><?= $content ?></h3>
		<?php the_media_image(21930,'quotemarks-left'); ?>
	</div>

	<?php
	$content = ob_get_clean();

	return $content;
}


add_action('astra_primary_content_top','the_date_with_icon');

function the_date_with_icon() {
	?>

	<div class="txt-center mt32 mb32">
		<?php the_icon('calendar', 10 ); ?>
		<span class="caption-txt secon">

			<?php the_date( get_date_format_based_on_language() ); ?>

		</span>
	</div>

	<?php
}

function get_date_format_based_on_language(){

	//Czech version displays number of the month
	return IS_DEFAULT_LANGUAGE ? 'j-M-Y' : 'j-m-Y';
}

function related_products_slider( $products_object ) {

	$args = array(

		'type'=> 'cpt-gallery-not-loop',

		'posts-object' => $products_object,

		'slider-wrap-css' => 'cpt-gallery-slider mb35'

	);

	the_slider($args);

}


function the_related_products_carousel() {

	$post_tags = wp_get_post_tags(get_the_id());

	$tag_url = get_tag_link( $post_tags[0]->term_id);

	if( empty($tag_url) ) $tag_url = get_tag_link(get_field('related_posts_tags')[0]);
	
	$products_post_type = get_field('suggested_products_type');

	if( empty($products_post_type) ) return;

	$product_ids = get_blog_suggested_product_ids($products_post_type);

	$products_object = array_for_slider($product_ids);

	if ( empty($products_object) ) return the_missing_data('Related products '.$products_post_type);

	?>

	<section class="post_related_products-gallery ter-bg row-fullwidth sec-pd">
		<p class="txt-center prim paragraph-span">Start exploring with us</p>
		<h2 class="heading2 secon txt-center div-center">Let’s plan your next holidays</h2>
		<?php

		related_products_slider($products_object);

		the_button( 'View more', $tag_url , $args = array('type'=>'prim','outlined'=> true ));

		?>
	</section>

	<?php
}


function get_blog_suggested_product_ids( $product_type ){

	$suggested_product_tags = get_field('suggested_product_tags');

	if (!empty($suggested_product_tags)) return get_products($suggested_product_tags, $product_type);

	return get_individual_product_ids( $product_type );

}


function array_for_slider($product_ids) {

	if (empty( $product_ids ) )return false;

	$products_object = array();

	foreach($product_ids as $product) {

	    $title = IS_DEFAULT_LANGUAGE ? get_the_title($product) : get_title_cz($product);

	    if( empty($title) ) $title = get_the_title($product);

		$products_object[] = array(

			'title'   =>  $title,

			'img-id'  =>  get_post_thumbnail_id($product),

			'url'     => get_the_permalink($product)

		);

	}

	return $products_object;

}


function get_individual_product_ids($product_type){

	$result = get_field('product_'.$product_type );

	//get all products of the same type
	// return empty($result) ? get_products(false, $product_type) : $result;
	
	return empty($result) ? false : $result;
}

function create_array_from_loop($loop) {

	if(!$loop->have_posts()) return false;

	$prods = array();

	while ( $loop->have_posts() ) : $loop->the_post();

		$prods[] = get_the_ID();

	endwhile;

	return $prods;

}


function get_products($tags, $post_type) {

	$tags_query = array(

		array(

			'taxonomy' => 'moment_tags',
			'field'    => 'term_id', // term_id, slug
			'terms'    => $tags,

		),

	);

	if( !$tags ) $tags_query = array();

	$args = array(

		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'tax_query' => $tags_query

	);

	$loop = new WP_Query( $args );

	$prods = create_array_from_loop($loop);

	wp_reset_postdata();

	return $prods;

}


function create_array_for_cards($loop) {

	if(empty($loop)) return false;

	$prods = array();

	while ( $loop->have_posts() ) : $loop->the_post();

		array_push($prods, get_the_ID());

	endwhile;

	return $prods;

}


function get_posts_by_tag($tags) {

	if( empty($tags) ) return false;

	$args = array(

		'post_type' => 'post',
		'post_status' => 'publish',
		'fields' => 'ids',
        'post__not_in' => array (get_the_ID()),
		'posts_per_page' => -1,
		'tax_query' => array(

			array(

				'taxonomy' => 'post_tag',
				'field'    => 'term_id', // term_id, slug
				'terms'    => $tags,

			),

		)
	);

	$loop = new WP_Query( $args );

	$prods = create_array_for_cards($loop);

	wp_reset_postdata();

	return $prods;

}


function get_related_posts_ids() {

	$related_posts_tags = get_field('related_posts_tags');

	$result = empty($related_posts_tags) ?

		get_field('related_posts') :

		get_posts_by_tag($related_posts_tags);

	return $result;

}


function related_posts_cards() {

	$posts = get_related_posts_ids();

	$args = array(

		'posts_ids'     =>  $posts,

		'color_css_class'   =>  'white-bg secon'

	);

	the_post_grid_section_with_load_more($args);

}


function the_related_posts_cards() {

	if(empty(get_field('related_posts_tags')) && empty(get_field('related_posts'))) return false;
	?>

	<section class="post_related_posts-gallery white-bg row-fullwidth sec-pd">
		<p class="txt-center prim paragraph-span">Find more inspiration in</p>
		<h2 class="heading2 secon txt-center div-center">Other articles you might like</h2>
		<?php related_posts_cards(); ?>
	</section>

	<?php
}

function check_content_shortcode_exist($content) {

	$shortcodes['excerpt'] = get_str_position_in_text($content, '<div class="text_with_line');

	if(empty($shortcodes['excerpt'])) $shortcodes['excerpt'] = get_str_position_in_text($content, '[excerpt]');

	$shortcodes['quote'] = get_str_position_in_text($content, '<div class="post_quote');

    if(empty($shortcodes['quote'])) $shortcodes['quote'] = get_str_position_in_text($content, '[quote]');

    if( $shortcodes['excerpt'] === false && $shortcodes['quote'] === false ) return false;

    return array_merge($shortcodes['excerpt'], $shortcodes['quote']);

}


function remove_shortcode_from_positions($positions, $shortcode_position) {

    foreach( $positions as $key => $position ) {

        if( $positions > $shortcode_position ) {

            unset($positions[$key]);

            return $positions;

        }

    }

}


function get_str_position_in_text($text, $str) {

    $lastPos = 0;

    $positions = array();

    while (($lastPos = strpos($text, $str, $lastPos))!== false) {

        $positions[] = $lastPos;

        $lastPos = $lastPos + strlen($str);

    }

    return $positions;

}


function get_paragraphs_positions_in_content($content, $title_tag) {

	$positions = get_str_position_in_text($content, $title_tag);

	return $positions;

}


function get_cta_block_content() {

	ob_start();

	$args=array(    'img-id'=> 21833,
		'title' => get_acf_field( 'cta_title' )
	);

	the_cta_section_blogpost( $args );

	return ob_get_clean();

}


function check_content_for_h3($content) {

    $shortcodes = check_content_shortcode_exist($content);

    $h3_cont = get_str_position_in_text($content, '<h3');

    if( !$shortcodes || !$h3_cont ) return false;

    return count($h3_cont) > count($shortcodes);

}


function append_cta_by_paragraphs_position($content, $p_number_for_append) {

	$main_tag = '<h3';

	$fallback_tag = '<p';

	$paragraph_tag = check_content_for_h3( $content ) ? $main_tag : $fallback_tag;

	$positions = get_paragraphs_positions_in_content($content, $paragraph_tag);

	$cta_block_content = get_cta_block_content();

	$position = $positions[$p_number_for_append];

	$content = substr_replace($content, $cta_block_content, $position, 0);

	return $content;

}


function is_cta_exist_in_content($content) {

    if( has_string($content, 'cta_block') ) return true;

    if( has_string($content, 'cta-section') ) return true;

    return false;

}


function append_cta_block_to_content($content) {

    if( is_cta_exist_in_content($content) ) return $content;

	$cta_p_count = intval(get_field('cta_p_count'));

	if( $cta_p_count == 0 ) return $content;

	$content = append_cta_by_paragraphs_position($content, $cta_p_count);

	return $content;

}


function after_content_sections() {

	the_share_button( $args = [
		'type'	=>	'secondary',
		'text'	=>	'Share the article',
		'class'	=>	'mb32'
	]);

	the_related_products_carousel();

	the_related_posts_cards();

	the_newsletter_sign_up();

}


add_action('astra_primary_content_bottom','after_content_sections');


function add_classes_to_content_elements($content) {

	$class_list = array( // 'tag' => 'class list'
		'p'                 => 'body-txt secon mb32',
		'h2'                => 'heading2 mb32',
		'h3'                => 'heading3 mb16',
		'img'               => 'blog-content-img mb10',
		'a'                 => 'prim txt-link',
		'hr'                => 'blog-post-hr'
	);

	$content = append_classes_to_content($content, $class_list);

	return $content;

}


function custom_caption($output, $attr, $content) {

	ob_start();
	?>

	<figure class="media_with_caption <?= ( $attr['align'] == 'aligncenter' ) ? 'txt-center' : '' ?>">
		<?php echo $content ?>
		<figcaption class="quar small-caption mb16 image_small_caption"><?php echo $attr['caption'] ?></figcaption>
	</figure>

	<?php

	return ob_get_clean();

}

add_filter('img_caption_shortcode', 'custom_caption', 10, 3);


function the_page_content($content){

	$content = remove_wp_stylistic_from_content($content);

	$content = add_classes_to_content_elements($content);

	$content = append_cta_block_to_content($content);

	return $content;

}

add_action('the_content','the_page_content');


get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_content_page_loop(); ?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php get_footer();