<?php



if ( !defined( 'ABSPATH' ) ) exit;

require_once ( COMPONENTS_PATH.'buttons/button.php' );

function mobileMenuAdd($rrr) {

    global $TRP_LANGUAGE;

    $currentLang = explode('_', $TRP_LANGUAGE)[0];

    ?>

    <div class="mobile_menu_added_customs">

        <div class="mobile_header_search_box">

            <span class="mobile_search_icon"></span>

            <span class="topnav-search">Search</span>

            <?php  ?>

        </div>

        <div class="mobile_menu_lang_switcher current_lang_<?= $currentLang ?>">

            <?php echo do_shortcode('[language-switcher]'); ?>

        </div>

<!--        <hr>-->
<!---->
<!--        <div class="mobile_menu_login_btn">-->
<!---->
<!--            --><?php //the_button('Log in','/login',$args = array('type'=>'primary' ));?>
<!---->
<!--            <span>Not registered yet?</span>-->
<!---->
<!--            <a href="/registration">Create a free account</a>-->
<!---->
<!--        </div>-->

    </div>

    <?php


}

add_action( 'astra_mobile_header_content', 'mobileMenuAdd', 11);