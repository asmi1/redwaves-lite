<?php
	/**
	* The template for displaying the footer.
	*
	* Contains the closing of the #content div and all content after
	*
	* @package redwaves-lite
	*/
?>

</div><!--/.main-container -->
<footer id="colophon" class="site-footer sb-slide" role="contentinfo">
	<div class="footersep"></div>
	<div class="copyrights">
		<div class="container">
			<?php redwaves_copyrights(); ?>
		</div>
	</div>
</footer>
</div><!--/#page -->

<?php $side = get_theme_mod( 'mobile_menu_side', 'left' ); 
$style = get_theme_mod( 'mobile_menu_style', 'overlay' ); ?>
<div class="sb-slidebar sb-<?php echo $side; ?> sb-width-custom sb-style-<?php echo $style; ?>" data-sb-width="250px">
	<div id="mobile-menu-wrapper">
		<a href="javascript:void(0); " id="sidemenu_show" class="sideviewtoggle sb-toggle sb-toggle-<?php echo $side; ?>"><i class="fa fa-bars" style="margin:0 8px;" aria-hidden="true"></i><?php _e( 'Menu', 'redwaves-lite' );?></a>
		<?php redwaves_small_search_bar() ?>
		<nav id="navigation" class="clearfix">
			<div id="mobile-menu" class="mobile-menu">
				<?php if ( has_nav_menu( 'mobile-menu' ) ) {
					wp_nav_menu( array( 'theme_location' => 'mobile-menu', 'menu_class' => 'menu' ) ); 
				}else{ ?>
					<div class="no-menu-msg"><?php _e('Please assign a menu (Go to Appearance => Menus and assign a menu to "Mobile Menu" location)', 'redwaves-lite') ?></div>
				<?php } ?>
			</div>
		</nav>							
	</div>
</div>
<div class="obfuscator sb-toggle-<?php echo $side; ?>"></div>

<?php wp_footer(); ?>
</body>
</html>