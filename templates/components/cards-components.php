<h3 class="prim">Cards</h3>
<br>
<div class="white-bg" style="padding: 20px;">
	<?php

	require_once ( COMPONENTS_PATH.'cards/cards.php' );

	?>
	<div class="ast-row mb35">
		<div class="ast-col-md-6">
		<?php
		the_card_product( ['text'=>'Seaplane Over Fjords From Bergen', 'url'=>'#', 'country'=>'Norway', 'img-id'=>21767] );

		?>	
	</div><!-- md6 -->
	<div class="ast-col-md-6">
	<?php
	
		the_card_product( ['text'=>'Maldives', 'url'=>'#', 'country'=>false, 'img-id'=>21769] );
	
	?>
	</div>
</div>
<div class="ast-row mb35">
	<div class="ast-col-md-6">
		<?php the_contact_card('Petr Udavský','co-owner', 'spolumajitel','+420 605 994 655', 21291); ?>
	</div>
	<div class="ast-col-md-6">
		<?php the_team_card( [	'name' => 'Štěpán Borovec',
								'designation' => 'project director',
								'image' => 21295
								/*,'background' =>'dark'*/]); ?>
	</div>	
</div>
<div class="ast-row mb35">
	<div class="ast-col-md-6">
		<?php the_pop_up_card('Congratulations!','We have successfully created<br>your account!'); ?>
	</div>
	<div class="ast-col-md-6">
		<?php the_pop_up_card('Thank You !','We have received your request and our team will be with you soon.'); ?>
	</div>
</div>
<div class="ast-row mb35">disables because of bug
	<?php //the_blog_listing_card(); ?>
</div>
<br><hr><br>
<div class="ast-row">
	<div class="ast-col-md-6">
		<img src="https://elitevoyage.speedweb.xyz/wp-content/uploads/2021/09/blog_img.png">
	</div>
	<div class="ast-col-md-6">
		<h3 class="heading3 black mb10">Borgo Dei Conti Resort Relais & Chateaux</h3>
		<p class="body-txt secon">The medieval city of Perugia is picturesque and smells of chocolate – mainly in October, during a festival dedicated to this sweet treat. On the local main square surrounded by old stone houses, the hands of a chocolate sculptor create a sweet masterpiece from a giant block, weighing about a ton. He throws chips of the material into the watching crowd. That is not a fairy tale; that is reality. Another magic place is just around the corner. A luxurious hotel <span class="txt-link prim">Borgo Dei Conti Resort Relais & Chateaux</span>. You can find this 17-century chateau on large – 20 ha – grounds with a view of the Nestore valley. The hotel offers elegant accommodation of the highest quality, with a renowned wellness centre and a traditional Umbrian restaurant.</p>
	</div>
</div>


</div><!-- white container end -->