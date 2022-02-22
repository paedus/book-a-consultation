<?php

if ( !defined( 'ABSPATH' ) ) exit;

if ( IS_PRODUCTION && !has_string($_SERVER['REQUEST_URI'],'/pop-up-form/') ) add_action('wp_head','the_google_analytics');


function the_google_analytics(){

	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167520039-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-167520039-1');
</script>
	<?php
}
