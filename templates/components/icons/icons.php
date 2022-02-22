<?php

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Sprite icons are 25x25 pixels
 */
function the_icon( $icon_name=false, $top_margin=false, $class='' ){

	if (!$icon_name) return;

	$top_margin_makrup = empty( $top_margin ) ? '':' style="top:'.$top_margin.'px" ';

	?><span class="icon-sprite icon-<?=$icon_name.' '.$class?>" <?=$top_margin_makrup?>></span><?php
}

