<?php
/*
Template Name: Contact
*/

if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'hero/hero.php' );

function enqueue_page_css(){

    enqueue_my_style('home-page','/assets/css/contact-page.css');

    enqueue_my_style('buttons-custom-css', '/templates/components/buttons/button.css');
}

add_action('wp_print_styles', 'enqueue_page_css');

// Remove Fluent Forms CSS styles.
add_action( 'wp_enqueue_scripts', function () {

    // Remove Fluent Forms default CSS.
    wp_deregister_style( 'fluentform-public-default' );
    wp_dequeue_style( 'fluentform-public-default' );
    wp_deregister_style( 'fluent-form-styles' );
    wp_dequeue_style( 'fluent-form-styles' );

}, 1000 );

add_action('astra_content_before','hero_contact');

function hero_contact(){

    the_hero_reduced(
        $args=[	'title'				=> 'Contact us',
            'img-id' 			=> get_field('header_image_desktop'),//29134,
            'img-mobile-id'		=> get_field('header_image_mobile'),
            'display-country'	=> false ]
    );
}


function display_the_form($form_id) {

    $class_list = array( // 'tag' => 'class list'
        'label'                 => 'small-txt prim field-label',
        'input'                 => 'secon body-txt default-input',
        'textarea'              => 'secon body-txt default-textarea',
        'button'                => 'btn btn-prim prim-grad cta white'
    );

    $form_content = do_shortcode('[fluentform id="'.$form_id.'"]');

    $form_content = append_classes_to_content($form_content, $class_list); // For give classes to element for styling

    $form_content = replace_form_language_links( $form_content );

    echo $form_content;

}


function the_contact_page_form($form_id) {
    ?>

    <div class="contact-form sec-pd div-center">
        <h2 class="heading2 mb35 secon"><?= get_acf_field('form_title'); ?></h2>
        <?php display_the_form($form_id); ?>
    </div>

    <?php
}


function the_contact_address() {

    the_icon('map-dark', false );

    echo get_acf_field('contact_address');

}


function the_contact_email() {

    the_icon('email-dark', false);
    ?>

    <a href="mailto:<?= get_acf_field('contact_mail'); ?>" class="secon"><?= get_acf_field('contact_mail'); ?></a>

    <?php
}


function the_contact_phone_number() {

    the_icon('phone-dark', false );

    ?>

    <a href="tel:<?php echo str_replace(' ', '', get_field('contact_phone')); // Removing spaces " " for tel:+... ?>" class="secon"><?= get_field('contact_phone'); ?></a>

    <?php

}


function the_contact_icons($website) {

    if( !get_field('contact_' . $website) ) return false;

    ?>

    <a href="<?php the_field('contact_' . $website); ?>" target="_blank">
        <?php the_icon($website . '-circle-dark', false ); ?>
    </a>

    <?php

}


function the_contact_page_info() {
    ?>

    <div class=" contact-page-content div-center">
        <?php the_media_image( 21938,'contact-right-logo div-center');?>
        <p class="paragraph-span secon mb20 ast-flex contact-address-part">
            <?php the_contact_address(); ?>
        </p>
        <p class="paragraph-span secon mb20 contact-email-pat ast-flex">
            <?php the_contact_email() ?>
        </p>
        <p class="paragraph-span secon mb30 contact-phone-part ast-flex">
            <?php the_contact_phone_number(); ?>
        </p>

        <div class="contact-social ast-flex">

            <?php

            the_contact_icons('facebook');

            the_contact_icons('instagram');

            the_contact_icons('linkedin');

            ?>
        </div>
    </div>

    <?php
}


function contact_content(){

    ?>
    <section class="row-fullwidth">
        <div class="contact-page-main-content prim-grad">
            <div class="contact-page-content-wrap ">
                <?php the_contact_page_info(); ?>
            </div>
            <div class="contact-page-form-wrap white-bg">
                <?php the_contact_page_form(6); ?>
            </div>
        </div>
    </section>
    <?php

}

add_action('the_content','contact_content');


function contact_after_content() {

    the_newsletter_sign_up();

}

add_action('astra_primary_content_bottom','contact_after_content');

get_header(); ?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <?php astra_content_page_loop(); ?>

    <?php astra_primary_content_bottom(); ?>

</div><!-- #primary -->



<?php get_footer();


?>
