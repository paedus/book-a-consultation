<?php



if ( !defined( 'ABSPATH' ) ) exit;



function the_pop_up_icon(){



	enqueue_component_css( __DIR__.'/pop-up-icon.css' );

	enqueue_component_js( __DIR__.'/pop-up-icon.js' );



	?>

<div class="example-wrap">pop-up-icon component</div>
	<div class="ast-row">
		<div class="ast-col-md-6">
			<div class="pop-up-icon secon-grad txt-center br15">
				<img class="pop-up-icon-close white" src="https://elitevoyage.speedweb.xyz/wp-content/themes/kated/assets_v3/logo/close.svg">
				<img src="https://elitevoyage2.speedweb.xyz/wp-content/uploads/2021/10/check-mark-elipse-gold.svg" class="check-mark-elipse-gold pop-up-icon-img" alt="" height="160" width="160">
				<h3 class="pop-up-icon-title heading3 white">Congratulations!</h3>
				<p class="pop-up-icon-desc white div-center">We have successfully created your account!</p>
				<a href="#" class="btn btn-outline-prim cta prim">Back to travel</a>
			</div>			
		</div>
		<div class="ast-col-md-6">
			<div class="pop-up-icon secon-grad txt-center br15">
				<img class="pop-up-icon-close white" src="https://elitevoyage.speedweb.xyz/wp-content/themes/kated/assets_v3/logo/close.svg">
				<img src="https://elitevoyage2.speedweb.xyz/wp-content/uploads/2021/10/check-mark-elipse-gold.svg" class="check-mark-elipse-gold pop-up-icon-img" alt="" height="160" width="160">
				<h3 class="pop-up-icon-title pop-up-icon-title-illus heading3 white">Thank You !</h3>
				<p class="pop-up-icon-desc pop-up-icon-desc-illus white div-center">We have received your request and our team will be with you soon.</p>
				<a href="#" class="btn btn-outline-prim cta prim">Back to travel</a>
			</div>			
		</div>

	</div>

	<?php

}