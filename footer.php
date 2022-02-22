<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); 

the_ev_footer();

function the_ev_footer(){

	$social_links = get_ev_social_links();

	$policy_links = get_ev_policy_links();
?>
	</div> <!-- ast-container -->
	</div><!-- #content -->
	</div><!-- #page -->
	<?php do_action('astra_above_footer'); ?>
<footer class="site-footer secon-bg" id="colophon" itemtype="https://schema.org/WPFooter" itemscope="itemscope" itemid="#colophon">
	<div class="footer-wrap-top ast-container">
		<div class="footer-contact div-center txt-center mt35">
			<div class="paragraph-span prim">Contact</div>
			<h2 class="heading2 white mb20">Reach us at</h2>
			<div class="paragraph-span white mb20"><?php the_icon('phone', 9, 'mr10')?></span>+420 731 344 444</div>
			<div class="paragraph-span white mb20"><?php the_icon('email', 11, 'mr10')?></span>contact@elitevoyage.com</div>
			<div class="paragraph-span white mb20">
				<a class="footer-link" href="<?=$social_links['fb']?>">
					<span class="icon-sprite icon-facebook-circle"></span>
				</a>
				<a class="footer-link" href="<?=$social_links['ig']?>">
					<span class="icon-sprite icon-instagram-circle"></span>
				</a>
				<a class="footer-link" href="https://www.linkedin.com/company/elitevoyage-club/">
					<span class="icon-sprite icon-linkedin-circle"></span>
				</a>
			</div>
			<?php echo do_shortcode('[language-switcher]'); ?>
		</div>
	</div>
	<hr class="prim-bg mt32">
	<div class="footer-wrap-bottom ast-container">
		<div class="footer-links ma txt-center mt35 mb35">
			<span class="footer-pages"><a href='<?=$policy_links['terms']?>' class="small-caption disable-translate" target="_blank">Trade terms</a></span>
			<span class="footer-pages"><a href='<?=$policy_links['data-protection']?>' class="small-caption disable-translate" target="_blank">Personal data protection</a></span>
			<span class="footer-pages"><a href='<?=$policy_links['insurance']?>' class="small-caption disable-translate" target="_blank">Concession and insurance</a></span>
		</div>
		<div class="small-txt txt-center width-100 mb35">Company is registered in the trade register kept by the District Court of Praha, section, B, file no. 288155.</div>
		<div class="ast-col-sm-6 txt-center mb35">
			<h2 class="heading3 white mb35">Our Partners</h2>
			<div class="footer-partners-wrap ast-row">
				<div class="ast-col-xs-4">
					<a class="footer-link" href="https://www.elite-education.cz/">
						<?php  the_media_image( 21805, 'footer-partner-img') ?>
					</a>
				</div>
				<div class="ast-col-xs-4">
					<a class="footer-link" href="https://www.elitemedical.eu/">
						<?php  the_media_image( 21809, 'footer-partner-img') ?>
					</a>
				</div>
				<div class="ast-col-xs-4">
					<a class="footer-link" href="https://elitegourmet.cz/">
						<?php  the_media_image( 21807, 'footer-partner-img') ?>
					</a>
				</div>
			</div>
		</div>
		<div class="ast-col-sm-6 txt-center mb35">
			<h2 class="heading3 white mb35">Proud member of</h2>
			<div class="footer-partners-wrap ast-row">
				<div class="ast-col-xs-6">
					<a class="footer-link" href="https://www.iata.org/">
						<?php  the_media_image( 21811, 'footer-partner-img') ?>
					</a>
				</div>
				<div class="ast-col-xs-6">
					<a class="footer-link" href="http://www.travellermade.com/">
						<?php  the_media_image( 21937, 'footer-partner-img')//21937 ?>
					</a>
				</div>
			</div>
		</div>

	</div>
</footer>
<?php 
}

	astra_body_bottom();    
	wp_footer(); 
?>
	</body>
</html>
