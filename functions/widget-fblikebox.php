<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: RedWaves Facebook Like Box
	Description: A widget that displays your Facebook Like Box for Facebook Page.
	Version: 2.0

-----------------------------------------------------------------------------------*/

class redwaves_fblikebox_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'redwaves_fblikebox_widget',
            __('RedWaves: Facebook Like Box', 'redwaves-lite' ),
            array( 'description' => __( 'Displays Facebook Like Box.', 'redwaves-lite' ), )
        );
    }	
	public function form( $instance ) {

		$title 		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'Find us on Facebook!', 'redwaves-lite' );
     	$app_id 	= ! empty( $instance['app_id'] ) ? $instance['app_id'] : '';
     	$href 		= ! empty( $instance['href'] ) ? $instance['href'] : '';
     	$width 		= ! empty( $instance['width'] ) ? $instance['width'] : '297';
     	$height 	= ! empty( $instance['height'] ) ? $instance['height'] : '';
     	$color 		= ! empty( $instance['color'] ) ? $instance['color'] : 'light';
     	$showfaces 	= ! empty( $instance['showfaces'] ) ? $instance['showfaces'] : '1';
     	$stream 	= ! empty( $instance['stream'] ) ? $instance['stream'] : '';
     	$header 	= ! empty( $instance['header'] ) ? $instance['header'] : '1';
     	$showborder	= ! empty( $instance['showborder'] ) ? $instance['showborder'] : '1';
	    ?>
	 
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'redwaves-lite') ?></label>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
	    </p>
	    <p>
		    <label for="<?php echo $this->get_field_id( 'app_id' ); ?>"><?php _e('App Id', 'redwaves-lite') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'app_id' ); ?>" name="<?php echo $this->get_field_name( 'app_id' ); ?>" value="<?php if(isset($app_id)){echo esc_attr( $app_id );} ?>" />

		    <small><?php _e('You must enter your App ID here, to get an App ID Go to <a target="_blank" href="https://developers.facebook.com/">FB Developer</a> and create FB app. Still need help? check this <a target="_blank" href="http://premium.wpmudev.org/forums/topic/guide-updated-ultimate-facebook-plugin-for-2014">tutorial</a>.', 'redwaves-lite') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'href' ); ?>"><?php _e('Facebook Page URL', 'redwaves-lite') ?></label>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'href' ); ?>" name="<?php echo $this->get_field_name( 'href' ); ?>" value="<?php if(isset($href)){echo esc_attr( $href );} ?>" />
	    	<small><?php _e('The absolute URL of your Facebook Page. e.g: https://www.facebook.com/themient', 'redwaves-lite') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width', 'redwaves-lite') ?></label>
	    	<input type="number" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php if(isset($width)){echo esc_attr( $width );} ?>" min="292">
	    	<small><?php _e('The width of the widget in pixels. Minimum is 292.', 'redwaves-lite') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', 'redwaves-lite') ?></label>
	    	<input type="number" class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php if(isset($height)){echo esc_attr( $height );} ?>" min="63">
	    	<small><?php _e('The height of the plugin in pixels. The default height varies based on number of faces to display, and whether the stream is displayed.', 'redwaves-lite') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e('Color Scheme', 'redwaves-lite') ?></label>
	    	<select class="widefat" name="<?php echo $this->get_field_name( 'color' ); ?>">
                <option value="light" <?php selected( $color, 'light' ); ?>>Light</option>
                <option value="dark" <?php selected( $color, 'dark' ); ?>>Dark</option>
            </select>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'showfaces' ); ?>" name="<?php echo $this->get_field_name( 'showfaces' ); ?>" value="1" <?php echo ( $showfaces == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'showfaces' ); ?>"><?php _e('Show Friends\' Faces', 'redwaves-lite') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" value="1" <?php echo ( $stream == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'stream' ); ?>"><?php _e('Show Posts', 'redwaves-lite') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'header' ); ?>" name="<?php echo $this->get_field_name( 'header' ); ?>" value="1" <?php echo ($header == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'header' ); ?>"><?php _e('Show Header', 'redwaves-lite') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'showborder' ); ?>" name="<?php echo $this->get_field_name( 'showborder' ); ?>" value="1" <?php echo ($showborder == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'showborder' ); ?>"><?php _e('Show Border', 'redwaves-lite') ?></label>
	    </p>
	    <?php
	}

	public function update( $new_instance, $old_instance ) {
	    $instance = $old_instance;
	 
	    /* Strip tags for title and name to remove HTML (important for text inputs). */
	    $instance['title'] 		= strip_tags( $new_instance['title'] );
	    $instance['app_id'] 	= strip_tags( $new_instance['app_id'] );
	    $instance['href'] 		= strip_tags( $new_instance['href'] );
	    $instance['width'] 		= strip_tags( $new_instance['width'] );
	    $instance['height'] 	= strip_tags( $new_instance['height'] );
	    $instance['color']		= strip_tags( $new_instance['color'] );	 
	    $instance['showfaces'] 	= (bool)$new_instance['showfaces'];
	    $instance['stream'] 	= (bool)$new_instance['stream'];
	    $instance['header'] 	= (bool)$new_instance['header'];
	    $instance['showborder']	= (bool)$new_instance['showborder'];

	    return $instance;
	}

	public function widget( $args, $instance ) {
		
		extract($args);
	    /* Our variables from the widget settings. */
	    $title 			= apply_filters('widget_title', $instance['title'] );	
	    $app_id 		= $instance['app_id'];
	    $href 			= $instance['href'];
	    $width 			= $instance['width'];
	    $height 		= $instance['height'];
	    $color 			= $instance['color'];
	    $showfaces 		= ($instance['showfaces'] == "1" ? "true" : "false");
	    $header 		= ($instance['header'] == "1" ? "true" : "false");
	    $stream 		= ($instance['stream'] == "1" ? "true" : "false");
	    $showborder 	= ($instance['showborder'] == "1" ? "true" : "false");	 

	    add_action('wp_footer', array(&$this,'fb_like_box_js'));
	 
	    /* Display the widget title if one was input (before and after defined by themes). */
	    echo $args['before_widget'];
	 
	    if ( ! empty( $title ) ) {
	        echo $args['before_title'] . $title . $args['after_title'];
	    }
	 
	    /* Like Box */
		if($href): ?>
			<div class="fb-like-box widget-container" data-href="<?php echo $href; ?>" data-height="<?php echo $height; ?>" data-width="<?php echo $width; ?>" data-colorscheme="<?php echo $color; ?>" data-show-faces="<?php echo $showfaces; ?>" data-header="<?php echo $header; ?>" data-stream="<?php echo $stream; ?>" allowTransparency="true" data-show-border="<?php echo $showborder; ?>"></div>
		<?php endif;		

	    echo $args['after_widget'];
	}

	/**
	 * Add Facebook javascripts
	 */
	public function fb_like_box_js() {
		global $app_id;
		echo '<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId='.$app_id.'&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));</script>';
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget("redwaves_fblikebox_widget");' ) );