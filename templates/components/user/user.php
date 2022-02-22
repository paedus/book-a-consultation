<?php

if ( !defined( 'ABSPATH' ) ) exit;

function the_user_top_menu(){

	enqueue_component_css( __DIR__.'/user.css' );
	// enqueue_component_js( __DIR__.'/user.js' );

	?>
<div class="example-wrap">Example component</div>

	<?php
}