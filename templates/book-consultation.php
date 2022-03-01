<?php
/*
Template Name: Book a consultation
*/

add_filter( 'show_admin_bar', '__return_false' );

require_once ( trailingslashit( get_stylesheet_directory() ) . 'inc/frontend/book-consultation-form.php' );

wp_head();

enqueue_my_script('cta-pop-up-book-consultation','assets/js/cta-pop-up-book-consultation.js');

?>

<body class="pop-up-form-template">
<?php

    the_book_consultation_form();

?>
<style type="text/css">
    html{
        margin-top: 0!important;
    }
</style>
</body>
</html>
<?php

wp_footer();