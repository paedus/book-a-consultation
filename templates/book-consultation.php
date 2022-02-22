<?php
/*
Template Name: Book a consultation
*/

add_filter( 'show_admin_bar', '__return_false' );


function the_steps_indicator() {
    ?>

<?php
}


function the_consultation_form() {



}


wp_head();
?>

<body class="pop-up-form-template">
<?php

    the_consultation_form();

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