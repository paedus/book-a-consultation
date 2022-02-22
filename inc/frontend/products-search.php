<?php
if ( !defined( 'ABSPATH' ) ) exit;

enqueue_my_style('products-search','/assets/css/products-search.css');

function get_main_page_slug() {

    $url_path = $_SERVER['REQUEST_URI'];

    if( has_string($url_path, 'cz/') ) $url_path = str_replace('cz/', '', $url_path);

    $url_path = explode('/', $url_path);

    return $url_path[1];

}

function the_products_search($post_type, $input_placeholder, $classes = '') {

    $post_type_slug = (!$post_type) ? 'search' : $post_type;

    if( is_array($post_type) ) $post_type_slug = implode(",", $post_type);

    $form_action = (!$post_type) ? 'search-results' : $post_type;

    if(is_array($post_type)) $form_action = get_main_page_slug();

    if( $post_type == 'post' ) $form_action = 'blog';

    ?>
    <div class="products_search_wrap <?= $classes ?>">
        <form action="/<?= $form_action ?>/" method="GET" target="_parent">
            <input type="text" id="products_search" autocomplete="off" required name="search" placeholder="Search <?= $input_placeholder ?>" data-post_type="<?= $post_type_slug ?>">
            <button type="submit" class="products-search-submit">
                <?php the_icon('search', 6, 'products_search_icon' ); ?>
            </button>
        </form>
        <ul id="search_result"></ul>
        <div id="search_results_close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 1.41405L22.5859 0L12 10.5859L1.41405 0L0 1.41405L10.5859 12L0 22.5859L1.41405 24L12 13.4141L22.5859 24L24 22.5859L13.4141 12L24 1.41405Z" fill="#BDBDBD"/>
            </svg>
        </div>
    </div>
    <?php
}

