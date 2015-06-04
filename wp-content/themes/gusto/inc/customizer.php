<?php
/**
 * Gusto Theme Customizer
 *
 * @package Gusto
 */

/**
 * Register custom sections, settings and controls for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gusto_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Load customize control classes
	include_once dirname( __FILE__ ) . '/customize-control/radio.php';
	include_once dirname( __FILE__ ) . '/customize-control/reset.php';

	// Register General section
	$wp_customize->add_section(
		'ttt_general', array(
			'title'       => __( 'General', 'gusto' ),
			'description' => __( 'Your general settings of the theme. Configuring layout type, logo, page transition...', 'gusto' ),
			'priority'    => 0,
		)
	);

	// Register Theme Layout setting and control
	$wp_customize->add_setting(
		'theme_layout', array(
			'default'           => 'full',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'theme_layout', array(
				'label'    => __( 'Theme Layout', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'theme_layout',
				'choices'  => array(
					'full'  => __( 'Full', 'gusto' ),
					'boxed' => __( 'Boxed', 'gusto' ),
				),
			)
		)
	);

	// Register background image settings and controls
	$wp_customize->remove_section( 'background_image' );

	$wp_customize->add_setting(
		'boxed_background_image', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'boxed_background_image', array(
				'label'    => __( 'Background Image', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_background_image',
			)
		)
	);

	$wp_customize->add_setting(
		'boxed_background_repeat', array(
			'default'           => 'repeat',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		'boxed_background_repeat', array(
			'label'    => __( 'Background Repeat' ),
			'section'  => 'ttt_general',
			'settings' => 'boxed_background_repeat',
			'type'     => 'radio',
			'choices'  => array(
				'no-repeat' => __('No Repeat'),
				'repeat'    => __('Tile'),
				'repeat-x'  => __('Tile Horizontally'),
				'repeat-y'  => __('Tile Vertically'),
			),
		)
	);

	$wp_customize->add_setting(
		'boxed_background_position', array(
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		'boxed_background_position', array(
			'label'    => __( 'Background Position' ),
			'section'  => 'ttt_general',
			'settings' => 'boxed_background_position',
			'type'     => 'radio',
			'choices'  => array(
				'left'   => __('Left'),
				'center' => __('Center'),
				'right'  => __('Right'),
			),
		)
	);

	$wp_customize->add_setting(
		'boxed_background_attachment', array(
			'default'           => 'fixed',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		'boxed_background_attachment', array(
			'label'    => __( 'Background Attachment' ),
			'section'  => 'ttt_general',
			'settings' => 'boxed_background_attachment',
			'type'     => 'radio',
			'choices'  => array(
				'scroll' => __('Scroll'),
				'fixed'  => __('Fixed'),
			),
		)
	);

	$wp_customize->add_setting(
		'boxed_background_size', array(
			'default'           => 'cover',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		'boxed_background_size', array(
			'label'    => __( 'Background Size', 'gusto' ),
			'section'  => 'ttt_general',
			'settings' => 'boxed_background_size',
			'type'     => 'radio',
			'choices'  => array(
				'full_width'  => __( 'Full Width', 'gusto' ),
				'full_height' => __( 'Full Height', 'gusto' ),
				'cover'       => __( 'Cover', 'gusto' ),
			),
		)
	);

	// Register Logo Type setting and control
	$wp_customize->add_setting(
		'logo_type', array(
			'default'           => 'text',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'logo_type', array(
				'label'    => __( 'Logo Type', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'logo_type',
				'choices'  => array(
					'text'  => __( 'Text', 'gusto' ),
					'image' => __( 'Image', 'gusto' ),
				),
			)
		)
	);

	// Register logo text setting and control
	$wp_customize->add_setting(
		'text_logo', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'text_logo', array(
			'label'       => __( 'Text Logo', 'gusto' ),
			'section'     => 'ttt_general',
			'settings'    => 'text_logo',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Enter text here', 'gusto' ),
			),
		)
	);

	// Register logo image settings and controls
	$wp_customize->add_setting(
		'image_logo', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'image_logo', array(
				'label'    => __( 'Image Logo', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'image_logo',
			)
		)
	);

	$wp_customize->add_setting(
		'image_retina_logo', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'image_retina_logo', array(
				'label'    => __( 'Retina Logo', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'image_retina_logo',
			)
		)
	);

	// Register icon settings and controls
	$wp_customize->add_setting(
		'fav_icon', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'fav_icon', array(
				'label'    => __( 'Fav Icon', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'fav_icon',
			)
		)
	);

	$wp_customize->add_setting(
		'apple_icon', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'apple_icon', array(
				'label'    => __( 'Apple Icon', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'apple_icon',
			)
		)
	);

	// Register other general settings and controls
	$wp_customize->add_setting(
		'page_transition_loading', array(
			'default'           => 'yes',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'page_transition_loading', array(
				'label'    => __( 'Page Transition Loading', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'page_transition_loading',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'go_to_top_link', array(
			'default'           => 'yes',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'go_to_top_link', array(
				'label'    => __( 'Go-to-Top Link', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'go_to_top_link',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	// Register Colors section
	$wp_customize->remove_section( 'colors' );

	$wp_customize->add_section(
		'ttt_colors', array(
			'title'       => __( 'Colors', 'gusto' ),
			'description' => __( 'Setup your theme color.', 'gusto' ),
			'priority'    => 1,
		)
	);

	// Register Theme Style setting and control
	$wp_customize->add_setting(
		'theme_style', array(
			'default'           => 'light',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'theme_style', array(
				'label'    => __( 'Theme Style', 'gusto' ),
				'section'  => 'ttt_colors',
				'settings' => 'theme_style',
				'choices'  => array(
					'light' => __( 'Light', 'gusto' ),
					'dark'  => __( 'Dark', 'gusto' ),
				),
			)
		)
	);

	// Register colors settings and controls
	$wp_customize->add_setting(
		'link_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'link_color', array(
				'label'    => __( 'Link Color', 'gusto' ),
				'section'  => 'ttt_colors',
				'settings' => 'link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'section_color_1', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'section_color_1', array(
				'label'    => __( 'Section Color 1', 'gusto' ),
				'section'  => 'ttt_colors',
				'settings' => 'section_color_1',
			)
		)
	);

	$wp_customize->add_setting(
		'section_color_2', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'section_color_2', array(
				'label'    => __( 'Section Color 2', 'gusto' ),
				'section'  => 'ttt_colors',
				'settings' => 'section_color_2',
			)
		)
	);

	$wp_customize->add_setting(
		'section_color_3', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'section_color_3', array(
				'label'    => __( 'Section Color 3', 'gusto' ),
				'section'  => 'ttt_colors',
				'settings' => 'section_color_3',
			)
		)
	);

	// Register button to reset colors to default
	$wp_customize->add_setting(
		'reset_colors', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Reset(
			$wp_customize, 'reset_colors', array(
				'label'    => __( 'Reset All Colors to Default', 'gusto' ),
				'section'  => 'ttt_colors',
				'defaults' => array(
					'link_color' => array(
						'input' => 'input.color-picker-hex',
						'value' => '',
					),
					'section_color_1' => array(
						'input' => 'input.color-picker-hex',
						'value' => '',
					),
					'section_color_2' => array(
						'input' => 'input.color-picker-hex',
						'value' => '',
					),
					'section_color_3' => array(
						'input' => 'input.color-picker-hex',
						'value' => '',
					),
				),
			)
		)
	);
}
add_action( 'customize_register', 'gusto_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function gusto_customize_preview_js() {
	wp_enqueue_script( 'gusto_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'gusto_customize_preview_js' );

/**
 * Enqueue scripts and styles.
 */
function gusto_customize_scripts() {
	// Load Bootstrap CSS framework
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap-3.3.4-dist/css/bootstrap.min.css', array(), '3.3.4' );
	wp_enqueue_style( 'bootstrap_theme', get_template_directory_uri() . '/assets/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css', array(), '3.3.4' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap-3.3.4-dist/js/bootstrap.min.js', array( 'jquery' ), '3.3.4', true );

	// Load options toggler
	wp_enqueue_script( 'gusto_options', get_template_directory_uri() . '/js/options.js', array( 'jquery' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'gusto_customize_scripts' );
