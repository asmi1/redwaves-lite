<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: RedWaves Social Icons
	Description: This widget shows social icons in the sidebar.
	Version: 1.0

-----------------------------------------------------------------------------------*/

class Social_Profile_Icons_Widget extends WP_Widget {

	protected $defaults;
	protected $sizes;
	protected $profiles;

	function __construct() {

		$this->defaults = array(
			'title'			=> '',
			'new_tab'		=> 0,
			'size'			=> 32,
			'facebook'		=> '',
			'twitter'		=> '',			
			'gplus'			=> '',	
			'youtube'		=> '',		
			'rss'			=> '',			
			'pinterest'		=> '',
			'linkedin'		=> '',			
			'stumbleupon'		=> '',			
			'reddit'		=> '',			
			'tumblr'		=> '',			
			'instagram'		=> '',			
			'vimeo'			=> '',
			'foursquare'		=> '',	
			'soundcloud'		=> '',		
			'github'		=> '',			
			'flickr'		=> '',							
			'skype'			=> '',			
			'behance'		=> '',
			'dribbble'		=> '',
			'dropbox'		=> '',
			'email'			=> '',
		);


		$this->sizes = array( '32' );

		$this->profiles = array(
			'facebook' => array(
				'label'	  => __( 'Facebook URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-facebook"><a title="Facebook" href="%s" %s><i class="fa fa-facebook"></i></a></li>',
			),
			'twitter' => array(
				'label'	  => __( 'Twitter URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-twitter"><a title="Twitter" href="%s" %s><i class="fa fa-twitter"></i></a></li>',
			),
			'gplus' => array(
				'label'	  => __( 'Google+ URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-gplus"><a title="Google+" href="%s" %s><i class="fa fa-google-plus"></i></a></li>',
			),
			'youtube' => array(
				'label'	  => __( 'YouTube URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-youtube"><a title="YouTube" href="%s" %s><i class="fa fa-youtube"></i></a></li>',
			),			
			'rss' => array(
				'label'	  => __( 'RSS URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-rss"><a title="RSS" href="%s" %s><i class="fa fa-rss"></i></a></li>',
			),			
			'pinterest' => array(
				'label'	  => __( 'Pinterest URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-pinterest"><a title="Pinterest" href="%s" %s><i class="fa fa-pinterest"></i></a></li>',
			),			
			'linkedin' => array(
				'label'	  => __( 'Linkedin URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-linkedin"><a title="LinkedIn" href="%s" %s><i class="fa fa-linkedin"></i></a></li>',
			),			
			'stumbleupon' => array(
				'label'	  => __( 'StumbleUpon URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-stumbleupon"><a title="StumbleUpon" href="%s" %s><i class="fa fa-stumbleupon"></i></a></li>',
			),
			'reddit' => array(
				'label'	  => __( 'Reddit URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-reddit"><a title="Reddit" href="%s" %s><i class="fa fa-reddit"></i></a></li>',
			),			
			'tumblr' => array(
				'label'	  => __( 'Tumblr URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-tumblr"><a title="Tumblr" href="%s" %s><i class="fa fa-tumblr"></i></a></li>',
			),			
			'instagram' => array(
				'label'	  => __( 'Instagram URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-instagram"><a title="Instagram" href="%s" %s><i class="fa fa-instagram"></i></a></li>',
			),			
			'vimeo' => array(
				'label'	  => __( 'Vimeo URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-vimeo"><a title="Vimeo" href="%s" %s><i class="fa fa-vimeo-square"></i></a></li>',
			),
			'foursquare' => array(
				'label'	  => __( 'FourSquare URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-foursquare"><a title="FourSquare" href="%s" %s><i class="fa fa-foursquare"></i></a></li>',
			),	
			'soundcloud' => array(
				'label'	  => __( 'Soundcloud URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-soundcloud"><a title="LinkedIn" href="%s" %s><i class="fa fa-soundcloud"></i></a></li>',
			),						
			'github' => array(
				'label'	  => __( 'GitHub URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-github"><a title="GitHub" href="%s" %s><i class="fa fa-github-alt"></i></a></li>',
			),
			'flickr' => array(
				'label'	  => __( 'Flickr URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-flickr"><a title="Flickr" href="%s" %s><i class="fa fa-flickr"></i></a></li>',
			),			
			'skype' => array(
				'label'	  => __( 'Skype URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-skype"><a title="LinkedIn" href="%s" %s><i class="fa fa-skype"></i></a></li>',
			),						
					
			'behance' => array(
				'label'	  => __( 'Behance URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-behance"><a title="Behance" href="%s" %s><i class="fa fa-behance"></i></a></li>',
			),
			'dribbble' => array(
				'label'	  => __( 'Dribbble URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-dribbble"><a title="Dribbble" href="%s" %s><i class="fa fa-dribbble"></i></a></li>',
			),
			'dropbox' => array(
				'label'	  => __( 'Dropbox URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-dropbox"><a title="GitHub" href="%s" %s><i class="fa fa-dropbox"></i></a></li>',
			),
			'email' => array(
				'label'	  => __( 'Email URI', 'redwaves-lite' ),
				'pattern' => '<li class="social-email"><a title="Email" href="%s" %s><i class="fa fa-envelope"></i></a></li>',
			),
		);

		$widget_ops = array(
			'classname'	 => 'redwaves_social_icons',
			'description' => __( 'Show social profile icons.', 'redwaves-lite' ),
		);
		$control_ops = array(
			'id_base' => 'social-icons',
			#'width'   => 505,
			#'height'  => 350,
		);

		parent::__construct ( 'social-icons', __( 'RedWaves: Social Icons', 'redwaves-lite' ), $widget_ops, $control_ops );

	}

	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'redwaves-lite' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

		<p><label><input id="<?php echo $this->get_field_id( 'new_tab' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_tab' ); ?>" value="1" <?php checked( 1, $instance['new_tab'] ); ?>/> <?php esc_html_e( 'Open links in a new tab?', 'redwaves-lite' ); ?></label></p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<input type="text" id="%s" class="widefat" name="%s" value="%s" /></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );

		}

	}

	function update( $newinstance, $oldinstance ) {

		foreach ( $newinstance as $key => $value ) {

			/** Sanitize Profile URIs */
			if ( array_key_exists( $key, (array) $this->profiles ) ) {
				$newinstance[$key] = esc_url( $newinstance[$key] );
			}

		}

		return $newinstance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		echo $before_widget;

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			$output = '';

			$new_tab = $instance['new_tab'] ? 'target="_blank"' : '';

			foreach ( (array) $this->profiles as $profile => $data ) {
				if ( ! empty( $instance[$profile] ) )
					$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_tab );
			}

			if ( $output )
				printf( '<div class="widget-container social-icons"><ul class="%s">%s</ul></div>', '',$output );

		echo $after_widget;
	}
	
}
add_action( 'widgets_init', create_function( '', 'register_widget("Social_Profile_Icons_Widget");' ) );