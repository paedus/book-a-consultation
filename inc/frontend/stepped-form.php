<?php

add_action('wp_print_styles',

    function(){

        enqueue_my_style( 'button', 'templates/components/buttons/button.css' );

        enqueue_my_style( 'contact-page', 'assets/css/contact-page.css' );

        enqueue_my_style( 'cta-pop-up-style','assets/css/cta-pop-up.css');


    }

);


wp_enqueue_style('countries-field', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css' );

wp_enqueue_script('jquery-validate-min',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js',
    array( 'jquery' )
);

wp_enqueue_script('jquery-tel-input',
    'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput-jquery.min.js',
    array( 'jquery' )
);


add_filter( 'show_admin_bar', '__return_false' );

function the_form_steps($active, $count) {

    for( $i=1; $i<=$count; $i++) :
        ?>

        <li class="form-step <?= $i==$active ? 'active-step' : '' ?>"></li>

    <?php
    endfor;
}

function the_steps_for_form($active = 1, $count = 3) {
    ?>

    <div class="form-steps-wrapper">
        <ul class="form-steps">
            <?php the_form_steps($active, $count); ?>
        </ul>
    </div>

    <?php
}


function the_stepped_form_header($args) {
    ?>

    <div class="stepped-form-header mb24">

        <?php the_steps_for_form($args['active_step'], $args['steps_count']); ?>


    </div>

    <?php
}


function page_content_load_by_page() {
    ?>

    <div class="stepped-form-content">

        <form method="get" action="">

            <?php //the_listed_radio_buttons($args); ?>

        </form>

    </div>

    <?php
}


function the_screen_attrs($screen) {

    if( $screen['next'] ) echo 'data-next="' . $screen['next'] . '"';

}


function load_all_pages_content() {

    global $form_screens;

    foreach($form_screens as $key => $screen) {
        ?>

        <div class="stepped-form-screen-content <?= $key ?> <?= ($key === array_key_first($form_screens)) ? 'active-screen' : '' ?>" <?php the_screen_attrs($screen); ?>>

            <h3 class="heading3 div-center txt-center"><?= $screen['title']; ?></h3>

            <?php $screen['content'](); ?>

        </div>

        <?php
    }

}


function the_stepped_form_content($args) {

    if( $args['load_by_page'] ) return page_content_load_by_page();

    ?>

    <div class="stepped-form-content">

        <?php load_all_pages_content(); ?>

    </div>

    <?php
}


function the_stepped_form_footer() {
    ?>

    <div class="stepped-form-footer">

        <span class="cta quar txt-center" id="popup-cancel-button">Cancel</span>

        <?php the_button('Continue','#',$args = array('type'=>'primary','class'=>'form-continue-btn' ));?>

    </div>

    <?php
}


function the_form_with_steps($args) {
    ?>

    <div class="stepped-form-container stepped-form-main-screen" data-load_by_page="<?= $args['load_by_page'] ? 'true' : 'false' ?>" >

        <?php the_stepped_form_header($args); ?>

        <?php the_stepped_form_content($args); ?>

        <?php the_stepped_form_footer(); ?>

    </div>

    <?php
}