<?php
/*
Template Name: Search Results
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once __DIR__ . '/../inc/frontend/products-search.php';

require_once ( COMPONENTS_PATH.'hero/hero.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );


function get_products_query($post_type = 'any', $post_per_page = -1) {

    $args = array(
        'post_type'         => $post_type,
        's'                 => get_search_string(),
        'posts_per_page'    => $post_per_page,
        'post_status'       => 'publish',
        'fields'            => 'ids', // not all post data needed here
    );

    $query = new WP_Query( $args );

    if( CURRENT_LANGUAGE == 'cz' ) $cz_query = check_for_czech_posts($post_type, $post_per_page, $query->posts);

    if( isset($cz_query) && $cz_query ) $query = merge_queries($query, $cz_query);

    if( !$query->have_posts() ) return false;

    return $query;

}


function merge_queries($query1, $query2) {

    $wp_query = new WP_Query();

    $wp_query->posts = array_merge( $query1->posts, $query2->posts );

    $wp_query->post_count = $query1->post_count + $query2->post_count;

    return $wp_query;

}


function check_for_czech_posts($post_type, $post_per_page, $post_not_in = array()) {

    $args = array(
        'post_type'         => $post_type,
        'posts_per_page'    => $post_per_page,
        'post__not_in'      => $post_not_in,
        'post_status'       => 'publish',
        'fields'            => 'ids', // not all post data needed here
        'meta_query'        => array(
            array(
                'key'       => 'title_cz',
                'value'     => get_search_string(),
                'compare'   => 'LIKE'
            )
        )
    );

    $query = new WP_Query( $args );

    if( !$query->have_posts() ) return false;

    return $query;

}


function get_search_string() {

    return get_var('search');

}


function the_search_string() {

    echo get_search_string();

}


function the_search_result_title() {

    if( empty(get_search_string()) ) return false;

    ?>
        <p class="mb32 intro-txt txt-center"><span>Search results for</span> “<?php the_search_string() ?>”</p>
    <?php

}


function the_prods_grid_title($title) {
    ?>
        <h2 class="heading2 txt-center mb20"><?= $title ?></h2>
    <?php
}


function the_products($query, $show_region = true) {

    while ($query -> have_posts()) : $query -> the_post();

        ($show_region) ? $country = get_the_terms( get_the_ID(), 'countries' )[0]->name : false;

        $product_title = (CURRENT_LANGUAGE == 'cz') ? get_field('title_cz') :get_the_title();

        the_card_product( ['text'=>$product_title, 'url'=>get_the_permalink(), 'country' => $country[0]->name, 'img-id'=>get_post_thumbnail_id(get_the_ID())] );

    endwhile;

}


function get_ids_from_query($query) {

    $ids = array();

    while ($query -> have_posts()) : $query -> the_post();

        $ids[] = get_the_ID();

    endwhile;

    return $ids;

}


function the_results_section($post_types, $section_title, $show_country_in_card = true) {

    $query = get_products_query($post_types);

    if( !$query ) return false;

    ?>

    <div class="results_block div-center">

        <?php the_prods_grid_title($section_title); ?>

        <div class="results_block_grid">
            <?php the_products($query, $show_country_in_card);?>
        </div>

    </div>

    <?php

}


function the_accommodations_result() {

    $query = get_products_query('accommodations');

    if( !$query ) return false;

    $prods_ids = get_ids_from_query($query);

    $args = array(

        'posts_ids'		=>	$prods_ids,

        'sec_title'	=>	'Accommodations',

        'color_css_class'	=>	'white-bg secon'
    );

    ?>

    <div class="results_block div-center">

        <?= the_post_grid_section_with_load_more($args); ?>

    </div>

    <?php

}


function search_no_result() {
    ?>

    <div class="search_no_result_wrap txt-center mb35">
        <h1 class="heading1 mb16">Oops! We haven’t found anything... </h1>
        <p class="mb35 intro-txt">for “<?php the_search_string()  ?>”</p>
        <?php the_media_image( 28689, 'div-center'); //UNCOMMENT THIS ?>
        <h2 class="heading2 prim mb20">Search again or try to look here</h2>
        <div class="mb20">
            <a href="<?php echo get_post_type_archive_link( 'landing-page' ); ?>" class="link-bold prim txt-link">Destinations & Regions</a>
        </div>
        <div class="mb20">
            <a href="<?php echo get_post_type_archive_link( 'accommodations' ); ?>" class="link-bold prim txt-link">Accommodations</a>
        </div>
        <div class="mb20">
            <a href="<?php echo get_post_type_archive_link( 'moments' ); ?>" class="link-bold prim txt-link">Experiences</a>
        </div>
        <div class="mb20">
            <a href="<?php echo get_post_type_archive_link( 'post' ); ?>" class="link-bold prim txt-link">Explorers’ Articles</a>
        </div>
    </div>

<?php
}


function the_search_results() {


    the_products_search(false, 'on EliteVoyage.com', 'search-results-page mb35');

    if(!get_products_query()) return search_no_result();

    the_search_result_title();

    the_results_section(array('landing-page','landing-page-cities'), 'Destinations and Regions', false);

    the_accommodations_result();

    the_results_section(array('moments'), 'Experiences');

    the_results_section(array('post'), 'Articles');

}


get_header();

?>

    <div id="primary">

        <?php

        the_search_results();

        the_newsletter_sign_up();

        ?>


    </div><!-- #primary -->

<?php

enqueue_my_script('products-search-js','/assets/js/search-product.js');

get_footer();

