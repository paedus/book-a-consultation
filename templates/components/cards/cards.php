<?php

if ( !defined( 'ABSPATH' ) ) exit;

add_action ('wp_print_styles', function(){enqueue_component_css( __DIR__.'/cards.css');});

function get_post_excerpt_by_sentences( $post_content, $max_char_count ){

	$post_content = strip_tags($post_content);

	for ( $i = $max_char_count ; $i > 0 ; $i--) { 

		if ( is_end_of_the_sentence( $post_content[$i] ) ) break;
	}

	$output = get_excerpt_substring( $post_content, $i, $max_char_count );

	return $output;

}

function get_excerpt_substring( $post_content, $excerpt_lenght, $max_char_count ){

	if ( $excerpt_lenght === 0 ) return substr( $post_content, 0, ($max_char_count-3) ).'...';

	return substr($post_content, 0, $excerpt_lenght+1);
}

function is_end_of_the_sentence( $char ){

	return $char == '.' || $char == '!';
}


/**
 * array 	'id'	
			'date'	
			'title'	 
			'exceprt' 
 * 
 **/

function the_blog_listing_card( $post_data ){ //deprecated??

	?>
	<div class="blog-article-listing txt-center">
		<?php the_media_image($post_data['featured_image_id'],'blog-article-listing-img br15 mb10','medium') ?>
		<h3 class="heading3 black mb5"><?=$post_data['title']?></h3>
		<div class="ast-flex ast-justify-content-center ast-align-items-center mb10">
		</div>
		<p class="listing-excerpt body-txt black mb15"><?=$post_data['excerpt']?></p>
		<?php the_button('Read more', get_permalink($post_data['id']) , $args = array('type'=>'primary','outlined'=> true )); ?>
	</div>
	<?php
}

function the_pop_up_card( $title, $subtitle ){
	?>
	<div class="pop-up-icon secon-grad txt-center br15">
		<?php the_icon('cancel-white', false, 'pop-up-icon-close' ); ?>
		<?php the_media_image(21824,'check-mark-elipse-gold') ?>
		<h3 class="pop-up-icon-title heading3 white"><?=$title?></h3>
		<p class="pop-up-icon-desc white div-center"><?=$subtitle?></p>
		<?php 
			the_button('Back to travel','#', $args = array('type'=>'primary', 'outlined'=> true));
		?>		
	</div>		
	<?php

}

function the_team_card( $args ){ // $name, $title, $image_id, $bg_is_dark='' 
	
	$image_id = $args['image'] ?? MISSING_IMAGE_PLACEHOLDER;

	$designation_color_css_class = isset($args['background']) ? 'white' : 'secon';

	?>
	<div class="team-card txt-center div-center">
		<?php the_media_image($image_id,'team-card-img mb10','smartphone-vertical'); ?>
		<h3 class="team-card-name heading3 prim"><?=$args['name']?></h3>
		<div class="team-card-position paragraph-span <?=$designation_color_css_class?> mb15">
			<?=$args['designation']?>
		</div>
	</div>		
	<?php
}

function the_contact_card( $name, $designation, $designation_cz, $phone, $image_id ){

	$designation_text = IS_DEFAULT_LANGUAGE ? $designation : $designation_cz;
	?>
	<div class="contact-card txt-center div-center">
		<?php
		the_media_image($image_id,'contact-card-img mb5','medium');
		?>
		<h3 class="contact-card-name heading3 prim"><?=$name?></h3>
		<div class="contact-card-position paragraph-span secon mb15"><?=$designation_text?></div>
		<div class="ast-flex ast-justify-content-center ast-align-items-center caption-txt mb15"><?php the_icon('phone', 0, 'mr10')?></span><span class="prim"><?=$phone?></span></div>
		<?php the_button('Send request','#',$args = array('type'=>'primary','cta-button'=>'sendrequest' ));?>
	</div>	
	<?php
}

function the_card_product( $args ){

	$link_markup = empty( $args['url'] ) ?

						['element'=>'span','href'=>''] :
	
						['element'=>'a','href'=>'href="'.$args['url'].'"'];

	?>
<div class="product-card box-shadow div-center">
	<?php the_card_image($args); ?>
	<div class="product-card-bg"></div>
	<<?=$link_markup['element']?> class="product-card-link mb16" <?=$link_markup['href']?>>
		<h3 class="product-card-heading heading3 txt-center white"><?=$args['text']?></h3>
		<?php the_card_product_subtitle($args); ?>
	</a>
</div>
	<?php

}



function the_card_image($args){

	the_media_image(	
		$args['img-id'],
		$class='product-card-img '.($args['class'] ?? ''),
		$size=($args['thumb-size'] ?? 'smartphone-vertical')
	);
}

function the_card_product_subtitle($args){

	if ( !empty($args['country']) ) return the_card_country_name( $args['country']);
	
	if ( empty( $args['subtitle'] ) ) return;

	?>
	<div class="product-card-map ast-flex ast-align-items-center cta caption-txt white">
		<?php 
		
		the_icon( $args['subtitle-icon'] ?? false, 3 );

		echo $args['subtitle']
		?>
	</div>
	<?php 

}

function the_card_country_name( $country_name ){
	
	?>
	<div class="product-card-map ast-flex ast-align-items-center cta caption-txt white">
		<?php the_icon('map')?><?=$country_name?>
	</div>
	<?php

}

function the_related_accommodation_card($post_id){

    $post_title = get_post($post_id)->post_title;

    if(!IS_DEFAULT_LANGUAGE) $post_title = !empty(get_title_cz($post_id)) ? get_title_cz($post_id) : get_post($post_id)->post_title ;

	$post_term = wp_get_object_terms( $post_id,'countries');

	$country_name = empty($post_term[0]->name) ? '': $post_term[0]->name;

	the_card_product( [	'text'		=>	$post_title,
						'url'		=>	get_permalink($post_id),
						'country' 	=>	$country_name,
						'img-id'	=>	get_post_thumbnail_id($post_id)] 
					);
}

// function the_post_with_custom_subtile( $post_data ){


// }