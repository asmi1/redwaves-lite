<?php
	/**
	* The sidebar containing the main widget area.
	*
	* @package redwaves-lite
	*/
	
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		return;
	}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php 
	$sidebar_settings = get_theme_mod( 'sidebar_settings', 'right_sidebar' );
	if ( $sidebar_settings == 'left_sidebar' || $sidebar_settings == 'right_sidebar' ) {
		dynamic_sidebar( 'sidebar' ); 
	} ?>
</div><!-- #secondary -->