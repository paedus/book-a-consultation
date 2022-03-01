<?php

require_once 'stepped-form.php';


// Array of pages which is need to be in form
$form_screens = array(

    'first_page' => array(
        'content' => 'firstScreenContent',
        'title'   => 'How do you prefer to get in touch?'
    ),

    'phone_form' => array(
        'content'   => 'phoneFormScreenContent',
        'next'      => 'thank_you_page',
        'title'   => 'Please give us your contact details'
    ),

    'person_embed' => array(
        'content' => 'personEmbedScreenContent',
        'next'      => 'thank_you_page',
        'title'   => 'Please choose a date for personal meeting'
    ),

    'online_embed' => array(
        'content' => 'onlineEmbedScreenContent',
        'next'      => 'thank_you_page',
        'title'   => 'Please choose a date for online meeting'
    ),

    'thank_you_page' => array(
        'content' => 'thankYouPageScreenContent',
        'title'   => 'Thank you for your booking!'
    )

);


function phoneFormScreenContent() {

    get_template_part('inc/frontend/form', 'display');
    return true;

}
function personEmbedScreenContent() {

    return true;

}
function onlineEmbedScreenContent() {

    return true;

}
function thankYouPageScreenContent() {
    ?>

    <div class="stepped-form-thank-you txt-center">

        <?php the_media_image(21826, 'mb24') ?>

        <p class="mb24 thank-you-txt">We appreciate your time, that’s why we would like to ask you a few questions about your planned trip now.</p>

        <p class="bold-txt thank-you-txt">It won’t take more than 2 minutes of your time.</p>

    </div>

    <?php
    return true;
}


function the_book_consultation_form() {

    $args = array(
        'steps_count'   => 3,
        'active_step'   => 1,
        'title'         => 'How do you prefer to get in touch?',
        'slug'          => 'book_consultation',
        'load_by_page'  => false

    );

    the_form_with_steps($args);

}

function book_consultation_get_next_page($current_page) {

    global $form_screens;

    if( isset($form_screens[$current_page]['next']) ) return $form_screens[$current_page]['next'];

    return false;

}


function firstScreenContent() {

    $buttons_list = array(
        array(
            'title' => 'Phone',
            'value' => 'phone_form'
        ),
        array(
            'title' => 'In person',
            'value' => 'person_embed'
        ),
        array(
            'title' => 'Online meeting',
            'value' => 'online_embed'
        )
    );

    $args = array(
        'buttons' => $buttons_list,
    );

    ?>

    <form method="get" action="">

        <?php the_listed_radio_buttons($args); ?>

    </form>

    <?php

}

