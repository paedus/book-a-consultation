<?php

if ( !defined( 'ABSPATH' ) ) exit;

function the_slider( $args ){

	enqueue_component_css( __DIR__.'/slider.css' );

	enqueue_component_css( __DIR__.'/splide.min.css' );

	enqueue_component_js( __DIR__.'/splide.min.js' );

	$slider_id =(string) rand(1,999);

	$args['slider_id'] = $slider_id;

	$slider_wrap_class = $args['slider-wrap-css'] ?? $args['type'].'-slider';

	?>

<div class="slider-wrap <?=$slider_wrap_class?>">

	<?php apply_filters('inside_slider_wrap', '');?>

	<div id="image-slider-<?=$slider_id?>" class="splide">

		<div class="splide__track">

			<ul class="splide__list">

				<?php the_slider_img_loop($args); ?>

			</ul>

		</div>

	</div>

	<?php

	if ( (get_slider_config( $args )['lightbox']??false) === true) the_lightbox( $args );

	?>

</div>

	<?php

	slider_js_config( $args );

}

function the_lightbox( $args ){

	?><div id="<?=$args['slider_id']?>" class="lightbox-wrap hidden"><?php

	the_icon('cancel-white',0,'lightbox-close'); 

	foreach ( $args['img-ids'] as $key => $img_id ){

		$img_html_id=$args['slider_id'].'-'.$img_id;

		the_media_image( $img_id, 'lightbox-single-image hidden', 'full', $img_html_id);

	}

	?></div>

<script type="text/javascript">

	jQuery(document).ready(function() {

		jQuery('.wide-rectangle-gallery').click(function(){

			jQuery('.lightbox-wrap').removeClass('hidden');

			jQuery('.lightbox-single-image').addClass('hidden');

			jQuery('.lightbox-wrap').find('#'+ jQuery(this).attr('id')).eq(0).removeClass('hidden');

		});

		jQuery(document).on('click', '.lightbox-close', function(){

			jQuery('.lightbox-wrap, .lightbox-wrap-button').addClass('hidden');

		});

		jQuery(document).mouseup(function(e) 

		{

			var container = jQuery(".lightbox-single-image");

			// if the target of the click isn't the container nor a descendant of the container

			if (!container.is(e.target) && container.has(e.target).length === 0) 

			{

			    jQuery('.lightbox-wrap').addClass('hidden');

			}

		});

		jQuery(document).on('click','.photo-gallery-wrap .btn', function() {

			jQuery('.lightbox-wrap-button').removeClass('hidden');

		});

	});

</script>

	<?php

}

function the_slider_img_loop( $args ){

	$loop_object = $args['img-ids'] ?? $args['posts-object'] ?? false;

	if ( empty($loop_object) ) return;

	$config = get_slider_config( $args );

	foreach ( $loop_object as $key => $object ){

		$args['img-possition'] = $key;
		
		?>

		<li class="splide__slide">

			<?php display_slide_by_type( $object, $args, $config ); ?>

		</li>

		<?php

	}

}

function display_slide_by_type( $object, $args, $config ){

	$class= get_slider_image_class( $config, $args);

	call_user_func($config['function'], $object, $class, $config['slider-id']);

}

function get_slider_image_class( $config, $args ){

	$css_class = $config['class'] ?? '';

	if ( has_lazyload_css_class( $args ) ) return $css_class.' no-ll';

	return $css_class;

}

function has_lazyload_css_class( $args ){

	return  !empty( $args['first-img-no-ll'] ) && $args['img-possition'] === 0;
}	

function the_wide_rectangle_gallery_image( $img_id, $class, $slider_id ){

	$img_html_id=$slider_id.'-'.$img_id;

	the_media_image( $img_id, $class, 'medium', $img_html_id );

	

}

function the_single_gallery_image( $img_id, $class, $slider_id ){

	the_media_image( $img_id, $class, 'full' );

}

function the_hero_image( $img_id, $class ){

	the_hero_reponsive_image( $img_id, $class );
	// the_media_responsive_image( $img_id, $class );

	?>
	<div class="hero-overlay">
	</div>
	<?php
}

function the_cpt_gallery( $post_data, $class ){

	the_card_product( 	[	'text'		=>	$post_data['title'],
							'url'		=>	$post_data['url']??null,
							'country'	=>	$post_data['country'] ?? false,
							'img-id'	=>	$post_data['img-id'],
							'class' 	=>	$class
					]);
}

function the_customer_review_slide( $review_data, $class ){
	
	?>
	<div class="<?=$class?>">
		<p class="testimonial-text div-center txt-center mb8">
			<?=strip_tags($review_data['testimonial'],'<br>');?>
		</p>
		<div class="intro-txt txt-center mb8">
			<?=$review_data['name']?>
		</div>
	</div>
	<?php

}

function the_our_work_gallery( $args, $class ){

	$args = [	'text'		=>	$args['title'],
				'url'		=>	$args['link']['url']??null,
				'country'	=>	false,
				'img-id'	=>	$args['image']
			];
	the_card_product( $args );

}

function the_team_gallery( $args, $class) {

	$args['background'] ='dark';
	
	if (empty($args['image']) ) $args['image'] = MISSING_IMAGE_PLACEHOLDER;

	the_team_card( $args ); 

}

function get_slider_config( $args ){
	
	if ( $args['type'] === 'wide-rectangle-gallery' ) return array(

				// type   : 'loop',
				// focus  : 'center'
				//default resolution 5k 5120px wide
				'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints:
				 {
				 	
				 	3000: {perPage: 9,},
				 	2300: {perPage: 7,},
				 	1800: {perPage: 5,},
				 	1025: {perPage: 3,},

				 }',

				'function' => 'the_wide_rectangle_gallery_image',

				'class'=> 'wide-rectangle-gallery',

				'slider-id' => $args['slider_id'],

				'lightbox' => true

			);

	if ($args['type'] === 'fullscreen-single' ) return array(

				'js-config' => 'pagination:false,arrows:true,perPage: 1,gap: 0',

				'function' => 'the_single_gallery_image',

				'class'=> 'single-fullscreen',

				'slider-id' => $args['slider_id']

			);


	if ($args['type'] === 'hero' ) return array(	

			'js-config' => 'lazyLoad: \'nearby\', pagination:true,arrows:false,perPage: 1',

			'function'=>'the_hero_image',

			'class'=> 'hero-image',

			'slider-id' => null

		);

	if ($args['type'] === 'cpt-gallery' ) return array(	

			'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints: {4285: {perPage: 13},3630: {perPage: 11},2976: {perPage: 9},2321: {perPage: 7},1659: {perPage: 5}, 999: {perPage: 3}}',

			'function'=>'the_cpt_gallery',

			'slider-id' => null

		);

    if ($args['type'] === 'cpt-gallery-not-loop' ) return array(

        'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints: {4285: {perPage: 13},3630: {perPage: 11},2976: {perPage: 9},2321: {perPage: 7},1659: {perPage: 5}, 999: {perPage: 3}}',

        'function'=>'the_cpt_gallery',

        'slider-id' => null,

        'check_for_looping' => true

    );	  
	if ($args['type'] === 'team-gallery' ) return array(	

			'js-config' => get_team_gallery_config( $args ),

			'function'=>'the_team_gallery',

			'slider-id' => null

		);

	if ($args['type'] === 'customer-review' ) return array(

			'js-config' => 'pagination:true,arrows:false,perPage: 1,gap: 0',

			'function' => 'the_customer_review_slide',

			'class'=> 'customer-review',

			'slider-id' => $args['slider_id']

		);

	if ( $args['type'] === 'our-work-gallery' ) return array(	

			'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints: {4285: {perPage: 13},3630: {perPage: 11},2976: {perPage: 9},2321: {perPage: 7},1659: {perPage: 5}, 999: {perPage: 3}}',

			'function'=>'the_our_work_gallery',

			'slider-id' => null

		);




	// if ($args['type'] === '' ) return 

	return false;
/*
	$config_profiles = array(

		'wide-rectangle-gallery'=> array(

			// type   : 'loop',
			// focus  : 'center'
			//default resolution 5k 5120px wide
			'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints:
			 {
			 	
			 	3000: {perPage: 9,},
			 	2300: {perPage: 7,},
			 	1800: {perPage: 5,},
			 	1025: {perPage: 3,},

			 }',

			'function' => 'the_wide_rectangle_gallery_image',

			'class'=> 'wide-rectangle-gallery',

			'slider-id' => $args['slider_id'],

			'lightbox' => true

		),

		'fullscreen-single'=> array(

			'js-config' => 'pagination:false,arrows:true,perPage: 1,gap: 0',

			'function' => 'the_single_gallery_image',

			'class'=> 'single-fullscreen',

			'slider-id' => $args['slider_id']

		),

		'hero'=> array(	

			'js-config' => 'lazyLoad: \'nearby\', pagination:true,arrows:false,perPage: 1',

			'function'=>'the_hero_image',

			'class'=> 'hero-image',

			'slider-id' => null

		),

		'cpt-gallery'=> array(	

			'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints: {4285: {perPage: 13},3630: {perPage: 11},2976: {perPage: 9},2321: {perPage: 7},1659: {perPage: 5}, 999: {perPage: 3}}',

			'function'=>'the_cpt_gallery',

			'slider-id' => null

		),

		'our-work-gallery'=> array(	

			'js-config' => 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 15,gap: 8,breakpoints: {4285: {perPage: 13},3630: {perPage: 11},2976: {perPage: 9},2321: {perPage: 7},1659: {perPage: 5}, 999: {perPage: 3}}',

			'function'=>'the_our_work_gallery',

			'slider-id' => null

		),

		'team-gallery'=> array(	

			'js-config' => get_team_gallery_config( $args ),

			'function'=>'the_team_gallery',

			'slider-id' => null

		),

		'customer-review'=> array(

			'js-config' => 'pagination:true,arrows:false,perPage: 1,gap: 0',

			'function' => 'the_customer_review_slide',

			'class'=> 'customer-review',

			'slider-id' => $args['slider_id']

		)

	);

	return $config_profiles[$args['type']];
*/
}

function get_team_gallery_config( $args ){

	$result = 'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: '.count( $args['posts-object']);

	$result .= ',gap: 8,breakpoints:{';

	$result .= '5801: {focus  : \'left\', type:\'loop\',perPage: 8},';
	$result .= '2023: {focus  : \'center\', type:\'loop\',perPage: 8},';
	$result .= '1750: {focus  : \'center\', type:\'loop\',perPage: 7},';
	$result .= '1250: {perPage: 5},'; 
	$result .=' 760: {perPage: 3}';
	$result .= '}';

	return $result; 
	
}

/*
'focus  : \'center\', type:\'loop\',pagination:false,arrows:false,perPage: 17,gap: 8,breakpoints: {3745: {perPage: 15},3240: {perPage: 13},2740: {perPage: 11},2240: {perPage: 9},1750: {perPage: 7},1250: {perPage: 5}, 760: {perPage: 3}}';

*/



function slider_js_config( $args ){

	$slider_configs = get_slider_config($args);

	$config_string = $slider_configs['js-config'];

	if (empty($config_string)) return;
	?>

	<script>

      jQuery(document).ready(function($) {

          var splide = new Splide( '#image-slider-<?php echo $args['slider_id'] ; ?>',{ <?php echo $config_string; ?>} );

          <?php if(isset($slider_configs['check_for_looping']) && $slider_configs['check_for_looping'] ) : ?>

          splide.on( 'mounted', function () {

              var productsCount = splide.Components.Elements.slides.length;

              if( $(window).width() <= 768 && productsCount > 1 ) return true;

              var sliderElement = $('#image-slider-<?php echo $args['slider_id'] ; ?>'),
                  productCardWidth = 320,
                  productCardWhidth = 320,
                  cardsGap = 8,
                  windowWidth = $(window).width(),
                  slider_width = productsCount * ( productCardWidth + cardsGap);

              if( slider_width < windowWidth || productsCount == 1 ) {
                  splide.destroy();
                  sliderElement.addClass('destroyed-slider');
              }

          } );

          <?php endif; ?>

          splide.mount();

	  } );

	</script>

	<?php

}