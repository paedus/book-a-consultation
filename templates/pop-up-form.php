<?php
/*
Template Name: Pop up form
*/

if ( !defined( 'ABSPATH' ) ) exit;

// $form_data = get_acf_repeater('form_text',['form_name','title','title_cz']);
	
// vd($form_data);

// add_shortcode('popup_form_title','popup_form_title_shortcode');

function parse_popup_form_title_shortcode( $form_content, $key ){

	$title = get_popup_title( $key );

	if ( empty($title) ) return $form_content;

	$title_markup = '<h3 class="heading3 secon mb24 txt-center">'.$title.'</h3>';


	return str_replace('[popup_form_title]', $title_markup, $form_content);
}


function get_popup_title( $key ){
	
	$title = get_popup_form_acf_title( $key );

	$post_id = get_var('id');

	if ( empty($post_id )) return $title;

	$post_title = IS_DEFAULT_LANGUAGE ? get_the_title($post_id) : get_explore_title_cz( $post_id );

	if ( empty($post_title) ) $post_title = get_the_title($post_id);

	return $title.' '.$post_title;

}



function get_popup_form_acf_title( $key ){

	$title_field_name = IS_DEFAULT_LANGUAGE ? 'title':'title_cz';

	$form_data_array = get_acf_repeater('form_text',['form_name','title','title_cz']);

	foreach ($form_data_array as $form_data ) {

		if ($form_data['form_name'] == $key ) return $form_data[$title_field_name];
	
	}

	return '';
}

add_shortcode('popup_thank_you','popup_thank_you_shortcode');

function popup_thank_you_shortcode(){

	$data = get_thankyou_data();
	?>
	<div class="secon-grad br15 white">
		<div class="thankyou-wrap div-center">
			<?php the_media_image(30997,'div-center mb24'); ?>
			<h3 class="heading3 mb24 txt-center"><?=$data['title']?></h3>
			<p class="body-txt txt-center"><?=$data['text']?></p>
			<?php the_button( $data['button-text'] , '/experiences/', $args = array('type'=>'primary','outlined'=> true, 'target' =>'_parent' )); ?>
		</div>
	</div>
	<?php

	//direct output to avoid adding classes to form
	return false;
}

function get_thankyou_data(){

	return [	'title'=>get_acf_field('thank_you_title'),
			'text'=>get_acf_field('thank_you_text'),
			'button-text'=>get_acf_field('thank_you_button_text')
		];
}

add_action('wp_print_styles',

	function(){

		enqueue_my_style( 'button', 'templates/components/buttons/button.css' );
		enqueue_my_style( 'contact-page', 'assets/css/contact-page.css' );
		enqueue_my_style('cta-pop-up-style','assets/css/cta-pop-up.css');

		wp_deregister_style( 'fluentform-public-default' );
		wp_dequeue_style( 'fluentform-public-default' );
		wp_deregister_style( 'fluent-form-styles' );
		wp_dequeue_style( 'fluent-form-styles' );

	}

);

add_filter( 'show_admin_bar', '__return_false' );

wp_head();
?>

<body class="pop-up-form-template">
<?php

// echo do_shortcode('[popup_thank_you]');
the_cta_form();

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

function the_cta_form(){

	$form_content_array = get_cta_shortcode();

	$form_content = do_shortcode( $form_content_array['shortcode'] );

	if ( empty( $form_content) ) return;
	
	$class_list = array( // 'tag' => 'class list'
		'label'                 => 'small-txt prim field-label',
		'input'                 => 'secon body-txt default-input',
		'textarea'              => 'secon body-txt default-textarea',
		'button'                => 'btn btn-prim prim-grad cta white'
	);

	$form_content = append_classes_to_content($form_content, $class_list); 

	$form_content = parse_popup_form_title_shortcode( $form_content, $form_content_array['key'] );

	$form_content = replace_form_language_links( $form_content );
	
	echo $form_content;	
}

function get_cta_shortcode(){
		
	$default = 'bookacall';

	$shortcodes= array(
		'bookacall'	=> '[fluentform id="9"]',
		'sendrequest'	=> '[fluentform id="10"]',
		'thankyou'	=> '[popup_thank_you]'

	);

	$form_key = empty($shortcodes[ get_var('form') ]) ? $default : get_var('form');

	return ['key'=>$form_key,'shortcode'=>$shortcodes[$form_key] ] ;
}