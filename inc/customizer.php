<?php
	/**
	* RedWaves Lite Theme Customizer
	*
	* @package redwaves-lite
	*/
	
/*-----------------------------------------------------------------------------------*/
/*  Registering the Customizer Settings
/*-----------------------------------------------------------------------------------*/
	
function redwaves_options_theme_customizer_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// General Settings
	$wp_customize->add_section( 
		'general_settings', array(
		'title' => __( 'General Settings', 'redwaves-lite' ),
		'priority' => 10,
	) );

		//favicon upload	
		$wp_customize->add_setting( 
			'favicon_image' , array(
				'default'     => get_template_directory_uri() .'/images/favicon.gif',
				'sanitize_callback' => 'esc_url_raw',
				));
		 
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'favicon_image',
				array(
					'label' =>  __( 'Custom Favicon', 'redwaves-lite' ),
					'section' => 'general_settings',
					'settings' => 'favicon_image',
				)
			)
		);			
		
		//Add "Switcher" support to the theme customizer
		class Customizer_Switcher_Control extends WP_Customize_Control {
			public $type = 'switcher';
		 
			public function render_content() {
				?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<input class="ios-switch green bigswitch" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> /><div class="ios-switch-div" ><div></div></div>
					</label>				
				<?php
			}
		}

		// Stick the Main navigation menu
		$wp_customize->add_setting( 
			'sticky_menu' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,				
				'sticky_menu',
				array(
					'label' =>  __( 'Sticky Navigation menu', 'redwaves-lite' ),
					'section' => 'general_settings',
					'type' => 'checkbox',
				)
			)
		);				

		// Mobile Menu Side
		$wp_customize->add_setting(
			'mobile_menu_side',
			array(
				'default' => 'left',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);
		
		$wp_customize->add_control(
			'mobile_menu_side', array(
				'type' => 'radio',
				'label' => __( 'Mobile Menu Side', 'redwaves-lite' ),
				'section' => 'general_settings',
				'choices' => array(
					'left' => __( 'Left', 'redwaves-lite' ),
					'right' => __( 'Right', 'redwaves-lite' ),
				),
			)
		);
		
		// Mobile Menu Style
		$wp_customize->add_setting(
			'mobile_menu_style',
			array(
				'default' => 'overlay',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);
		
		$wp_customize->add_control(
			'mobile_menu_style', array(
				'type' => 'radio',
				'label' => __( 'Mobile Menu Style', 'redwaves-lite' ),
				'section' => 'general_settings',
				'choices' => array(
					'overlay' => __( 'Overlay', 'redwaves-lite' ),
					'push' => __( 'Push', 'redwaves-lite' ),
				),
			)
		);

		//Add textarea support to the theme customizer
		class Customizer_Textarea_Control extends WP_Customize_Control {
			public $type = 'textarea';
		 
			public function render_content() {
				?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
					</label>
				<?php
			}
		}

		// Copyright text
		$wp_customize->add_setting( 
			'footer_left', array(
				'default' => 'Proudly powered by <a href="http://wordpress.org/" rel="generator">WordPress</a>',
				'sanitize_callback' => 'redwaves_sanitize_text',
			)
		);
		
		$wp_customize->add_control(
			new Customizer_Textarea_Control(
				$wp_customize,			
				'footer_left',
				array(
					'label' => __( 'Copyright Text', 'redwaves-lite' ),
					'section' => 'general_settings',
					'settings' => 'footer_left',
				)
			)
		);		

	// Site Title & Tagline
		
		//logo upload	
		$wp_customize->add_setting( 
			'logo_image' , array(
				'default'     => get_template_directory_uri() .'/images/logo.png',
				'sanitize_callback' => 'esc_url_raw',
				));
		 
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'logo_image',
				array(
					'label' => __( 'Logo Image', 'redwaves-lite' ),
					'section' => 'title_tagline',
					'settings' => 'logo_image',
				)
			)
		);

	// Archives Settings
	$wp_customize->add_section( 
		'archives_settings', array(
			'title' => __( 'Archives Settings', 'redwaves-lite' ),
			'priority' => 20
	) );		

		// Add Radio-Image control support to the theme customizer
		class Customizer_Radio_Image_Control extends WP_Customize_Control {
			public $type = 'radio-image';
			
			public function enqueue() {
				wp_enqueue_script( 'jquery-ui-button' );
			}
			
			// Markup for the field's title
			public function title() {
				echo '<span class="customize-control-title">';
					$this->label();
					$this->description();
				echo '</span>';
			}

			// The markup for the label.
			public function label() {
				// The label has already been sanitized in the Fields class, no need to re-sanitize it.
				echo $this->label;
			}

			// Markup for the field's description
			public function description() {
				if ( ! empty( $this->description ) ) {
					// The description has already been sanitized in the Fields class, no need to re-sanitize it.
					echo '<span class="description customize-control-description">' . $this->description . '</span>';
				}
			}
			
			public function render_content() {
				if ( empty( $this->choices ) ) {
					return;
				}
				$name = '_customize-radio-' . $this->id;
				?>
				<?php $this->title(); ?>
				<div id="input_<?php echo $this->id; ?>" class="image">
					<?php foreach ( $this->choices as $value => $label ) : ?>
						<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
							<label for="<?php echo $this->id . $value; ?>">
								<img src="<?php echo esc_html( $label ); ?>">
							</label>
						</input>
					<?php endforeach; ?>
				</div>
				<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo $this->id; ?>"]' ).buttonset(); });</script>
				<?php
			}
		}
		
		//Display
		$wp_customize->add_setting(
			'display',
			array(
				'default' => 'excerpt_smallfeatured',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);

		$wp_customize->add_control(	
			new Customizer_Radio_Image_Control(
				$wp_customize,
				'display', array(
					'label' => __( 'Display', 'redwaves-lite' ),
					'section' => 'archives_settings',
					'choices' => array(
						'excerpt_smallfeatured' => get_template_directory_uri() .'/images/customizer/smallthumb.png',
						'excerpt_full_featured' => get_template_directory_uri() .'/images/customizer/bigthumb.png',
					),
				)
			)
		);		

		//Archives Meta
		$wp_customize->add_setting( 
			'archives_post_meta' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,			
				'archives_post_meta', array(
					'label' =>  __( 'Archives Meta', 'redwaves-lite' ),
					'section' => 'archives_settings',
				)
			)
		);

		//Add input[type=number] support to the theme customizer
		class Customizer_Number_Control extends WP_Customize_Control {
			public $type = 'number';
			
			public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<input class="number-control small" min="0" max="500" step="1" type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" />
				</label>
			<?php
			}
		}		
				
		//Excerpt Length
		$wp_customize->add_setting( 
			'excerpt_length', array( 
				'default' => '40',
				'sanitize_callback' => 'redwaves_sanitize_integer',
			) 
		);
				
		$wp_customize->add_control(
			new Customizer_Number_Control(
				$wp_customize,
				'excerpt_length', array(
					'label'    => __( 'Excerpt Length', 'redwaves-lite' ),
					'section'  => 'archives_settings',
					'settings' => 'excerpt_length',
				) 
			)
		);		
		
		
	// Article Settings
	$wp_customize->add_section( 
		'article_settings', array(
			'title' => __( 'Article Settings', 'redwaves-lite' ),
			'priority' => 30
	) );	

		//Post Meta
		$wp_customize->add_setting( 
			'post_meta' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,	
				'post_meta', array(
					'label' =>  __( 'Post Meta', 'redwaves-lite' ),
					'section' => 'article_settings',
				)
			)
		);
		
		//Related Posts
		$wp_customize->add_setting( 
			'related_posts' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,	
				'related_posts', array(
					'label' =>  __( 'Related Posts', 'redwaves-lite' ),
					'section' => 'article_settings',
				)
			)
		);
		
		//Related Posts Number
		$wp_customize->add_setting( 
			'related_posts_number', array( 
				'default' => '4',
				'sanitize_callback' => 'redwaves_sanitize_integer',
		) );
				
		$wp_customize->add_control( 
			'related_posts_number', array(
				'label'    => __( 'Related Posts Number', 'redwaves-lite' ),
				'section'  => 'article_settings',
				'settings' => 'related_posts_number',
				'type'     => 'number'
		) );		
		
		//Related Posts Query type
		$wp_customize->add_setting(
			'related_posts_query',
			array(
				'default' => 'tags',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);
		
		$wp_customize->add_control(
			'related_posts_query', array(
				'type' => 'radio',
				'label' => __( 'Related Posts Query', 'redwaves-lite' ),
				'section' => 'article_settings',
				'choices' => array(
					'tags' => __( 'Tags', 'redwaves-lite' ),
					'categories' => __( 'Categories', 'redwaves-lite' ),
				),
			)
		);

		//Related Posts Excerpt Length
		$wp_customize->add_setting( 
			'related_posts_excerpt', array( 
				'default' => '12',
				'sanitize_callback' => 'redwaves_sanitize_integer',
			) 
		);
				
		$wp_customize->add_control(
			new Customizer_Number_Control(
				$wp_customize,
				'related_posts_excerpt', array(
					'label'    => __( 'Related Posts Excerpt Length', 'redwaves-lite' ),
					'section'  => 'article_settings',
					'settings' => 'related_posts_excerpt',
				) 
			)
		);
		
		//Next/Prev Article
		$wp_customize->add_setting( 
			'next_prev_post' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,			
				'next_prev_post', array(
					'label' =>  __( 'Next/Prev Article', 'redwaves-lite' ),
					'section' => 'article_settings',
				)
			)
		);		
		
		//Post Author Box
		$wp_customize->add_setting( 
			'author_box' , array(
				'default'     => 1,
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,	
				'author_box', array(
					'label' =>  __( 'Post Author Box', 'redwaves-lite' ),
					'section' => 'article_settings',
				)
			)
		);			
	
	
	// Design & Layout
	$wp_customize->add_section( 
		'design_layout', array(
			'title' => __( 'Design & Layout', 'redwaves-lite' ),
			'priority' => 40
	) );	
		
		// Sidebar Settings
		$wp_customize->add_setting(
			'sidebar_settings',
			array(
				'default' => 'right_sidebar',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);
		
		$wp_customize->add_control(
			new Customizer_Radio_Image_Control(
				$wp_customize,	
				'sidebar_settings', array(
					'label' => __( 'Sidebar Settings', 'redwaves-lite' ),
					'section' => 'design_layout',
					'choices' => array(
							'right_sidebar' => get_template_directory_uri() .'/images/customizer/right.jpg',
							'left_sidebar' => get_template_directory_uri() .'/images/customizer/left.jpg',
							'no_sidebar' => get_template_directory_uri() .'/images/customizer/nosidebar.jpg',
					),
				)
			)
		);			

		// Theme color
		$wp_customize->add_setting(
			'theme_color',
			array(
				'default' => '#c60000',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_color',
				array(
					'label' => __( 'Theme color', 'redwaves-lite' ),
					'section' => 'design_layout',
					'settings' => 'theme_color',
				)
			)
		);

		// Enable Shadows
		$wp_customize->add_setting( 
			'toggle_shadows' , array(
				'default'     => '1',
				'sanitize_callback' => 'redwaves_sanitize_checkbox',
				)
		);
		
		$wp_customize->add_control(
			new Customizer_Switcher_Control(
				$wp_customize,				
				'toggle_shadows',
				array(
					'label' =>  __( 'Enable Shadows', 'redwaves-lite' ),
					'section' => 'design_layout',
				)
			)
		);
		
		// Background Settings
		$wp_customize->add_setting(
			'background_settings',
			array(
				'default' => 'color',
				'sanitize_callback' => 'redwaves_sanitize_choices',
			)
		);
		
		$wp_customize->add_control(
			'background_settings', array(
				'type' => 'radio',
				'label' => __( 'Background settings', 'redwaves-lite' ),
				'section' => 'design_layout',
				'choices' => array(
					'color' => __( 'Color', 'redwaves-lite' ),
					'pattern' => __( 'Pattern', 'redwaves-lite' ),					
					'custom_image' => __( 'Custom image', 'redwaves-lite' ),
				),
			)
		);		
		
		// Background color
		$wp_customize->add_setting(
			'bg_color',
			array(
				'default' => '#f7f7f7',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'bg_color',
				array(
					'label' => __( 'Background color', 'redwaves-lite' ),
					'section' => 'design_layout',
					'settings' => 'bg_color',
				)
			)
		);		

		// Background pattern
		$wp_customize->add_setting(
			'background_pattern',
			array(
				'default' => get_template_directory_uri() .'/images/patterns/21.gif',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		
		$wp_customize->add_control(
			new Customizer_Radio_Image_Control(
				$wp_customize,	
				'background_pattern', array(
					'label' => __( 'Background pattern', 'redwaves-lite' ),
					'section' => 'design_layout',
					'choices' => array(
							get_template_directory_uri() .'/images/patterns/21.gif' => get_template_directory_uri() .'/images/patterns/21.gif',
							get_template_directory_uri() .'/images/patterns/22.gif' => get_template_directory_uri() .'/images/patterns/22.gif',
							get_template_directory_uri() .'/images/patterns/23.gif' => get_template_directory_uri() .'/images/patterns/23.gif',
							get_template_directory_uri() .'/images/patterns/24.gif' => get_template_directory_uri() .'/images/patterns/24.gif',
							get_template_directory_uri() .'/images/patterns/25.gif' => get_template_directory_uri() .'/images/patterns/25.gif',
							get_template_directory_uri() .'/images/patterns/26.gif' => get_template_directory_uri() .'/images/patterns/26.gif',
							get_template_directory_uri() .'/images/patterns/27.gif' => get_template_directory_uri() .'/images/patterns/27.gif',
							get_template_directory_uri() .'/images/patterns/28.gif' => get_template_directory_uri() .'/images/patterns/28.gif',
							get_template_directory_uri() .'/images/patterns/29.gif' => get_template_directory_uri() .'/images/patterns/29.gif',
							get_template_directory_uri() .'/images/patterns/30.gif' => get_template_directory_uri() .'/images/patterns/30.gif',
							get_template_directory_uri() .'/images/patterns/31.gif' => get_template_directory_uri() .'/images/patterns/31.gif',
							get_template_directory_uri() .'/images/patterns/32.gif' => get_template_directory_uri() .'/images/patterns/32.gif',
							get_template_directory_uri() .'/images/patterns/33.gif' => get_template_directory_uri() .'/images/patterns/33.gif',
							get_template_directory_uri() .'/images/patterns/34.gif' => get_template_directory_uri() .'/images/patterns/34.gif',
							get_template_directory_uri() .'/images/patterns/35.gif' => get_template_directory_uri() .'/images/patterns/35.gif',
							get_template_directory_uri() .'/images/patterns/36.gif' => get_template_directory_uri() .'/images/patterns/36.gif',
							get_template_directory_uri() .'/images/patterns/37.gif' => get_template_directory_uri() .'/images/patterns/37.gif',
							get_template_directory_uri() .'/images/patterns/38.gif' => get_template_directory_uri() .'/images/patterns/38.gif',
							get_template_directory_uri() .'/images/patterns/39.gif' => get_template_directory_uri() .'/images/patterns/39.gif',
							get_template_directory_uri() .'/images/patterns/40.gif' => get_template_directory_uri() .'/images/patterns/40.gif',
							
							get_template_directory_uri() .'/images/patterns/1.jpg' => get_template_directory_uri() .'/images/patterns/1.jpg',
							get_template_directory_uri() .'/images/patterns/2.jpg' => get_template_directory_uri() .'/images/patterns/2.jpg',
							get_template_directory_uri() .'/images/patterns/3.jpg' => get_template_directory_uri() .'/images/patterns/3.jpg',
							get_template_directory_uri() .'/images/patterns/4.jpg' => get_template_directory_uri() .'/images/patterns/4.jpg',
							get_template_directory_uri() .'/images/patterns/5.jpg' => get_template_directory_uri() .'/images/patterns/5.jpg',			
							get_template_directory_uri() .'/images/patterns/6.jpg' => get_template_directory_uri() .'/images/patterns/6.jpg',
							get_template_directory_uri() .'/images/patterns/7.jpg' => get_template_directory_uri() .'/images/patterns/7.jpg',
							get_template_directory_uri() .'/images/patterns/8.jpg' => get_template_directory_uri() .'/images/patterns/8.jpg',
							get_template_directory_uri() .'/images/patterns/9.jpg' => get_template_directory_uri() .'/images/patterns/9.jpg',
							get_template_directory_uri() .'/images/patterns/10.jpg' => get_template_directory_uri() .'/images/patterns/10.jpg',
							get_template_directory_uri() .'/images/patterns/11.jpg' => get_template_directory_uri() .'/images/patterns/11.jpg',
							get_template_directory_uri() .'/images/patterns/12.jpg' => get_template_directory_uri() .'/images/patterns/12.jpg',
							get_template_directory_uri() .'/images/patterns/13.jpg' => get_template_directory_uri() .'/images/patterns/13.jpg',
							get_template_directory_uri() .'/images/patterns/14.jpg' => get_template_directory_uri() .'/images/patterns/14.jpg',
							get_template_directory_uri() .'/images/patterns/15.jpg' => get_template_directory_uri() .'/images/patterns/15.jpg',			
							get_template_directory_uri() .'/images/patterns/16.jpg' => get_template_directory_uri() .'/images/patterns/16.jpg',
							get_template_directory_uri() .'/images/patterns/17.jpg' => get_template_directory_uri() .'/images/patterns/17.jpg',
							get_template_directory_uri() .'/images/patterns/18.jpg' => get_template_directory_uri() .'/images/patterns/18.jpg',
							get_template_directory_uri() .'/images/patterns/19.jpg' => get_template_directory_uri() .'/images/patterns/19.jpg',
							get_template_directory_uri() .'/images/patterns/20.jpg' => get_template_directory_uri() .'/images/patterns/20.jpg',				
					),
				)
			)
		);
		
		//Background image uploader	
		$wp_customize->add_setting( 
			'background_image' , array(
				'default'     => '',
				'sanitize_callback' => 'esc_url_raw',
				));
		 
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'background_image',
				array(
					'label' => __( 'Custom background image', 'redwaves-lite' ),
					'section' => 'design_layout',
					'settings' => 'background_image',
				)
			)
		);		

		//Background image repeat	
		$wp_customize->add_setting( 
			'background_image_repeat' , array(
				'default'     => 'repeat',
				'sanitize_callback' => 'redwaves_sanitize_choices',
				));

		$wp_customize->add_control(
			'background_image_repeat', array(
				'type' => 'select',
				'label' => __( 'Repeat', 'redwaves-lite' ),
				'section' => 'design_layout',
				'choices' => array(
					'repeat' => __( 'Repeat', 'redwaves-lite' ),
					'repeat-x' => __( 'Repeat-x', 'redwaves-lite' ),
					'repeat-y' => __( 'Repeat-y', 'redwaves-lite' ),
					'no-repeat' => __( 'No-repeat', 'redwaves-lite' ),					
				),
			)
		);

		//Background image attachment	
		$wp_customize->add_setting( 
			'background_image_attachment' , array(
				'default'     => 'scroll',
				'sanitize_callback' => 'redwaves_sanitize_choices',
				));

		$wp_customize->add_control(
			'background_image_attachment', array(
				'type' => 'select',
				'label' => __( 'Attachment', 'redwaves-lite' ),
				'section' => 'design_layout',
				'choices' => array(
					'scroll' => __( 'Scroll', 'redwaves-lite' ),
					'fixed' => __( 'Fixed', 'redwaves-lite' ),				
				),
			)
		);

		//Background image position	
		$wp_customize->add_setting( 
			'background_image_position' , array(
				'default'     => 'left top',
				'sanitize_callback' => 'redwaves_sanitize_choices',
				));

		$wp_customize->add_control(
			'background_image_position', array(
				'type' => 'select',
				'label' => __( 'Position', 'redwaves-lite' ),
				'section' => 'design_layout',
				'choices' => array(
					'left top' => __( 'Left top', 'redwaves-lite' ),
					'left center' => __( 'Left center', 'redwaves-lite' ),
					'left bottom' => __( 'Left bottom', 'redwaves-lite' ),
					'right top' => __( 'Right top', 'redwaves-lite' ),
					'right center' => __( 'Right center', 'redwaves-lite' ),
					'right bottom' => __( 'Right bottom', 'redwaves-lite' ),
					'center top' => __( 'Center top', 'redwaves-lite' ),
					'center center' => __( 'Center center', 'redwaves-lite' ),
					'center bottom' => __( 'Center bottom', 'redwaves-lite' ),				
				),
			)
		);

		// Custom CSS
		$wp_customize->add_setting( 
			'custom_css', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr',
			)
		);
		
		$wp_customize->add_control(
			new Customizer_Textarea_Control(
				$wp_customize,
				'custom_css',
				array(
					'label' => __( 'Custom CSS', 'redwaves-lite' ),
					'section' => 'design_layout',
					'settings' => 'custom_css',
				)
			)
		);
		
}
add_action( 'customize_register', 'redwaves_options_theme_customizer_register' );

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM DATA SANITIZATION
/*-----------------------------------------------------------------------------------*/
	
// Sanitize text
function redwaves_sanitize_text( $input ) {
	return strip_tags( $input,'<a>' );
}	
	
// Sanitize checkbox
function redwaves_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

// Sanitize integer
function redwaves_sanitize_integer( $input ) {
	return absint( $input );
}

// Sanitize Choices
function redwaves_sanitize_choices( $input, $setting ) {
	global $wp_customize;
	$control = $wp_customize->get_control( $setting->id );

	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Customizer Styles & Scripts
/*-----------------------------------------------------------------------------------*/

// Style settings output.
function redwaves_add_style_settings() {
	$sidebar_settings = get_theme_mod( 'sidebar_settings' );
	if ( $sidebar_settings && $sidebar_settings == 'left_sidebar' ) {
		$layout_style = ' .content-area { float: right; margin-right: 0; margin-left: 1%;} ';
	}
	elseif ( $sidebar_settings && $sidebar_settings == 'no_sidebar' ) {
		$layout_style = ' .content-area { width: 100%;} ';
	} else {  $layout_style = '';  }
	$theme_color = get_theme_mod( 'theme_color', '#c60000' );
	$toggle_shadows = get_theme_mod( 'toggle_shadows', '1' );
	$custom_css = get_theme_mod( 'custom_css' );
	$background_settings = get_theme_mod( 'background_settings', 'color' );
	if ( $background_settings && $background_settings == 'color') {
		$bg_color = get_theme_mod( 'bg_color', '#f7f7f7' );
		$background = ' body { background: ' . $bg_color . ';}';
	} 
	elseif ( $background_settings && $background_settings == 'pattern') {
		$background_pattern = get_theme_mod( 'background_pattern', get_template_directory_uri() .'/images/patterns/21.gif' );
		$background = ' body { background: url(' . $background_pattern . ') repeat left bottom;}';
	} else { 
		$background_image = get_theme_mod( 'background_image' );
		$background_image_repeat = get_theme_mod( 'background_image_repeat' );
		$background_image_attachment = get_theme_mod( 'background_image_attachment' );
		$background_image_position = get_theme_mod( 'background_image_position' );
		if ( $background_image ) {
			$background = ' body { background: url(' . $background_image . ') '. $background_image_repeat .' '. $background_image_attachment .' '. $background_image_position .';}';
		}
	}
	?>
	<style type="text/css">
		<?php echo $layout_style ?> button, .pagination a, .nav-links a, .readmore, .thecategory a:hover, .pagination a, #wp-calendar td a, #wp-calendar caption, #wp-calendar #prev a:before, #wp-calendar #next a:before, .tagcloud a:hover, #wp-calendar thead th.today, #wp-calendar td a:hover, #wp-calendar #today { background: <?php echo $theme_color ?>; } .secondary-navigation, .secondary-navigation li:hover ul a, .secondary-navigation ul ul li, .secondary-navigation ul ul li:hover, .secondary-navigation ul ul ul li:hover, .secondary-navigation ul ul ul li, #mobile-menu-wrapper, a.sideviewtoggle, .sb-slidebar { background: <?php echo $theme_color ?>; }  .thecategory ul li a:hover { background: <?php echo $theme_color ?>; !important} a, .breadcrumb a, .entry-content a {color: <?php echo $theme_color ?>;} .title a:hover, .post-data .post-title a:hover, .post-title a:hover, .post-info a:hover,.textwidget a, .reply a, .comm, .fn a, .comment-reply-link, .entry-content .singleleft a:hover, .breadcrumb a:hover, .widget-post-title a:hover { color: <?php echo $theme_color ?>; } .main-container .widget h3:after, .tagcloud a:hover { border-color: <?php echo $theme_color ?>; } <?php echo $background ?> <?php if ( $toggle_shadows ) { echo 'article, .sidebar-widget, .related-posts .horizontal-container, .author-box, .error404 .content-area { -webkit-box-shadow: 0px 1px 1px #c2c4c4; -moz-box-shadow: 0px 1px 1px #c2c4c4; box-shadow: 0px 1px 1px #c2c4c4; }'; } ?> <?php if ( $custom_css ) { echo $custom_css; } ?>
	</style>
	<?php
}
add_action( 'wp_head', 'redwaves_add_style_settings' );

//Loading Customizer Styles
function redwaves_customizer_css() {
	wp_enqueue_style( 'customizer_css', get_template_directory_uri() . '/css/customizer.css', array() );
}
add_action( 'admin_enqueue_scripts', 'redwaves_customizer_css' );

// Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
function redwaves_options_theme_customizer_preview_js() {
	wp_enqueue_script( 'options_theme_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'redwaves_options_theme_customizer_preview_js' );