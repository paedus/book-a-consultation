<?php
/*
Template Name: Search
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/../inc/frontend/products-search.php';


function is_iframe() {

    return isset($_SERVER['HTTP_REFERER']);

}


add_filter( 'body_class','my_body_classes' );

function my_body_classes( $classes ) {

    if ( is_iframe() ) {

        $classes[] = 'search-page-in-iframe';

    }

    return $classes;

}


get_header();

?>

<div class="search-bar div-center">
    <?php the_products_search(false, 'on EliteVoyage.com');?>
</div>

<?php

enqueue_my_script('products-search-js','/assets/js/search-product.js');
wp_footer();

