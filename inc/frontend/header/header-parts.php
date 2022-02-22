<?php

if ( !defined( 'ABSPATH' ) ) exit;



function the_search_panel($location,$panel_name) {

    if ( $panel_name !='right_center' ) return;

    the_icon('search', 4 , 'topnav-search');

}

add_action('astra_render_header_column','the_search_panel',10,2);

function after_main_header() {
    ?>

    <div id="searchWrap">
        <div id="search-container">
            <div id="searchClose" class="mt35">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                    <path d="M24 1.41405L22.5859 0L12 10.5859L1.41405 0L0 1.41405L10.5859 12L0 22.5859L1.41405 24L12 13.4141L22.5859 24L24 22.5859L13.4141 12L24 1.41405Z" fill="#BDBDBD"/>
                </svg>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        var loadSubscribe = document.getElementById("search-container");

        // create iframe
        var substack = document.createElement("iframe");
        // Add attributes
        substack.src = "<?=get_home_url()?>/search/";
        // Set size and hide iframe border
        substack.width = "450";
        substack.height = "500";
        substack.frameBorder ="0";
        substack.scrolling = "0";
        substack.style.border= "none";
        substack.style.background = "transparent";

        // event to trigger iframe loading
        let search_triggers = document.querySelectorAll('.topnav-search');
        search_triggers.forEach(trigger => {
            trigger.addEventListener("click", function(){
                // Add Iframe to webpage
                document.body.style.overflowY = 'hidden';
                loadSubscribe.appendChild(substack);
                document.getElementById('searchWrap').style.display = "block";
                // Hide button
                // this.style.display = "none";
            })
        })

        document.getElementById('searchClose').addEventListener("click", function(){
            document.getElementById('searchWrap').style.display = "none";
            document.body.style.overflowY = 'auto';
        })
    </script>

    <?php
}

add_action('astra_header_after','after_main_header',10,2);


remove_admin_bar_on_search_page();

function remove_admin_bar_on_search_page() {

    if ( strpos($_SERVER['REQUEST_URI'], '/search') !== false ) {

        add_filter( 'show_admin_bar', '__return_false' );
    }
}

function get_search_icon(){

    ?><span class="icon-sprite icon-search"></span><?php

}

