<?php

$term_object = get_queried_object(); // get current term object

$blog_listing_page = get_pages(array( // get blog listing page object by template file

    'meta_key' => '_wp_page_template',

    'meta_value' => 'templates/blog-listing.php'

));

$blog_listing_page_url = $blog_listing_page[0]->post_name;

$path = '/'. $blog_listing_page_url .'/?tags=' . $term_object->term_id;

header('Location: ' . get_home_url() . $path);


exit();