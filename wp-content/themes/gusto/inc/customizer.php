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
	include_once dirname( __FILE__ ) . '/customize-control/switch.php';
	include_once dirname( __FILE__ ) . '/customize-control/separator.php';
	include_once dirname( __FILE__ ) . '/customize-control/typography.php';
	include_once dirname( __FILE__ ) . '/customize-control/social/config.php';
	include_once dirname( __FILE__ ) . '/customize-control/social/icons.php';

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
		'separator_before_theme_layout', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_theme_layout', array(
				'section'  => 'ttt_general',
				'settings' => 'separator_before_theme_layout',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_layout', array(
			'default'           => 'full',
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
		'boxed_layout-background_image', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'boxed_layout-background_image', array(
				'label'    => __( 'Background Image', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_layout-background_image',
			)
		)
	);

	$wp_customize->add_setting(
		'boxed_layout-background_repeat', array(
			'default'           => 'repeat',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'boxed_layout-background_repeat', array(
				'label'    => __( 'Background Repeat' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_layout-background_repeat',
				'style'    => 'radio-group',
				'choices'  => array(
					'no-repeat' => __('No Repeat'),
					'repeat'    => __('Tile'),
					'repeat-x'  => __('Tile Horizontally'),
					'repeat-y'  => __('Tile Vertically'),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'boxed_layout-background_position', array(
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'boxed_layout-background_position', array(
				'label'    => __( 'Background Position' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_layout-background_position',
				'style'    => 'radio-group',
				'choices'  => array(
					'left'   => __('Left'),
					'center' => __('Center'),
					'right'  => __('Right'),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'boxed_layout-background_attachment', array(
			'default'           => 'fixed',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'boxed_layout-background_attachment', array(
				'label'    => __( 'Background Attachment' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_layout-background_attachment',
				'style'    => 'radio-group',
				'choices'  => array(
					'scroll' => __('Scroll'),
					'fixed'  => __('Fixed'),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'boxed_layout-background_size', array(
			'default'           => 'cover',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'boxed_layout-background_size', array(
				'label'    => __( 'Background Size', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'boxed_layout-background_size',
				'style'    => 'radio-group',
				'choices'  => array(
					'full_width'  => __( 'Full Width', 'gusto' ),
					'full_height' => __( 'Full Height', 'gusto' ),
					'cover'       => __( 'Cover', 'gusto' ),
				),
			)
		)
	);

	// Register Logo Type setting and control
	$wp_customize->add_setting(
		'separator_before_logo_type', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_logo_type', array(
				'section'  => 'ttt_general',
				'settings' => 'separator_before_logo_type',
			)
		)
	);

	$wp_customize->add_setting(
		'logo_type', array(
			'default'           => 'text',
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
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'text_logo', array(
			'label'       => __( 'Logo Text', 'gusto' ),
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
		'separator_before_fav_icon', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_fav_icon', array(
				'section'  => 'ttt_general',
				'settings' => 'separator_before_fav_icon',
			)
		)
	);

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
		'separator_before_page_transition_loading', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_page_transition_loading', array(
				'section'  => 'ttt_general',
				'settings' => 'separator_before_page_transition_loading',
			)
		)
	);

	$wp_customize->add_setting(
		'page_transition_loading', array(
			'default'           => 'yes',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
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
		'separator_before_go_to_top_link', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_go_to_top_link', array(
				'section'  => 'ttt_general',
				'settings' => 'separator_before_go_to_top_link',
			)
		)
	);

	$wp_customize->add_setting(
		'go_to_top_link', array(
			'default'           => 'yes',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
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
		'separator_before_theme_style', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_theme_style', array(
				'section'  => 'ttt_colors',
				'settings' => 'separator_before_theme_style',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_style', array(
			'default'           => 'light',
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
		'separator_before_link_color', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_link_color', array(
				'section'  => 'ttt_colors',
				'settings' => 'separator_before_link_color',
			)
		)
	);

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
		'separator_before_section_color_1', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_section_color_1', array(
				'section'  => 'ttt_colors',
				'settings' => 'separator_before_section_color_1',
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
		'separator_before_reset_colors', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_reset_colors', array(
				'section'  => 'ttt_colors',
				'settings' => 'separator_before_reset_colors',
			)
		)
	);

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

	// Register Typography section
	$wp_customize->add_section(
		'ttt_typography', array(
			'title'       => __( 'Typography', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'priority'    => 2,
		)
	);

	// Register Custom Font setting and control
	$wp_customize->add_setting(
		'separator_before_custom_font', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_custom_font', array(
				'section'  => 'ttt_typography',
				'settings' => 'separator_before_custom_font',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_font', array(
			'default'           => 'no',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'custom_font', array(
				'label'    => __( 'Custom Font', 'gusto' ),
				'section'  => 'ttt_typography',
				'settings' => 'custom_font',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	// Register typography setting and control
	$wp_customize->add_setting(
		'custom_fonts', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_option',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Typography(
			$wp_customize, 'custom_fonts', array(
				'section'  => 'ttt_typography',
				'settings' => 'custom_fonts',
				'options'  => array(
					'body_text' => array(
						'label'          => __( 'Body Text', 'gusto' ),
						'font_family'    => '',
						'font_size'      => '14',
						'line_height'    => '16',
						'spacing'        => '0px',
						'font_style'     => 'Regular',
						'text_transform' => 'Lowercase',
						'subset'         => 'Latin',
					),
					'logo_text' => array(
						'label'          => __( 'Logo Text', 'gusto' ),
						'font_family'    => '',
						'font_size'      => '20',
						'line_height'    => '24',
						'spacing'        => '0px',
						'font_style'     => 'Regular',
						'text_transform' => 'Lowercase',
						'subset'         => 'Latin',
					),
					'section_heading' => array(
						'label'          => __( 'Section Heading', 'gusto' ),
						'font_family'    => '',
						'font_size'      => '24',
						'line_height'    => '26',
						'spacing'        => '0px',
						'font_style'     => 'Regular',
						'text_transform' => 'Lowercase',
						'subset'         => 'Latin',
					),
					'section_sub_heading' => array(
						'label'          => __( 'Section Sub Heading', 'gusto' ),
						'font_family'    => '',
						'font_size'      => '18',
						'line_height'    => '20',
						'spacing'        => '0px',
						'font_style'     => 'Regular',
						'text_transform' => 'Lowercase',
						'subset'         => 'Latin',
					),
					'page_heading' => array(
						'label'          => __( 'Page Heading', 'gusto' ),
						'font_family'    => '',
						'font_size'      => '32',
						'line_height'    => '36',
						'spacing'        => '0px',
						'font_style'     => 'Regular',
						'text_transform' => 'Lowercase',
						'subset'         => 'Latin',
					),
				),
			)
		)
	);

	// Register Header section
	$wp_customize->add_section(
		'ttt_header', array(
			'title'       => __( 'Header', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'priority'    => 3,
		)
	);

	// Register Header Layout setting and control
	$wp_customize->add_setting(
		'separator_before_header_layout', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_header_layout', array(
				'section'  => 'ttt_header',
				'settings' => 'separator_before_header_layout',
			)
		)
	);

	$wp_customize->add_setting(
		'header_layout', array(
			'default'           => 'default',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'header_layout', array(
				'label'    => __( 'Header Layout', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'header_layout',
				'style'    => 'image',
				'choices'  => array(
					'default' => array(
						'label' => __( 'Default', 'gusto' ),
						'image' => get_template_directory_uri() . '/assets/images/header_layout_1.jpg',
					),
					'centered_menu' => array(
						'label' => __( 'Centered Menu', 'gusto' ),
						'image' => get_template_directory_uri() . '/assets/images/header_layout_2.jpg',
					),
					'centered_logo' => array(
						'label' => __( 'Centered Logo', 'gusto' ),
						'image' => get_template_directory_uri() . '/assets/images/header_layout_3.jpg',
					),
				),
			)
		)
	);

	// Register Sticky Header setting and control
	$wp_customize->add_setting(
		'separator_before_sticky_header', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_sticky_header', array(
				'section'  => 'ttt_header',
				'settings' => 'separator_before_sticky_header',
			)
		)
	);

	$wp_customize->add_setting(
		'sticky_header', array(
			'default'           => 'yes',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'sticky_header', array(
				'label'    => __( 'Sticky Header', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'sticky_header',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	// Register Search Box setting and control
	$wp_customize->add_setting(
		'separator_before_search_box', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_search_box', array(
				'section'  => 'ttt_header',
				'settings' => 'separator_before_search_box',
			)
		)
	);

	$wp_customize->add_setting(
		'search_box', array(
			'default'           => 'no',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'search_box', array(
				'label'    => __( 'Search Box', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'search_box',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	// Register Social Icons settings and controls
	$wp_customize->add_setting(
		'separator_before_show_header_social_icons', array(
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_show_header_social_icons', array(
				'section'  => 'ttt_header',
				'settings' => 'separator_before_show_header_social_icons',
			)
		)
	);

	$wp_customize->add_setting(
		'show_header_social_icons', array(
			'default'           => 'yes',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'show_header_social_icons', array(
				'label'    => __( 'Social Icons', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'show_header_social_icons',
				'choices'  => array(
					'yes' => __( 'Yes', 'gusto' ),
					'no'  => __( 'No', 'gusto' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'header_social_icons', array(
			'default'           => array( 'facebook', 'twitter' ),
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Social_Icons(
			$wp_customize, 'header_social_icons', array(
				'section'  => 'ttt_header',
				'settings' => 'header_social_icons',
				'linked'   => 'social_config',
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
	// Load Foundation
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/assets/foundation/css/normalize.css', array(), '3.0.3' );
	wp_enqueue_style( 'foundation', get_template_directory_uri() . '/assets/foundation/css/foundation.min.css', array(), '5.5.2' );
	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/foundation/js/foundation.min.js', array( 'jquery' ), '5.5.2', true );

	// Load extra styles for customizer
	wp_enqueue_style( 'customizer_css', get_template_directory_uri() . '/css/customizer.css', array() );

	// Load options toggler
	wp_enqueue_script( 'gusto_options', get_template_directory_uri() . '/js/options.js', array( 'jquery' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'gusto_customize_scripts' );

/**
 * Print inline styles.
 */
function gusto_inline_styles () {
	?>
	<!-- style type="text/css">
		.wp-full-overlay.expanded {
			margin-left: 400px;
		}
		.wp-full-overlay-sidebar {
			width: 400px;
		}
	</style> -->
	<?php
}
add_action( 'customize_controls_print_scripts', 'gusto_inline_styles' );