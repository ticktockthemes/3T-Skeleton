<?php
/**
 * 3T Skeleton Theme Customizer.
 *
 * @package 3T_Skeleton
 */

/**
 * Define class to hook into the built-in theme customizer of WordPress.
 */
class TickTock_Customize {
	/**
	 * Variable that point to the Theme Customizer object.
	 *
	 * @var WP_Customize_Manager
	 */
	public $customize;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		// Register theme options.
		add_action( 'customize_register', array( &$this, 'register' ) );

		// Enqueue assets for customize panel.
		add_action( 'customize_controls_enqueue_scripts', array( &$this, 'enqueue_assets' ) );

		// Register script file for theme preview.
		add_action( 'customize_preview_init', array( &$this, 'preview_js' ) );
	}

	/**
	 * Register theme options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return void
	 */
	public function register( $wp_customize ) {
		// Store Theme Customizer object locally.
		$this->customize =& $wp_customize;

		// Include custom customize control classes
		include_once dirname( __FILE__ ) . '/customize-controls/button.php';
		include_once dirname( __FILE__ ) . '/customize-controls/color-picker.php';
		include_once dirname( __FILE__ ) . '/customize-controls/dropdown-select.php';
		include_once dirname( __FILE__ ) . '/customize-controls/radio-button.php';
		include_once dirname( __FILE__ ) . '/customize-controls/toggle.php';
		include_once dirname( __FILE__ ) . '/customize-controls/typography.php';

		// Register custom control types that can be rendered via JS and created dynamically.
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Button' );
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Color_Picker' );
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Dropdown_Select' );
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Radio_Button' );
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Toggle' );
		$wp_customize->register_control_type( 'TickTock_Customize_Control_Typography' );

		// Register option panels.
		$this->add_general_panel();
		$this->add_branding_panel();
		$this->add_typography_panel();
		$this->add_colors_panel();
		$this->add_header_panel();
		$this->add_footer_panel();
		$this->add_blog_page_panel();
		$this->add_single_post_panel();
		$this->add_map_panel();
		$this->add_menu_panel();
		$this->add_static_front_page_panel();
		$this->add_backup_restore_panel();
		$this->add_advances_panel();

		// Add postMessage support for site title and description for the Theme Customizer.
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	}

	/**
	 * Enqueue assets for customize panel.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		// Enqueue Semantic UI.
		wp_enqueue_style( 'semantic-ui', get_template_directory_uri() . '/3rd-party/semantic-ui/semantic.min.css', array(), '2.1.7' );
		wp_enqueue_script( 'semantic-ui', get_template_directory_uri() . '/3rd-party/semantic-ui/semantic.min.js', array(), '2.1.7', true );

		// Enqueue other assets for customize panel.
		wp_enqueue_style( 'ticktock-customize', get_template_directory_uri() . '/css/customize.css', array(), '1.0.0' );
		wp_enqueue_script( 'ticktock-customize', get_template_directory_uri() . '/js/customize.js', array(), '1.0.0', true );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	public function preview_js() {
		wp_enqueue_script( 'ticktock_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
	}

	/**
	 * Add the General option panel.
	 *
	 * @return void
	 */
	protected function add_general_panel() {
		$this->customize->add_section( 'general', array(
			'priority'    => 1,
			'title'       => __( 'General', 'ticktock' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' ),
		) );

		// Add Theme Layout option to the General option panel.
		$this->customize->add_setting( 'theme_layout', array(
			'default'           => 'full',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Radio_Button(
			$this->customize, 'theme_layout', array(
				'label'   => __( 'Theme Layout', 'ticktock' ),
				'section' => 'general',
				'choices' => array(
					'full'  => __( 'Full', 'ticktock' ),
					'boxed' => __( 'Boxed', 'ticktock' ),
				),
			)
		) );

		// Add Background Image option to the General option panel.
		$this->customize->add_setting( 'boxed_background_image', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_url',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new WP_Customize_Image_Control(
			$this->customize, 'boxed_background_image', array(
				'label'   => __( 'Background Image', 'ticktock' ),
				'section' => 'general',
			)
		) );

		// Add Background Repeat option to the General option panel.
		$this->customize->add_setting( 'boxed_background_repeat', array(
			'default'           => 'repeat',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Dropdown_Select(
			$this->customize, 'boxed_background_repeat', array(
				'label'   => __( 'Background Repeat', 'ticktock' ),
				'section' => 'general',
				'choices' => array(
					'repeat'    => __( 'Both vertically and horizontally', 'ticktock' ),
					'repeat-x'  => __( 'Only horizontally', 'ticktock' ),
					'repeat-y'  => __( 'Only vertically', 'ticktock' ),
					'no-repeat' => __( 'No repeat', 'ticktock' ),
				),
			)
		) );

		// Add Background Position option to the General option panel.
		$this->customize->add_setting( 'boxed_background_position', array(
			'default'           => 'left top',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Dropdown_Select(
			$this->customize, 'boxed_background_position', array(
				'label'   => __( 'Background Position', 'ticktock' ),
				'section' => 'general',
				'choices' => array(
					'left top'      => __( 'Left top', 'ticktock' ),
					'left center'   => __( 'Left center', 'ticktock' ),
					'left bottom'   => __( 'Left bottom', 'ticktock' ),
					'right top'     => __( 'Right top', 'ticktock' ),
					'right center'  => __( 'Right center', 'ticktock' ),
					'right bottom'  => __( 'Right bottom', 'ticktock' ),
					'center top'    => __( 'Center top', 'ticktock' ),
					'center center' => __( 'Center center', 'ticktock' ),
					'center bottom' => __( 'Center bottom', 'ticktock' ),
				),
			)
		) );

		// Add Background Attachment option to the General option panel.
		$this->customize->add_setting( 'boxed_background_attachment', array(
			'default'           => 'scroll',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Dropdown_Select(
			$this->customize, 'boxed_background_attachment', array(
				'label'   => __( 'Background Attachment', 'ticktock' ),
				'section' => 'general',
				'choices' => array(
					'scroll' => __( 'Scrolls along with the element', 'ticktock' ),
					'fixed'  => __( 'Fixed with regard to the viewport', 'ticktock' ),
					'local'  => __( 'Scrolls along with the element&#39;s contents', 'ticktock' ),
				),
			)
		) );

		// Add Background Size option to the General option panel.
		$this->customize->add_setting( 'boxed_background_size', array(
			'default'           => 'auto',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Dropdown_Select(
			$this->customize, 'boxed_background_size', array(
				'label'   => __( 'Background Size', 'ticktock' ),
				'section' => 'general',
				'choices' => array(
					'auto'    => __( 'The background image contains its width and height', 'ticktock' ),
					'cover'   => __( 'The background area is completely covered by the background image', 'ticktock' ),
					'contain' => __( 'Fit the background image inside the content area', 'ticktock' ),
				),
			)
		) );

		// Add Page Transition Loading option to the General option panel.
		$this->customize->add_setting( 'page_transition_loading', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'page_transition_loading', array(
				'label'   => __( 'Page Transition Loading', 'ticktock' ),
				'section' => 'general',
			)
		) );

		// Add Go-to-top Link option to the General option panel.
		$this->customize->add_setting( 'go_to_top_link', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'go_to_top_link', array(
				'label'   => __( 'Go-to-top Link', 'ticktock' ),
				'section' => 'general',
			)
		) );

		// Add Use Unminified CSS option to the General option panel.
		$this->customize->add_setting( 'use_unminified_css', array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'use_unminified_css', array(
				'label'   => __( 'Use Unminified CSS', 'ticktock' ),
				'section' => 'general',
			)
		) );
	}

	/**
	 * Add the Branding option panel.
	 *
	 * @return void
	 */
	protected function add_branding_panel() {
		$this->customize->add_section( 'branding', array(
			'priority'    => 2,
			'title'       => __( 'Branding', 'ticktock' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' ),
		) );

		// Add Logo Type option to the Branding option panel.
		$this->customize->add_setting( 'logo_type', array(
			'default'           => 'text',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Radio_Button(
			$this->customize, 'logo_type', array(
				'label'   => __( 'Logo Type', 'ticktock' ),
				'section' => 'branding',
				'choices' => array(
					'text'  => __( 'Text', 'ticktock' ),
					'image' => __( 'Image', 'ticktock' ),
				),
			)
		) );

		// Add Logo Text option to the Branding option panel.
		$this->customize->add_setting( 'logo_text', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( 'logo_text', array(
			'label'   => __( 'Logo Text', 'ticktock' ),
			'section' => 'branding',
			'type'    => 'textarea',
		) );

		// Add Logo Image option to the General option panel.
		$this->customize->add_setting( 'logo_image', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_url',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new WP_Customize_Image_Control(
			$this->customize, 'logo_image', array(
				'label'   => __( 'Logo Image', 'ticktock' ),
				'section' => 'branding',
			)
		) );

		// Add Logo Image For Retina option to the General option panel.
		$this->customize->add_setting( 'logo_image_for_retina', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_url',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new WP_Customize_Image_Control(
			$this->customize, 'logo_image_for_retina', array(
				'label'   => __( 'Logo Image For Retina', 'ticktock' ),
				'section' => 'branding',
			)
		) );

		// Add Site Icon option to the Branding option panel.
		$this->customize->add_setting( 'site_icon', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_url',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new WP_Customize_Site_Icon_Control(
			$this->customize, 'site_icon', array(
				'label'   => __( 'Site Icon', 'ticktock' ),
				'section' => 'branding',
			)
		) );
	}

	/**
	 * Add the Typography option panel.
	 *
	 * @return void
	 */
	protected function add_typography_panel() {
		$this->customize->add_section( 'typography', array(
			'priority'    => 3,
			'title'       => __( 'Typography', 'ticktock' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' ),
		) );

		// Add Heading Font option to the Typography option panel.
		$this->customize->add_setting( 'heading_font', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Typography(
			$this->customize, 'heading_font', array(
				'label'   => __( 'Heading Font', 'ticktock' ),
				'section' => 'typography',
			)
		) );

		// Add Body Font option to the Typography option panel.
		$this->customize->add_setting( 'body_font', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Typography(
			$this->customize, 'body_font', array(
				'label'   => __( 'Body Font', 'ticktock' ),
				'section' => 'typography',
			)
		) );
	}

	/**
	 * Add the Colors option panel.
	 *
	 * @return void
	 */
	protected function add_colors_panel() {
		// Update the priority of the built-in Colors section.
		$this->customize->get_section( 'colors' )->priority = 4;
		$this->customize->get_section( 'colors' )->title = __( 'Colors', 'ticktock' );
		$this->customize->get_section( 'colors' )->description = __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' );

		// Add Color Scheme option to the Colors option panel.
		$this->customize->add_setting( 'color_scheme', array(
			'default'           => 'light',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Radio_Button(
			$this->customize, 'color_scheme', array(
				'label'   => __( 'Color Scheme', 'ticktock' ),
				'section' => 'colors',
				'choices' => array(
					'light' => __( 'Light', 'ticktock' ),
					'dark'  => __( 'Dark', 'ticktock' ),
				),
			)
		) );

		// Add Accent Color option to the Colors option panel.
		$this->customize->add_setting( 'accent_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Color_Picker(
			$this->customize, 'accent_color', array(
				'label'   => __( 'Accent Color', 'ticktock' ),
				'section' => 'colors',
			)
		) );

		// Add the button to reset colors back to the default settings.
		$this->customize->add_setting( 'reset_colors', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'refresh',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Button(
			$this->customize, 'reset_colors', array(
				'label'     => __( 'Reset to default theme&#39;s color', 'ticktock' ),
				'section'   => 'colors',
				'onclick'   => 'console.log(\'reset_colors button clicked\');',
				'variation' => 'yellow',
			)
		) );
	}

	/**
	 * Add the Header option panel.
	 *
	 * @return void
	 */
	protected function add_header_panel() {
		$this->customize->add_section( 'header', array(
			'priority'    => 5,
			'title'       => __( 'Header', 'ticktock' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' ),
		) );

		// Add Sticky Header option to the Header option panel.
		$this->customize->add_setting( 'sticky_header', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'sticky_header', array(
				'label'   => __( 'Sticky Header', 'ticktock' ),
				'section' => 'header',
			)
		) );

		// Add Show Search Box option to the Header option panel.
		$this->customize->add_setting( 'show_search_box', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'show_search_box', array(
				'label'   => __( 'Show Search Box', 'ticktock' ),
				'section' => 'header',
			)
		) );
	}

	/**
	 * Add the Footer option panel.
	 *
	 * @return void
	 */
	protected function add_footer_panel() {
		$this->customize->add_section( 'footer', array(
			'priority'    => 6,
			'title'       => __( 'Footer', 'ticktock' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'ticktock' ),
		) );

		// Add Footer Widget Area option to the Footer option panel.
		$this->customize->add_setting( 'footer_widget_area', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'footer_widget_area', array(
				'label'   => __( 'Footer Widget Area', 'ticktock' ),
				'section' => 'footer',
			)
		) );

		// Add the button to manage widgets at the Footer Widget Area.
		$this->customize->add_setting( 'manage_footer_widgets', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'refresh',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Button(
			$this->customize, 'manage_footer_widgets', array(
				'label'     => __( 'Manage footer widgets <i class="long arrow right icon"></i>', 'ticktock' ),
				'section'   => 'footer',
				'onclick'   => 'jQuery.ticktock_manage_footer_widgets();',
			)
		) );

		// Add Show Copyright option to the Footer option panel.
		$this->customize->add_setting( 'show_copyright', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'show_copyright', array(
				'label'   => __( 'Show Copyright', 'ticktock' ),
				'section' => 'footer',
			)
		) );

		// Add Custom Copyright Text option to the Branding option panel.
		$this->customize->add_setting( 'custom_copyright_text', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( 'custom_copyright_text', array(
			'label'   => __( 'Custom Copyright Text', 'ticktock' ),
			'section' => 'footer',
			'type'    => 'textarea',
		) );

		// Add Social Links option to the Footer option panel.
		$this->customize->add_setting( 'social_links', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$this->customize->add_control( new TickTock_Customize_Control_Toggle(
			$this->customize, 'social_links', array(
				'label'   => __( 'Social Links', 'ticktock' ),
				'section' => 'footer',
			)
		) );
	}

	protected function add_blog_page_panel() {
	}

	protected function add_single_post_panel() {
	}

	protected function add_map_panel() {
	}

	protected function add_menu_panel() {
	}

	protected function add_static_front_page_panel() {
	}

	protected function add_backup_restore_panel() {
	}

	protected function add_advances_panel() {
	}
}

// Hook into the built-in theme customizer of WordPress.
$GLOBALS['ticktock_customize'] = new TickTock_Customize;
