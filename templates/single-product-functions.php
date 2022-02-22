<?php

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'slider/slider.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );

require_once (COMPONENTS_PATH.'buttons/button.php' );

require_once ( COMPONENTS_PATH.'hero/hero.php' );

function enqueue_products_css(){

    enqueue_my_style('products','/assets/css/products.css');
}

add_action('wp_head', 'enqueue_products_css', 20);

add_action('astra_content_before','hero_main');

function get_short_accomm_name(){

    $short_accomm_name = get_field('short_name');

    if ( $short_accomm_name ) return $short_accomm_name;

    return get_the_title();
}


function the_accomodation_gallery( $title ){

    the_photo_gallery(

        $title,

        get_field('gallary_images'),

        $color_css_class ='ter-bg secon'
    );
}

function get_tag_related_accomodations_ids($post_type = 'accommodations') {

    $same_tag_posts_ids = get_posts_in_main_tag_acf($post_type);

    if (!$same_tag_posts_ids) return false;

    $accomm_separated_by_destination = get_accomm_separated_by_destination( $same_tag_posts_ids );

    global $post;

    if (($key = array_search($post->ID, $accomm_separated_by_destination)) !== false) {

        unset($accomm_separated_by_destination[$key]); //unset current post from posts array

    }

    $tags_ids = array_values($accomm_separated_by_destination);

    //randomise IDs order
    shuffle($tags_ids);
    
    return $tags_ids;

}

function get_posts_in_main_tag_acf($post_type = 'accommodations'){
    return get_posts_in_tag( get_field( 'main_tag' ), $post_type );
}

function get_accomm_separated_by_destination( $same_tag_posts_ids ){

    global $post;

    $current_post_country_id = wp_get_object_terms( $post->ID,'countries')[0]->term_id;

    foreach ($same_tag_posts_ids as $post_id) {

        $country_id = wp_get_object_terms( $post_id,'countries')[0]->term_id;

        $priority =  $country_id == $current_post_country_id ? 0 : 1;

        $result[$priority][] = $post_id;
    }

    return array_merge( $result[0]??[], $result[1]??[] );
}

function the_explore_similar_accommodation( $short_accomm_name ){

    $explore_similar_data_array = get_explore_similar_data();

    if (empty($explore_similar_data_array)) return false;

    ?>
    <section id="explore-similar" class="row-fullwidth prim-grad sec-pd">
        <?php


        the_explore_similar(

            $short_accomm_name,

            $explore_similar_data_array
        );

        ?>
    </section>
    <?php
}

function get_explore_similar_data(){

    global $post;

    $current_accomm_main_tag = get_field('main_tag');

    if (empty($current_accomm_main_tag)) return false;

    //main accommodation tag to be first in array
    $result[]=get_tag_data( $current_accomm_main_tag );

    $accomm_tags = get_accomm_tags($post->ID);

    foreach ($accomm_tags as $tag_id){

        if ($tag_id == $current_accomm_main_tag ) continue;

        $result[] = get_tag_data( $tag_id );

    }

    return $result;
}

function get_tag_data( $tag_id ){

    $tag_data = get_term($tag_id);

    return array( 'text' => $tag_data->name, 'url'=>get_tag_link($tag_id) );
}

function the_accomm_quick_access( $post_type='accommodation', $taxonomy = false ){

    $quick_access_data = get_quick_access_data( $post_type, $taxonomy );

    if ( !$quick_access_data ) return;

    ?>
    <section class="quick-access row-fullwidth ter-bg">
        <div class="quick-access-wrap txt-center">
            <?php foreach ($quick_access_data as $text => $link){ ?>
                <a href="<?=$link?>" class="quick-access-link caption-txt quar"><?=$text?></a>
            <?php } ?>
        </div>
    </section>
    <?php
}

function header_footer_container(){

    get_header(); ?>

    <div id="primary" <?php astra_primary_class(); ?>>

        <?php astra_primary_content_top(); ?>

        <?php astra_content_page_loop(); ?>

        <?php astra_primary_content_bottom(); ?>

    </div><!-- #primary -->

    <?php get_footer();

}

function get_country_accomm_ids($post_type = 'countries'){

    global $post;

    $post_tax_id = wp_get_object_terms( $post->ID,$post_type)[0]->term_id;

    $country_accomm_ids = get_posts_in_tax( $post_tax_id, 'accommodations' );

    return $country_accomm_ids;
}

function get_current_post_name() {

    global $post;

    return $post->post_title;

}


function get_current_post_slug() {

    global $post;

    return $post->post_name;

}

function the_handpicked_accommodation($args=[]){

    $post_type = $args['post_type'] ?? 'countries';

    $related_accomodations_ids = get_country_accomm_ids($post_type);

    if ( empty($related_accomodations_ids) ) {

        the_missing_data('the_handpicked_accommodation '.$post_type);

        return;
    }

    $related_accomm_data = get_cpt_gallery_lang_data($related_accomodations_ids,$post_type);

    $post_name = get_current_post_name();

    $post_slug = get_current_post_slug();

    $args = array(
        'ids'			=>	$related_accomm_data,
        'sec-class'		=>	'white-bg secon',
        'sec-id'		=>	'lodging',
        'title'			=>	'Handpicked lodging <span>in '. $post_name .'</span>',
        'button-text'	=>	'Show all lodging',
        'button-link'	=>	'/lodging/?location=' . $post_slug,
        'slider-type'   =>  'cpt-gallery-not-loop'
    );

    the_accommodation_gallery_section( $args);

}

function the_recommended_exepriences($args=[]){

    $post_type = $args['post_type'] ?? 'countries';

    $post_terms = wp_get_object_terms( get_the_ID(), $post_type )[0];

    $related_posts_ids = get_posts_in_tax($post_terms->term_id,'moments');

    if ( empty($related_posts_ids) ) return the_missing_data('recommended experiences');

    $related_accomm_data = get_cpt_gallery_lang_data($related_posts_ids,$post_type);

    $country = $post_type == 'countries' ? get_post_country_name(): $post_terms->name;

    $post_slug = get_current_post_slug();

    $args = array(
        'ids'			=>	$related_accomm_data,
        'sec-class'		=>	'sec-pd ter-bg secon',
        'sec-id'		=>	'experiences',
        'title'			=>	'Exciting experiences <span>in '. $country .'</span>',
        'button-text'	=>	'Show all experiences',
        'button-link'	=>	'/experiences/?location=' . $post_slug,
        'slider-type'   =>  'cpt-gallery-not-loop'
    );

    the_accommodation_gallery_section( $args);

}

function the_accomodation_description( $short_accomm_name ){

    $description = get_acf_repeater( 'description', ['title','text','country'] );

    $img_id = get_field('description_image');

    $explore_title = empty($description[1]['country']) ? $short_accomm_name : $description[1]['country'];

    ?>
    <section id="about" class="accommodation-description ter-bg row-fullwidth sec-pd">
        <div class="ast-container">
            <h2 class="heading2 secon mb15">Explore <span><?=$explore_title?></span></h2>
            <div class="accommodation-description-img">
                <?php the_media_responsive_image($img_id,'desc-img'); ?>
            </div>
        </div>
        <div class="ast-container">
            <div class="ast-flex">
                <div class="accommodation-description-right">
                    <p class="body-txt mb24 secon"><?=$description[0]['text']?></p>
                    <h2 class="heading2 secon mb16"><?=get_title_cz_when_visit_the_place( $description[1])?></h2>
                    <p class="body-txt mb24 secon"><?=$description[1]['text']?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="accommodation-description ast-row sec-pd">

        <?php
        foreach ($description as $key => $value ){
            if ( $key<2 ) continue;

            $title = $value['title'] ==='-' ? '' : $value['title'];
            ?>
            <div class="ast-col-md-4">
                <h2 class="heading2 secon mb15"><?=$title?></h2>
                <p class="body-txt mb35 secon"><?=$value['text']?></p>
            </div>
            <?php

        }
        ?>
    </section>

    <?php

}

function get_quick_access_data_accommodation(){

    $result['About the property'] = '#about';

    if ( get_field('moment_video_url') ) { $result['Video'] = '#video'; }

    $result['Photo Gallery'] = '#photo-gallery';

    $result['Explore similar'] = '#explore-similar';

    return $result;

}


function is_current_destination_have_accommodations($taxonomy) {

    if( !$taxonomy ) return false;

    $related_accommodations_ids = get_country_accomm_ids($taxonomy);

    if( empty($related_accommodations_ids) ) return false;

    return true;

}


function is_current_destination_have_experiences($taxonomy) {

    if( !$taxonomy ) return false;

    $post_terms = wp_get_object_terms( get_the_ID(), $taxonomy )[0];

    $related_posts_ids = get_posts_in_tax($post_terms->term_id,'moments');

    if( empty($related_posts_ids) ) return false;

    return true;

}


function get_quick_access_data_destination($taxonomy = false){

    $result['About the Destination'] = '#about';

    if ( get_field('moment_video_url') ) { $result['Video'] = '#video'; }

    $result['Photo Gallery'] = '#photo-gallery';

    if( is_current_destination_have_accommodations($taxonomy) ) $result['Lodging'] = '#lodging';

    if( is_current_destination_have_experiences($taxonomy) ) $result['Experiences'] = '#experiences';

    return $result;

}

function get_quick_access_data( $post_type, $taxonomy = false ) {

    $data_function_name = 'get_quick_access_data_'.$post_type;

    if (!is_callable( $data_function_name ) ) return false;

    return call_user_func( $data_function_name, $taxonomy );
}