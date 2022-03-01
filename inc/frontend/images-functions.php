<?php

if ( !defined( 'ABSPATH' ) ) exit;

//disable native WP load="lazy"
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

//adjust srcset to load correct image on the mobile
function filter_wp_calculate_image_sizes( $sizes, $size, $image_src, $image_meta, $attachment_id ) { 
    // make filter magic happen here... 
    $sizes = '(max-width: 414px) 39vw, (max-width: 1024px) 61vw';
    return $sizes; 
}; 
          
// add the filter 
add_filter( 'wp_calculate_image_sizes', 'filter_wp_calculate_image_sizes', 10, 5 ); 


/**
 * displays image from library without srcset
 */

    function the_media_image( $img_id=false, $class='' , $size='full', $html_id=false ){

	if ( empty($img_id) ) return;

	$img_attr = get_media_image_attrributes($class,$html_id);

	add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

	echo wp_get_attachment_image( $img_id, $size, false , $img_attr);

	remove_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
}

function get_media_image_attrributes( $class, $html_id ){

	$img_attr = $class ? array('class' => $class) : false;

	if ($html_id) {
	
		$img_attr = array_merge( $img_attr,array('id'=>$html_id) );
	}

	return $img_attr;
}

function the_media_responsive_image( $img_id=false, $class='' ){

	if ( empty($img_id) ) return;

	$image_array = get_image_sizes_array( $img_id, $sizes=array('full','large','smartphone') );

	$alt_attribute_makrkup = isset($image_array['alt']) ? ' alt="'.$image_array['alt'].'" ' :'';

	?>
<picture class="res-pic">
	<source media="(max-width: 415px)" srcset="<?php echo $image_array['smartphone']; ?>">
	<source media="(max-width: 1024px)" srcset="<?php echo $image_array['large']; ?>">
	<img src="<?=$image_array['full']?>" class="res-img <?=$class?>" <?=$alt_attribute_makrkup ?> width="<?=$image_array['full-width']?>" height="<?=$image_array['full-height']?>">
</picture>
	<?php
}

//if smarphone size is changed, must be changed in function get_image_data() too
function get_image_sizes_array( $img_id=false, $sizes=array('full','large','smartphone') ){

	if (!$img_id) return false;

	foreach( $sizes as $size ){

		$image_data = wp_get_attachment_image_src( $img_id, $size );

		if ( empty($image_data[0]) ) $image_data[0]='';

		$result[$size] = $image_data[0];
		$result[$size.'-width'] = $image_data[1];
		$result[$size.'-height'] = $image_data[2];

	}

	$alt_text = get_post_meta($img_id,'_wp_attachment_image_alt',true);

	if ( !empty($alt_text) ) $result['alt'] = esc_html($alt_text);

	return $result; 

}

/*sizes has to be in order from largest to smallest*/
function the_hero_reponsive_image( $images_array, $class='',$sizes=array('full','large','smartphone') ){

	if ( empty($images_array) ) return;

	$desktop_images_array = get_image_sizes_array( ($images_array['desktop'] ?? $images_array), $sizes );

	if ( empty( $images_array['mobile'] ) ) $images_array['mobile'] = $images_array['desktop'];

	$mobile_images_array = get_image_sizes_array( ($images_array['mobile'] ?? $images_array['desktop']), array( $sizes[2]) );

	$alt_attribute_makrkup = isset($image_array['alt']) ? ' alt="'.$image_array['alt'].'" ' :'';

	?>
<picture class="res-pic">
	<source media="(max-width: 415px)" srcset="<?php echo $mobile_images_array[$sizes[2]]; ?>">
	<source media="(max-width: 1024px)" srcset="<?php echo $desktop_images_array['large']; ?>">
	<img src="<?=$desktop_images_array['full']?>" class="res-pic <?=$class?>" <?=$alt_attribute_makrkup ?> width="<?=$desktop_images_array['full-width']?>" height="<?=$desktop_images_array['full-height']?>" >
</picture>
	<?php
}

function get_post_image_id( $post_id = false ){

	$post_img_id = get_post_thumbnail_id( $post_id );

	return empty($post_img_id) ? MISSING_IMAGE_PLACEHOLDER : $post_img_id ;
}

function the_video( $args ){
	
	$css_class_markup = isset($args['class']) ? 'class="'.$args['class'].'"' :'';
	
	?>
<video autoplay="" loop="" muted="" playsinline="" <?=$css_class_markup?>>
        <source src="<?=$args['video-url']?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
	<?php
}


// <source src="https://elitevoyage.speedweb.xyz/wp-content/uploads/2021/07/istock-1267102547.mp4" type="video/ogg">