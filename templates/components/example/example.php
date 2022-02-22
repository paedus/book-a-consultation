<?php

if ( !defined( 'ABSPATH' ) ) exit;

function the_example(){

	enqueue_component_css( __DIR__.'/example.css' );
	enqueue_component_js( __DIR__.'/example.js' );

	?>
<div class="example-wrap">Example component</div>

	<?php
}