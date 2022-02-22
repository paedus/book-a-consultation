<?php
/*
*	Template Name: location
*/

if ( !defined( 'ABSPATH' ) ) exit;

require ( __DIR__ . '/templates/single-product-functions.php');


function the_product_location_description( $short_accomm_name ){

    $description = get_acf_repeater( 'description', ['title','text','country'] );

    $img_id = get_field('description_image');

    $title_cz_when_visit_the_place = get_title_cz_when_visit_the_place($description[1]);

    $explore_title = empty($description[1]['country']) ? $short_accomm_name : $description[1]['country'];

    ?>
    <section id="about" class="accommodation-description ter-bg row-fullwidth sec-pd">
        <div class="ast-container">
            <h2 class="heading2 secon mb15">Explore <span><?=$explore_title?></span></h2>
            <div class="accommodation-description-img">
                <?php the_media_responsive_image($img_id,'desc-img'); ?>
            </div>
        </div>
        <div class="ast-container">
            <div class="ast-flex">
                <div class="accommodation-description-right">
                    <p class="body-txt mb35 secon"><?=$description[0]['text']?></p>
                    <h2 class="heading2 secon"><?=$title_cz_when_visit_the_place?></h2>
                    <p class="body-txt mb35 secon"><?=$description[1]['text']?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="accommodation-description ast-row element-ll">

        <?php
        foreach ($description as $key => $value ){
            if ( $key<2 ) continue;

            $title = $value['title'] ==='-' ? '' : $value['title'];
            ?>
            <div class="ast-col-md-4">
                <h2 class="heading2 secon mt35 mb15"><?=$title?></h2>
                <p class="body-txt mb35 secon"><?=$value['text']?></p>
            </div>
            <?php

        }
        ?>
    </section>

    <?php

}

function the_recommended_itineraries(){

    //deb(get_post_location_id(),'');

    return;


    if ( empty($related_accomodations_ids) ) {

        ?>Main tag is empty, section is not displayed. This is a message just for debugging purposes.<?php

        return;
    }

    ?>
    <section class="you-might-also-like row-fullwidth element-ll">
        <div class="ast-container">
            <h2 class="heading2 mb20 div-center txt-center">You might also like</h2>
        </div>
        <div class="ast-container">
            <input id="load-more-checkbox" class="hide" type="checkbox" name="">

            <div class="ast-row you-might-also-like-row">

                <?php
                foreach ($related_accomodations_ids as $post_id){
                    ?>
                    <div class="ast-col-md-6 ast-col-lg-4 mb35">
                        <?php the_related_accommodation_card($post_id); ?>
                    </div>
                <?php } ?>
            </div>

            <div class="load-more-btn">
                <label class="load-more-label" for="load-more-checkbox"></label>
                <?php the_button( 'Load more', 'javascript:void(0)', $args = array('type'=>'prim','outlined'=> true, 'class'=> 'hide-desktop')); ?>
            </div>

        </div>
    </section>
    <?php
}

function the_page_content(){

    $short_accomm_name = get_short_accomm_name();

    the_accomm_quick_access('destination', 'cities');

    the_our_opinion();

    the_product_location_description( $short_accomm_name );

    the_accomodation_gallery("<span>Photos from</span> <span>$short_accomm_name</span>");

    the_video_gallery_section("<span>Watch</span> $short_accomm_name <span>Video</span>", $video_id=false, $color_css_class='ter-bg secon');

    the_cta_section("<span>Do you like</span> <span>$short_accomm_name</span>?", $img_id=25090);

    the_handpicked_accommodation(['post_type'=>'cities']);

    // the_recommended_itineraries(); // itineraries are empty

    the_recommended_exepriences(['post_type' => 'cities']);

    // the_explore_similar_accommodation( $short_accomm_name );

    the_newsletter_sign_up();

}

add_action('the_content','the_page_content');

header_footer_container();