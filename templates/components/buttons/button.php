<?php

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @param
 * type: primary, secondary
 * outlined: true, false
 * icon: 'thumb-up-circle' list is in icons.php
 * class: will add extra class to the button
 * button-type: adds type=button to <a>
 * cta-button: default - false, set true if this button is popup trigger
 * target: when set it will print target that is in value
 * */

function the_button( $text, $link_url='#', $args ){

	enqueue_component_css( __DIR__.'/button.css' );

	$button_data = get_button_data( $args );

	?>
		<a href="<?=$link_url?>" class="<?=$button_data['class']?>" <?=$button_data['attributes']?> >
			<?php

			the_icon( $args['icon'] ?? false, false, 'btn-icon' ); 

			echo $text;

			?> 
		</a>
	<?php

}

function get_button_data( $args ){

	$class = get_button_class( $args );

	if( $args['cta-button'] ?? false ) {

		$class .= ' cta-button-trigger';
		
		the_cta_button_functionality( $args['cta-button'] );
	}
	
	$result['class'] = $class;

	$result['attributes'] = empty( $args['cta-button'] ) ? '' :
			' data-popup="'.$args['cta-button'].'" ';

	$result['attributes'] .= empty( $args['button-type'] ) ? '' : ' type=button ' ;

	$result['attributes'] .= empty( $args['target'] ) ? '' : ' target="'.$args['target'].'" ' ;

	return $result; 

}


function the_cta_button_functionality( $cta_type ){

	if ( !is_string($cta_type) ) return;

	@include_once ( trailingslashit( get_stylesheet_directory() ) ) . '/inc/frontend/cta-pop-up-'.$cta_type.'.php';

}


/**
 * function get_button_class
 * 
 * @param $args: array
	[type] => primary/secondary
	[outlined] => true/false
	[icon] => thumb-up-circle-dark
 * 
 * 
 **/

function get_button_class( $args ){

	if ($args['type'] == 'secondary') return get_secondary_button_class($args);

	return get_primary_button_class( $args );

}

function get_secondary_button_class( $args ){

	$result = ($args['outlined'] ?? false) ? 'btn btn-outline-secon cta secon':'btn btn-secon secon-grad cta white';

	$extra_css = isset($args['class']) ? ' '.$args['class'].' ':' ';

	return $result.$extra_css;

}

function get_primary_button_class( $args ){

	$result = ($args['outlined'] ?? false) ? 'btn btn-outline-prim cta prim':'btn btn-prim prim-grad cta white';

	$extra_css = isset($args['class']) ? ' '.$args['class'].' ':' ';

	return $result.$extra_css;

}


function the_share_button( $args=array() ){

	wp_reset_query();//to get correct share url
	
	$args = get_sharebutton_defaults($args);

	$shortcode = add_to_sharebutton_styles_markup(
						do_shortcode('[scriptless]'),$args);
	
	echo $shortcode;

	the_sharebutton_text( $args['text'] ?? false );
}

function the_sharebutton_text($text){

	if (!$text) return;

	$button_text = get_share_button_lang_version($text);

	?>
	<style>
		.scriptlesssocialsharing:before{
			content: '<?=$button_text?>';
		}
	</style>
	<?php
}

function add_to_sharebutton_styles_markup( $shortcode, $args ){

	$strings_to_replace = array(
		'class="scriptlesssocialsharing"'=>
			'class="'.$args['css-class'].'scriptlesssocialsharing"'
	);

	foreach ( $strings_to_replace as $needle => $replacement ) {

		$shortcode = str_replace($needle, $replacement, $shortcode);

	}

	return $shortcode;
}

function get_sharebutton_defaults($args=array()){

	$defaults=array(	'type'=>'primary',
						'outlined' => true,
	);

	foreach ($defaults as $key => $value){

		if ( !isset( $args[$key] ) ) $args[$key] = $value;
	}

	$args['css-class'] = get_button_class($args);

	return $args;
}

function form_radio_button($args) {
    ?>

    <div class="form-radio-button mb24">
        <div class="form-radio-btn-check"></div>
        <input type="radio" required class="radio-button-input" name="form-choices" value="<?= $args['value'] ?>">
        <span class="radio-button-title intro-txt txt-center"><?= $args['title'] ?></span>
    </div>

    <?php
}


function listed_radio_buttons($args) {

    $buttons = $args['buttons'];

    foreach($buttons as $button) {

        form_radio_button($button);

    }

}

function the_listed_radio_buttons($args=array()) {

    if( empty($args['buttons']) ) return false;

    ?>

    <div class="listed-radio-buttons">

        <?php listed_radio_buttons($args); ?>

    </div>

    <?php
}
