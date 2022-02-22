<?php

if ( !defined( 'ABSPATH' ) ) exit;

enqueue_my_style('cta-pop-up-style','assets/css/cta-pop-up.css');

enqueue_my_script('cta-pop-up','assets/js/cta-pop-up.js');

// Adding popup wrapper in the <footer> tag
add_action( 'astra_content_bottom', 'cta_pop_up_bookacall' );

function cta_pop_up_bookacall() {

    ?>
    <div id="cta-pop-up-bookacall" class="cta-pop-up-wrapper">
        <div id="cta-pop-up-container">
        <iframe src="<?=get_home_url()?>/pop-up-form/?form=bookacall" id="cta-pop-up-iframe" loading="lazy" frameborder="0"></iframe>
            <div class="cta-pop-up-close">
                <?php the_icon('cancel-dark', false ); ?>
            </div>
        </div>
    </div>
<?php
}

