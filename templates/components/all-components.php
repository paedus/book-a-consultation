<?php

?>
<style type="text/css">
	#content{
		background-color:#444;
	}
	.component-container{
		width: 100%;
		padding: 10px;
		max-width: 1120px;
		margin: auto;
	}
</style>
<div class="component-container">
	
<h2 class="prim">All web components:</h2><br>
<h3 class="prim">Icons</h3><br>

<div class="elements-wrap mb15">
	<!-- /* second attribute adds position css top: $value px */ -->
	<?php the_icon('google', false ); ?>
	<?php the_icon('linkedin', false ); ?>
	<?php the_icon('apple', false ); ?>
	<?php the_icon('facebook', false ); ?>
	<?php the_icon('email', false ); ?>
	<?php the_icon('phone', false ); ?>
	<?php the_icon('map', false ); ?>
	<?php the_icon('photo', false ); ?>
	<?php the_icon('thumb-up-circle', false ); ?>
	<?php the_icon('thumb-up-circle-dark', false ); ?>
	<?php the_icon('checked-circle', false ); ?>
	<?php the_icon('search', false ); ?>
	<?php the_icon('chevron-down', false ); ?>
	<?php the_icon('cancel', false ); ?>
	<?php the_icon('thumb-up', false ); ?>
	<?php the_icon('comment', false ); ?>
	<?php the_icon('back', false ); ?>
	<?php the_icon('calendar', false ); ?>
	<?php the_icon('view', false ); ?>
	<?php the_icon('hide', false ); ?>
	<?php the_icon('arrow-back', false ); ?>
	<?php the_icon('facebook-circle', false ); ?>
	<?php the_icon('linkedin-circle', false ); ?>
	<?php the_icon('instagram-circle', false ); ?>
	<?php the_icon('cancel-dark', false ); ?>
	<?php the_icon('cancel-white', false ); ?>
	<?php the_icon('map-dark', false ); ?>
	<?php the_icon('email-dark', false ); ?>
	<?php the_icon('phone-dark', false ); ?>
	<?php the_icon('facebook-circle-dark', false ); ?>
	<?php the_icon('instagram-circle-dark', false ); ?>
	<?php the_icon('linkedin-circle-dark', false ); ?>

<br>
<br>

<?php 

the_media_image(21824,'check-mark-elipse-gold');
echo "       ";
the_media_image(21822,'check-mark-elipse');
echo "       ";
the_media_image(21930,'quotemarks-left');


 ?>
</div>
<?php

require_once ( COMPONENTS_PATH.'example/example.php' );

//the_example();

echo "<hr>";

?>
<h3 class="prim">Buttons</h3><br>
<div class="ast-row div-center" style="width: 624px;max-width: 90%;min-height: 300px;">

	<div class="ast-col-sm-6 secon-grad" style="padding:0px 10px 35px">
		<?php

		require_once ( COMPONENTS_PATH.'buttons/button.php' );
		?>

		<?php the_button('primary','#',$args = array('type'=>'primary','class'=>'mt35' ));?>

		<br>
		
		<?php the_button('primary','#',$args = array('type'=>'primary','outlined'=> true ));?>
		
		<br>
		
		<?php the_button('primary','#',$args = array('type'=>'primary','outlined'=> true, 'icon' => 'thumb-up-circle' ));?>

	</div>
	<div class="ast-col-sm-6 prim-grad" style="padding: 0 10px 35px">
 
		<?php the_button('secondary','#', $args = array('type'=>'secondary','class'=>'mt35' )); ?>

		<br>
		
		<?php the_button('secondary', '#', $args = array('type'=>'secondary','outlined'=> true )); ?>
		
		<br>
		
		<?php the_button('secondary', '#', $args = array('type'=>'secondary','outlined'=> true, 'icon' => 'thumb-up-circle-dark' )); ?>
	</div>
</div>
	<div class="div-center">
		<?php the_share_button( $args = ['text'=>'Share the article'] ); ?>
	</div>
<br><hr><br>
<?php require_once ( COMPONENTS_PATH.'cards-components.php'); ?>


<?php
require_once ( COMPONENTS_PATH.'hero-components.php');

