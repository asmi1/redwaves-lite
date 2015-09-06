<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <div>
    <span class="screen-reader-text"><?php esc_attr_e( 'Search for', 'redwaves-lite' ); ?></span>
    <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search &#8230;', 'redwaves-lite' ); ?>" value="" name="s" title="<?php esc_attr_e( 'Search for:', 'redwaves-lite' ); ?>">
	<button type="submit" class="search-submit">
		<i class="fa fa-search"></i>
	</button>	
 </div>
</form>