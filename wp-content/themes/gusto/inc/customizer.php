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
	// Change transport setting for default theme options
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Remove default sections
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'colors'           );
	$wp_customize->remove_section( 'title_tagline'    );

	// Load custom customize control classes
	include_once dirname( __FILE__ ) . '/customize-control/code-editor.php';
	include_once dirname( __FILE__ ) . '/customize-control/data.php';
	include_once dirname( __FILE__ ) . '/customize-control/location.php';
	include_once dirname( __FILE__ ) . '/customize-control/radio.php';
	include_once dirname( __FILE__ ) . '/customize-control/reset.php';
	include_once dirname( __FILE__ ) . '/customize-control/separator.php';
	include_once dirname( __FILE__ ) . '/customize-control/social-config.php';
	include_once dirname( __FILE__ ) . '/customize-control/social-icons.php';
	include_once dirname( __FILE__ ) . '/customize-control/switch.php';
	include_once dirname( __FILE__ ) . '/customize-control/textarea.php';
	include_once dirname( __FILE__ ) . '/customize-control/typography.php';

	// Register custom control types are eligible to be rendered via JS and created dynamically.
	$wp_customize->register_control_type( 'TTT_Customize_Control_Code_Editor'   );
	$wp_customize->register_control_type( 'TTT_Customize_Control_Location'      );
	$wp_customize->register_control_type( 'TTT_Customize_Control_Social_Config' );
	$wp_customize->register_control_type( 'TTT_Customize_Control_Social_Icons'  );

	// Register General panel and section
	$wp_customize->add_panel(
		'ttt_panel_general', array(
			'title'    => __( 'General', 'gusto' ),
			'priority' => 10,
		)
	);

	$wp_customize->add_section(
		'ttt_general', array(
			'title'       => __( 'General', 'gusto' ),
			'description' => __( 'Your general settings of the theme. Configuring layout type, logo, page transition...', 'gusto' ),
			'panel'       => 'ttt_panel_general',
			'priority'    => 10,
		)
	);

	// Register Theme Layout settings and controls
	$wp_customize->add_setting(
		'separator_before_theme_layout', array(
			'sanitize_callback' => '',
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

	// Register Logo Type settings and controls
	$wp_customize->add_setting(
		'separator_before_logo_type', array(
			'sanitize_callback' => '',
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

	// Register Fav Icon settings and controls
	$wp_customize->add_setting(
		'separator_before_fav_icon', array(
			'sanitize_callback' => '',
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
			'sanitize_callback' => '',
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
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'page_transition_loading', array(
				'label'    => __( 'Page Transition Loading', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'page_transition_loading',
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_go_to_top_link', array(
			'sanitize_callback' => '',
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
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'go_to_top_link', array(
				'label'    => __( 'Go-to-Top Link', 'gusto' ),
				'section'  => 'ttt_general',
				'settings' => 'go_to_top_link',
			)
		)
	);

	// Register Colors panel and section
	$wp_customize->add_panel(
		'ttt_panel_colors', array(
			'title'    => __( 'Colors', 'gusto' ),
			'priority' => 20,
		)
	);

	$wp_customize->add_section(
		'ttt_colors', array(
			'title'       => __( 'Colors', 'gusto' ),
			'description' => __( 'Setup your theme color.', 'gusto' ),
			'panel'       => 'ttt_panel_colors',
			'priority'    => 20,
		)
	);

	// Register Theme Style settings and controls
	$wp_customize->add_setting(
		'separator_before_theme_style', array(
			'sanitize_callback' => '',
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

	// Register Colors settings and controls
	$wp_customize->add_setting(
		'separator_before_link_color', array(
			'sanitize_callback' => '',
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
			'sanitize_callback' => '',
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

	$wp_customize->add_setting(
		'separator_before_reset_colors', array(
			'sanitize_callback' => '',
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

	// Register Typography panel and section
	$wp_customize->add_panel(
		'ttt_panel_typography', array(
			'title'    => __( 'Typography', 'gusto' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_section(
		'ttt_typography', array(
			'title'       => __( 'Typography', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'panel'       => 'ttt_panel_typography',
			'priority'    => 30,
		)
	);

	// Register Custom Fonts settings and controls
	$wp_customize->add_setting(
		'separator_before_custom_fonts', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_custom_fonts', array(
				'section'  => 'ttt_typography',
				'settings' => 'separator_before_custom_fonts',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_fonts', array(
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'custom_fonts', array(
				'label'    => __( 'Custom Fonts', 'gusto' ),
				'section'  => 'ttt_typography',
				'settings' => 'custom_fonts',
			)
		)
	);

	// Register typography settings and controls
	$wp_customize->add_setting(
		'typography', array(
			'default' => array(
				'body' => array(
					'font_family'    => '',
					'font_size'      => '',
					'line_height'    => '',
					'spacing'        => '',
					'font_style'     => '',
					'text_transform' => '',
					'subset'         => '',
				),
				'logo' => array(
					'font_family'    => '',
					'font_size'      => '',
					'line_height'    => '',
					'spacing'        => '',
					'font_style'     => '',
					'text_transform' => '',
					'subset'         => '',
				),
				'section_heading' => array(
					'font_family'    => '',
					'font_size'      => '',
					'line_height'    => '',
					'spacing'        => '',
					'font_style'     => '',
					'text_transform' => '',
					'subset'         => '',
				),
				'section_subheading' => array(
					'font_family'    => '',
					'font_size'      => '',
					'line_height'    => '',
					'spacing'        => '',
					'font_style'     => '',
					'text_transform' => '',
					'subset'         => '',
				),
				'page_heading' => array(
					'font_family'    => '',
					'font_size'      => '',
					'line_height'    => '',
					'spacing'        => '',
					'font_style'     => '',
					'text_transform' => '',
					'subset'         => '',
				),
			),
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Typography(
			$wp_customize, 'typography', array(
				'section'  => 'ttt_typography',
				'settings' => 'typography',
			)
		)
	);

	// Register Header panel and section
	$wp_customize->add_panel(
		'ttt_panel_header', array(
			'title'    => __( 'Header', 'gusto' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_section(
		'ttt_header', array(
			'title'       => __( 'Header', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'panel'       => 'ttt_panel_header',
			'priority'    => 40,
		)
	);

	// Register Header Layout settings and controls
	$wp_customize->add_setting(
		'separator_before_header_layout', array(
			'sanitize_callback' => '',
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

	// Register Sticky Header settings and controls
	$wp_customize->add_setting(
		'separator_before_sticky_header', array(
			'sanitize_callback' => '',
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
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'sticky_header', array(
				'label'    => __( 'Sticky Header', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'sticky_header',
			)
		)
	);

	// Register Search Box settings and controls
	$wp_customize->add_setting(
		'separator_before_search_box', array(
			'sanitize_callback' => '',
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
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'search_box', array(
				'label'    => __( 'Search Box', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'search_box',
			)
		)
	);

	// Register Social Icons settings and controls
	$wp_customize->add_setting(
		'separator_before_show_header_social_icons', array(
			'sanitize_callback' => '',
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
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'show_header_social_icons', array(
				'label'    => __( 'Social Icons', 'gusto' ),
				'section'  => 'ttt_header',
				'settings' => 'show_header_social_icons',
			)
		)
	);

	$wp_customize->add_setting(
		'header_social_icons', array(
			'default'           => array(),
			'sanitize_callback' => '',
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

	// Register Footer panel and section
	$wp_customize->add_panel(
		'ttt_panel_footer', array(
			'title'    => __( 'Footer', 'gusto' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_section(
		'ttt_footer', array(
			'title'       => __( 'Footer', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'panel'       => 'ttt_panel_footer',
			'priority'    => 50,
		)
	);

	// Register Widgets Area settings and controls
	$wp_customize->add_setting(
		'separator_before_footer_widgets', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_footer_widgets', array(
				'section'  => 'ttt_footer',
				'settings' => 'separator_before_footer_widgets',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_widgets', array(
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'footer_widgets', array(
				'label'    => __( 'Footer Widgets Area', 'gusto' ),
				'section'  => 'ttt_footer',
				'settings' => 'footer_widgets',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_widgets_layout', array(
			'default'           => '1-column',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'footer_widgets_layout', array(
				'label'    => __( 'Footer Widgets Layout', 'gusto' ),
				'section'  => 'ttt_footer',
				'settings' => 'footer_widgets_layout',
				'style'    => 'image',
				'span'     => 3,
				'choices'  => array(
					'1-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/footer_widgets_layout_1.jpg',
					),
					'2-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/footer_widgets_layout_2.jpg',
					),
					'3-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/footer_widgets_layout_3.jpg',
					),
					'4-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/footer_widgets_layout_4.jpg',
					),
				),
			)
		)
	);

	// Register Custom Copyright settings and controls
	$wp_customize->add_setting(
		'separator_before_custom_copyright', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_custom_copyright', array(
				'section'  => 'ttt_footer',
				'settings' => 'separator_before_custom_copyright',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_copyright', array(
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'custom_copyright', array(
				'label'    => __( 'Custom Copyright', 'gusto' ),
				'section'  => 'ttt_footer',
				'settings' => 'custom_copyright',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_copyright_text', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Textarea(
			$wp_customize, 'custom_copyright_text', array(
				'section'     => 'ttt_footer',
				'settings'    => 'custom_copyright_text',
				'placeholder' => __( '$this->placeholder', 'gusto' ),
			)
		)
	);

	// Register Social Icons settings and controls
	$wp_customize->add_setting(
		'separator_before_show_footer_social_icons', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_show_footer_social_icons', array(
				'section'  => 'ttt_footer',
				'settings' => 'separator_before_show_footer_social_icons',
			)
		)
	);

	$wp_customize->add_setting(
		'show_footer_social_icons', array(
			'default'           => 'off',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'show_footer_social_icons', array(
				'label'    => __( 'Social Icons', 'gusto' ),
				'section'  => 'ttt_footer',
				'settings' => 'show_footer_social_icons',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_social_icons', array(
			'default'           => array(),
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Social_Icons(
			$wp_customize, 'footer_social_icons', array(
				'section'  => 'ttt_footer',
				'settings' => 'footer_social_icons',
				'linked'   => 'social_config',
			)
		)
	);

	// Register Blog panel and section
	$wp_customize->add_panel(
		'ttt_panel_blog', array(
			'title'    => __( 'Blog', 'gusto' ),
			'priority' => 60,
		)
	);

	$wp_customize->add_section(
		'ttt_blog', array(
			'title'       => __( 'Blog', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'panel'       => 'ttt_panel_blog',
			'priority'    => 60,
		)
	);

	// Register Blog Layout settings and controls
	$wp_customize->add_setting(
		'separator_before_blog_layout', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_blog_layout', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_blog_layout',
			)
		)
	);

	$wp_customize->add_setting(
		'blog_layout', array(
			'default'           => '1-column',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'blog_layout', array(
				'label'    => __( 'Blog Layout', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'blog_layout',
				'style'    => 'image',
				'span'     => 3,
				'choices'  => array(
					'1-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/blog_layout_1.jpg',
					),
					'3-column' => array(
						'image' => get_template_directory_uri() . '/assets/images/blog_layout_2.jpg',
					),
					'2-column-left' => array(
						'image' => get_template_directory_uri() . '/assets/images/blog_layout_3.jpg',
					),
					'2-column-right' => array(
						'image' => get_template_directory_uri() . '/assets/images/blog_layout_4.jpg',
					),
				),
			)
		)
	);

	// Register Mansonry Style settings and controls
	$wp_customize->add_setting(
		'separator_before_mansonry_style', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_mansonry_style', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_mansonry_style',
			)
		)
	);

	$wp_customize->add_setting(
		'mansonry_style', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'mansonry_style', array(
				'label'    => __( 'Mansonry Style', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'mansonry_style',
			)
		)
	);

	// Register Automatic Post Excerpts settings and controls
	$wp_customize->add_setting(
		'separator_before_automatic_post_excerpts', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_automatic_post_excerpts', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_automatic_post_excerpts',
			)
		)
	);

	$wp_customize->add_setting(
		'automatic_post_excerpts', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'automatic_post_excerpts', array(
				'label'    => __( 'Automatic Post Excerpts', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'automatic_post_excerpts',
			)
		)
	);

	$wp_customize->add_setting(
		'automatic_excerpts_length', array(
			'default'           => 250,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'automatic_excerpts_length', array(
			'label'       => __( 'Automatic Excerpts Length', 'gusto' ),
			'section'     => 'ttt_blog',
			'settings'    => 'automatic_excerpts_length',
			'type'        => 'number',
		)
	);

	// Register other blog settings and controls
	$wp_customize->add_setting(
		'separator_before_pagination_style', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_pagination_style', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_pagination_style',
			)
		)
	);

	$wp_customize->add_setting(
		'pagination_style', array(
			'default'           => 'pagination',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Radio(
			$wp_customize, 'pagination_style', array(
				'label'    => __( 'Pagination Style', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'pagination_style',
				'style'    => 'radio-group',
				'choices'  => array(
					'next_prev'       => __( 'Next / Prev', 'gusto' ),
					'pagination'      => __( 'Pagination', 'gusto' ),
					'infinity_scroll' => __( 'Infinity Scroll', 'gusto' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_hide_sidebar_on_single_post', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_hide_sidebar_on_single_post', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_hide_sidebar_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'hide_sidebar_on_single_post', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'hide_sidebar_on_single_post', array(
				'label'    => __( 'Hide Sidebar On Single Post', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'hide_sidebar_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_featured_image_on_single_post', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_featured_image_on_single_post', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_featured_image_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'featured_image_on_single_post', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'featured_image_on_single_post', array(
				'label'    => __( 'Featured Image On Single Post', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'featured_image_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_prev_next_on_single_post', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_prev_next_on_single_post', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_prev_next_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'prev_next_on_single_post', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'prev_next_on_single_post', array(
				'label'    => __( 'Prev / Next On Single Post', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'prev_next_on_single_post',
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_single_post_tag', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_single_post_tag', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_single_post_tag',
			)
		)
	);

	$wp_customize->add_setting(
		'single_post_tag', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'single_post_tag', array(
				'label'    => __( 'Single Post Tag', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'single_post_tag',
			)
		)
	);

	$wp_customize->add_setting(
		'separator_before_single_post_author_bio', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_single_post_author_bio', array(
				'section'  => 'ttt_blog',
				'settings' => 'separator_before_single_post_author_bio',
			)
		)
	);

	$wp_customize->add_setting(
		'single_post_author_bio', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'single_post_author_bio', array(
				'label'    => __( 'Single Post Author Bio', 'gusto' ),
				'section'  => 'ttt_blog',
				'settings' => 'single_post_author_bio',
			)
		)
	);

	// Register Social Links panel and section
	$wp_customize->add_panel(
		'ttt_panel_social_links', array(
			'title'    => __( 'Social Links', 'gusto' ),
			'priority' => 70,
		)
	);

	$wp_customize->add_section(
		'ttt_social_links', array(
			'title'       => __( 'Social Links', 'gusto' ),
			'description' => __( 'Here you can set whether to use or not to use social media links. Input URL of your social link to enable using it. Remember to put http:// to the URL.', 'gusto' ),
			'panel'       => 'ttt_panel_social_links',
			'priority'    => 70,
		)
	);

	// Register Social Channel Links settings and controls
	$wp_customize->add_setting(
		'separator_before_social_config', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_social_config', array(
				'section'  => 'ttt_social_links',
				'settings' => 'separator_before_social_config',
			)
		)
	);

	$wp_customize->add_setting(
		'social_config', array(
			'default'           => array(),
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Social_Config(
			$wp_customize, 'social_config', array(
				'label'    => __( 'Social Channel Links', 'gusto' ),
				'section'  => 'ttt_social_links',
				'settings' => 'social_config',
			)
		)
	);

	// Register Map panel and section
	$wp_customize->add_panel(
		'ttt_panel_map', array(
			'title'    => __( 'Map', 'gusto' ),
			'priority' => 80,
		)
	);

	$wp_customize->add_section(
		'ttt_map', array(
			'title'       => __( 'Map', 'gusto' ),
			'description' => __( 'Here you can configure your Google map. Please refer to <a href="http://latlong.net" target="_blank">http://latlong.net</a> to get the latitude and longitude of your address.', 'gusto' ),
			'panel'       => 'ttt_panel_map',
			'priority'    => 80,
		)
	);

	// Register general map settings and controls
	$wp_customize->add_setting(
		'separator_before_show_map_on_home', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_show_map_on_home', array(
				'section'  => 'ttt_map',
				'settings' => 'separator_before_show_map_on_home',
			)
		)
	);

	$wp_customize->add_setting(
		'show_map_on_home', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'show_map_on_home', array(
				'label'    => __( 'Show Map on Home Page', 'gusto' ),
				'section'  => 'ttt_map',
				'settings' => 'show_map_on_home',
			)
		)
	);

	$wp_customize->add_setting(
		'show_map_on_contact', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'show_map_on_contact', array(
				'label'    => __( 'Show Map on Contact Page', 'gusto' ),
				'section'  => 'ttt_map',
				'settings' => 'show_map_on_contact',
			)
		)
	);

	// Register centered position settings and controls
	$wp_customize->add_setting(
		'separator_before_centered_position_latitude', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_centered_position_latitude', array(
				'section'  => 'ttt_map',
				'settings' => 'separator_before_centered_position_latitude',
			)
		)
	);

	$wp_customize->add_setting(
		'centered_position_latitude', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'centered_position_latitude', array(
			'label'       => __( 'Centered Position Latitude', 'gusto' ),
			'section'     => 'ttt_map',
			'settings'    => 'centered_position_latitude',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Enter latitude here', 'gusto' ),
			),
		)
	);

	$wp_customize->add_setting(
		'centered_position_longitude', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'centered_position_longitude', array(
			'label'       => __( 'Centered Position Longitude', 'gusto' ),
			'section'     => 'ttt_map',
			'settings'    => 'centered_position_longitude',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Enter longitude here', 'gusto' ),
			),
		)
	);

	// Register map zooming settings and controls
	$wp_customize->add_setting(
		'separator_before_map_zoom_display', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_map_zoom_display', array(
				'section'  => 'ttt_map',
				'settings' => 'separator_before_map_zoom_display',
			)
		)
	);

	$wp_customize->add_setting(
		'map_zoom_display', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'map_zoom_display', array(
				'label'    => __( 'Map Zoom Display', 'gusto' ),
				'section'  => 'ttt_map',
				'settings' => 'map_zoom_display',
			)
		)
	);

	$wp_customize->add_setting(
		'map_zoom_level', array(
			'default'           => '14',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		'map_zoom_level', array(
			'label'    => __( 'Map Zoom Level', 'gusto' ),
			'section'  => 'ttt_map',
			'settings' => 'map_zoom_level',
			'type'     => 'select',
			'choices'  => array(
				'1'  => '1',
				'2'  => '2',
				'3'  => '3',
				'4'  => '4',
				'5'  => '5',
				'6'  => '6',
				'7'  => '7',
				'8'  => '8',
				'9'  => '9',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
			),
		)
	);

	// Register Location Box settings and controls
	$wp_customize->add_setting(
		'separator_before_location_box', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_location_box', array(
				'section'  => 'ttt_map',
				'settings' => 'separator_before_location_box',
			)
		)
	);

	$wp_customize->add_setting(
		'location_box', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'location_box', array(
				'label'    => __( 'Location Box', 'gusto' ),
				'section'  => 'ttt_map',
				'settings' => 'location_box',
			)
		)
	);

	$wp_customize->add_setting(
		'location_box_data', array(
			'default'           => array(),
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Location(
			$wp_customize, 'location_box_data', array(
				'section'  => 'ttt_map',
				'settings' => 'location_box_data',
			)
		)
	);

	// Register Custom Marker settings and controls
	$wp_customize->add_setting(
		'separator_before_custom_marker', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_custom_marker', array(
				'section'  => 'ttt_map',
				'settings' => 'separator_before_custom_marker',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_marker', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'custom_marker', array(
				'label'    => __( 'Custom Marker', 'gusto' ),
				'section'  => 'ttt_map',
				'settings' => 'custom_marker',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_marker_image', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'custom_marker_image', array(
				'section'  => 'ttt_map',
				'settings' => 'custom_marker_image',
			)
		)
	);

	// Register Advances panel and section
	$wp_customize->add_panel(
		'ttt_panel_advances', array(
			'title'    => __( 'Advances', 'gusto' ),
			'priority' => 90,
		)
	);

	$wp_customize->add_section(
		'ttt_advances', array(
			'title'       => __( 'Others', 'gusto' ),
			'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet proin gravida dolor sit.', 'gusto' ),
			'panel'       => 'ttt_panel_advances',
			'priority'    => 90,
		)
	);

	// Register general advances settings and controls
	$wp_customize->add_setting(
		'separator_before_google_analytics_id', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_google_analytics_id', array(
				'section'  => 'ttt_advances',
				'settings' => 'separator_before_google_analytics_id',
			)
		)
	);

	$wp_customize->add_setting(
		'google_analytics_id', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'google_analytics_id', array(
			'label'       => __( 'Google Analytics ID', 'gusto' ),
			'section'     => 'ttt_advances',
			'settings'    => 'google_analytics_id',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'facebook_pixel_id', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'facebook_pixel_id', array(
			'label'       => __( 'Facebook Remarketing Pixel ID', 'gusto' ),
			'section'     => 'ttt_advances',
			'settings'    => 'facebook_pixel_id',
			'type'        => 'text',
		)
	);

	// Register Custom CSS settings and controls
	$wp_customize->add_setting(
		'separator_before_custom_css', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_custom_css', array(
				'section'  => 'ttt_advances',
				'settings' => 'separator_before_custom_css',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_css', array(
			'default'           => 'on',
			'sanitize_callback' => 'sanitize_key',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Switch(
			$wp_customize, 'custom_css', array(
				'label'    => __( 'Custom CSS', 'gusto' ),
				'section'  => 'ttt_advances',
				'settings' => 'custom_css',
			)
		)
	);

	$wp_customize->add_setting(
		'custom_css_data', array(
			'default'           => '',
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Code_Editor(
			$wp_customize, 'custom_css_data', array(
				'section'  => 'ttt_advances',
				'settings' => 'custom_css_data',
				'language' => 'css',
			)
		)
	);

	// Register Backup / Restore panel and section
	$wp_customize->add_panel(
		'ttt_panel_data', array(
			'title'    => __( 'Backup / Restore', 'gusto' ),
			'priority' => 100,
		)
	);

	$wp_customize->add_section(
		'ttt_data', array(
			'title'       => __( 'Backup / Restore', 'gusto' ),
			'description' => __( 'Here you can Backup or Restore your theme settings. Use &quot;Install Sample Data&quot; to have the front-end looks like our demo (your current web content will be lost).', 'gusto' ),
			'panel'       => 'ttt_panel_data',
			'priority'    => 100,
		)
	);

	// Register Backup / Restore settings and controls
	$wp_customize->add_setting(
		'separator_before_data_manipulation', array(
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Separator(
			$wp_customize, 'separator_before_data_manipulation', array(
				'section'  => 'ttt_data',
				'settings' => 'separator_before_data_manipulation',
			)
		)
	);

	$wp_customize->add_setting(
		'data_manipulation', array(
			'default'           => '',
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		new TTT_Customize_Control_Data(
			$wp_customize, 'data_manipulation', array(
				'section'  => 'ttt_data',
				'settings' => 'data_manipulation',
			)
		)
	);

	// Remove all panels if WordPress version is >= 4.3
	global $wp_version;

	if ( version_compare( $wp_version, '4.3', '>=' ) ) {
		// Move all sections out of panel
		$wp_customize->get_section( 'ttt_general'      )->panel = null;
		$wp_customize->get_section( 'ttt_colors'       )->panel = null;
		$wp_customize->get_section( 'ttt_typography'   )->panel = null;
		$wp_customize->get_section( 'ttt_header'       )->panel = null;
		$wp_customize->get_section( 'ttt_footer'       )->panel = null;
		$wp_customize->get_section( 'ttt_blog'         )->panel = null;
		$wp_customize->get_section( 'ttt_social_links' )->panel = null;
		$wp_customize->get_section( 'ttt_map'          )->panel = null;
		$wp_customize->get_section( 'ttt_advances'     )->panel = null;
		$wp_customize->get_section( 'ttt_data'         )->panel = null;

		$wp_customize->get_section( 'ttt_advances' )->title = __( 'Advances', 'gusto' );

		// Remove all panels
		$wp_customize->remove_panel( 'ttt_panel_general'      );
		$wp_customize->remove_panel( 'ttt_panel_colors'       );
		$wp_customize->remove_panel( 'ttt_panel_typography'   );
		$wp_customize->remove_panel( 'ttt_panel_header'       );
		$wp_customize->remove_panel( 'ttt_panel_footer'       );
		$wp_customize->remove_panel( 'ttt_panel_blog'         );
		$wp_customize->remove_panel( 'ttt_panel_social_links' );
		$wp_customize->remove_panel( 'ttt_panel_map'          );
		$wp_customize->remove_panel( 'ttt_panel_advances'     );
		$wp_customize->remove_panel( 'ttt_panel_data'         );
	}

	else {
		// Move Static Front Page section to Advances panel
		$wp_customize->get_section( 'static_front_page' )->panel = 'ttt_panel_advances';
	}
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

/**
 * Register AJAX action to backup / restore settings and install sample data.
 */
function gusto_customize_ajax() {
	// Get requested Ajax task
	$task = isset( $_REQUEST['task'] ) ? $_REQUEST['task'] : null;

	if ( $task ) {
		switch ( $task ) {
			case 'backup_settings' :
				// Get current settings
				$settings = array(
					'theme_mods' => get_theme_mods(),
					'sidebars_widgets' => get_option( 'sidebars_widgets' ),
				);

				// Clear all output buffering
				while ( ob_get_level() ) {
					ob_end_clean();
				}

				// Set inline download header
				header( 'Content-disposition: attachment; filename=gusto_settings.json' );
				header( 'Content-type: application/json' );

				// JSON encode current settings then echo
				echo json_encode( $settings );

				// Then exit immediately to prevent further processing
				exit;
			break;

			case 'restore_settings' :
				// Read upload file content then JSON decode
				$settings = json_decode( file_get_contents( $_FILES['backup_file']['tmp_name'] ), true );

				if ( ! $settings ) {
					exit( __( 'Invalid settings backup file.', 'gusto' ) );
				}

				// Restore settings if difference
				if ( json_encode( $settings['theme_mods'] ) != json_encode( get_theme_mods() ) ) {
					if ( ! update_option( 'theme_mods_gusto', $settings['theme_mods'] ) ) {
						exit( __( 'Failed to restore theme settings.', 'gusto' ) );
					}
				}

				if ( json_encode( $settings['sidebars_widgets'] ) != json_encode( get_option( 'sidebars_widgets' ) ) ) {
					if ( ! update_option( 'sidebars_widgets', $settings['sidebars_widgets'] ) ) {
						exit( __( 'Failed to restore sidebars widgets.', 'gusto' ) );
					}
				}

				exit( __( 'Settings restored successfully.', 'gusto' ) );
			break;

			case 'install_sample_data' :
			break;
		}
	}
}
add_action( 'wp_ajax_gusto_manipulate_data', 'gusto_customize_ajax' );