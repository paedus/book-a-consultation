<?php

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'hero/hero.php' );

function enqueue_page_css(){

    enqueue_my_style('home-page','/assets/css/404-page.css');

}

add_action('wp_head', 'enqueue_page_css', 20);

 
function the_404_content() {
    ?>
    <div class="no-found-wrap div-center txt-center mb35">
        <h1 class="heading1 mb16 secon">Oops! It seems you got lost ... </h1>
        <?php the_media_image( 28689, 'div-center mt24 mb32'); ?>
        <h2 class="heading2 prim mb20">Let’s try to look here</h2>
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

add_action('astra_primary_content_top','the_404_content'); //Setting page before content

add_action('astra_above_footer','the_newsletter_sign_up'); //Setting page after content

get_header();
?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <?php //astra_content_page_loop(); dont uncomment this, because of default astra theme 404 content ?>

    <?php // astra_primary_content_bottom(); ?>

</div><!-- #primary -->

<?php
get_footer();
?>
