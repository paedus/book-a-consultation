<?php

if ( !defined( 'ABSPATH' ) ) exit;

enqueue_my_style('cta-pop-up-style','assets/css/cta-pop-up.css');

enqueue_my_script('cta-pop-up','assets/js/cta-pop-up.js');

// Adding popup wrapper in the <footer> tag
add_action( 'astra_content_bottom', 'cta_pop_up_sendrequest' );

function cta_pop_up_sendrequest() {

    $post_id = get_the_ID();

    $post_id_qs = $post_id ? '&id='.$post_id : '';
    
    ?>
    <div id="cta-pop-up-sendrequest" class="cta-pop-up-wrapper">
        <div id="cta-pop-up-container">
        <iframe src="<?=get_home_url()?>/pop-up-form/?form=sendrequest<?=$post_id_qs?>" loading="lazy" id="cta-pop-up-iframe" frameborder="0"></iframe>
            <div class="cta-pop-up-close">
                <?php the_icon('cancel-dark', false ); ?>
            </div>
        </div>
    </div>
<?php
}
