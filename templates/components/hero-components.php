</div><!-- container -->
<h3 class="prim">Photo gallery</h3><br>
<?php

require_once ( COMPONENTS_PATH.'hero/hero.php' );
?>
<section class="sec-pd">
<?php
the_photo_gallery( 

		'Maxx Royal Belek Photo Gallery', 
		
		array(21329,15849,21331,16140,16865,21329,15849,21331,16140,16865,21329,15849,21331,16140,16865) 
	); ?>

</section>

<br><hr><br>
<?php

$args = array(

	'posts_ids'		=>	array(19767,19799,19831,20092,20123,20394,20430,23411,23438,23462,23487,23513,23541),
	
	'sec_title'	=>	'You might also like',
	
	'color_css_class'	=>	'white-bg secon'
	);

the_post_grid_section_with_load_more($args);

?>
<br><hr><br>
<h3 class="prim">Video gallery</h3><br>
<?php 

	require_once ( COMPONENTS_PATH.'hero/hero.php' );

	echo 'working but hidden so we don\'t load youtube video every time we refresh screen';
	
	the_video_gallery_section('Watch Maxx Royal Belek Video','dpTIHuf6RPQ','secon-bg');

?>
<br><hr><br>
	<h3 class="prim">Explore similar</h3><br>
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	the_explore_similar(
		'Click & Explore similar to Maxx Royal Belek',
		[['url'=>'#','text'=>'Golf Resort'],
		['url'=>'#','text'=>'Beach Resort'],
		['url'=>'#','text'=>'Spa Resort']]);
	?>
<br><hr><br>
	<h3 class="prim">CTA Section</h3><br>
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	
	the_cta_section('Do you like Maxx Royal Belek?'); 
	?>

<br><hr><br>
<h3 class="prim">Hero top slider</h3><br>
<div style="background: #111;width: 100%px;">
	<?php

	require_once ( COMPONENTS_PATH.'hero/hero.php' );


	$image_array[] = array( 'desktop' => 15829, 'mobile' => 25163 );
	$image_array[] = array( 'desktop' => 15825, 'mobile' => 25162 );
	$image_array[] = array( 'desktop' => 15833, 'mobile' => 25164 );
	$image_array[] = array( 'desktop' => 15837, 'mobile' => 25166 );

	$args['display-country'] = false;

	the_hero_slider($image_array, $args);

	?>
</div>

<br><hr><br>
<h3 class="prim">Hero reduced listings</h3><br>
<div style="background: #111;width: 100%px;">
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	
	the_hero_reduced(
		$args=[	'title'				=>'Hero listings',
				'img-id' 			=> 15829,
				'display-country'	=> false ]
	); 
	?>
</div>
<br>
<h3 class="prim">Hero reduced</h3><br>
<div style="background: #111;width: 100%px;">
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	
	the_hero_reduced(
		$args=[	'title'				=>'Hero country',
				'img-id' 			=> 15829]
	); 
	?>
</div>

<br><hr><br>
<h3 class="prim">Hero static</h3><br>
<div style="background: #111;width: 100%px;">
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	
	$args = [	'img-id' => ['desktop' => 15829, 'mobile' => 25163],
				'title'=>'Realise your Perfect Trip with Worry-Free Travel Planning'
			];
	the_hero_static($args); 
	?>
</div>
<br><hr><br>
<h3 class="prim">Sign up to newsletter</h3><br>
<div style="background: #111;width: 100%px;">
	<?php 
	require_once ( COMPONENTS_PATH.'hero/hero.php' );
	
	the_newsletter_sign_up();
	?>
</div>