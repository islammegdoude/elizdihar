<?php
/**
 * Marquee map.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_marquee' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_marquee() {
		$marquee_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Typography', 'woodmart' ),
				'key'      => 'marquee_typography',
				'selector' => '{{WRAPPER}} .wd-marquee',
			)
		);

		return array(
			'base'        => 'woodmart_marquee',
			'name'        => esc_html__( 'Marquee', 'woodmart' ),
			'description' => esc_html__( 'Text scrolling area', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/marquee.svg',
			'params'      => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),
				/**
				 * Settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Settings', 'woodmart' ),
					'param_name' => 'general_settings_divider',
				),

				array(
					'type'             => 'wd_number',
					'heading'          => esc_html__( 'Scrolling speed', 'woodmart' ),
					'param_name'       => 'speed',
					'hint'             => esc_html__( 'Duration of one animation cycle (in seconds)', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'placeholder' => '5',
						),
						'tablet'  => array(
							'placeholder' => '5',
						),
						'mobile'  => array(
							'placeholder' => '5',
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .wd-marquee' => array(
							'--wd-marquee-speed: {{VALUE}}s;',
						),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				array(
					'type'             => 'wd_select',
					'heading'          => esc_html__( 'Scrolling direction', 'woodmart' ),
					'param_name'       => 'direction',
					'style'            => 'select',
					'selectors'        => array(
						'{{WRAPPER}} .wd-marquee' => array(
							'--wd-marquee-direction: {{VALUE}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
						),
					),
					'value'            => array(
						esc_html__( 'Right to left', 'woodmart' ) => '',
						esc_html__( 'Left to right', 'woodmart' ) => 'reverse',
						esc_html__( 'Right to left and reverse', 'woodmart' ) => 'alternate',
						esc_html__( 'Left to right and reverse', 'woodmart' ) => 'alternate-reverse',
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Pause on hover', 'woodmart' ),
					'param_name'       => 'paused_on_hover',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				$marquee_typography['font_family'],
				$marquee_typography['font_size'],
				$marquee_typography['font_weight'],
				$marquee_typography['text_transform'],
				$marquee_typography['font_style'],
				$marquee_typography['line_height'],

				array(
					'type'             => 'wd_colorpicker',
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'param_name'       => 'marquee_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-marquee' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'       => esc_html__( 'Items gap', 'woodmart' ),
					'type'          => 'wd_slider',
					'param_name'    => 'content_gap',
					'selectors'     => array(
						'{{WRAPPER}} .wd-marquee' => array(
							'--wd-marquee-gap: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'         => array(
						'px' => array(
							'min'  => 0,
							'max'  => 200,
							'step' => 1,
						),
					),
					'generate_zero' => true,
				),

				/**
				 * Content.
				 */
				array(
					'type'       => 'param_group',
					'param_name' => 'marquee_contents',
					'heading'    => esc_html__( 'Content', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'value'      => rawurlencode(
						wp_json_encode(
							array(
								array(
									'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
								),
							)
						)
					),
					'params'     => array(
						array(
							'type'       => 'vc_link',
							'heading'    => esc_html__( 'Link', 'woodmart' ),
							'param_name' => 'link',
						),
						array(
							'param_name' => 'text',
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Text', 'woodmart' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Icon type', 'woodmart' ),
							'value'      => array(
								esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
								esc_html__( 'With image', 'woodmart' ) => 'image',
							),
							'param_name' => 'icon_type',
						),
						array(
							'type'             => 'attach_image',
							'heading'          => esc_html__( 'Custom image', 'woodmart' ),
							'param_name'       => 'image_id',
							'value'            => '',
							'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'dependency'       => array(
								'element' => 'icon_type',
								'value'   => array( 'image' ),
							),
						),
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Image size', 'woodmart' ),
							'param_name'       => 'image_size',
							'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
							'dependency'       => array(
								'element' => 'icon_type',
								'value'   => array( 'image' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
						),
					),
				),
				/**
				 * Icon.
				 */
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon type', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'value'      => array(
						esc_html__( 'Without icon', 'woodmart' ) => 'without',
						esc_html__( 'With icon', 'woodmart' ) => 'icon',
						esc_html__( 'With image', 'woodmart' ) => 'image',
					),
					'param_name' => 'icon_type',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'group'            => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => array( 'image' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'group'            => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => array( 'image' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon library', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'value'      => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
						esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
						esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
						esc_html__( 'Material', 'woodmart' ) => 'material',
					),
					'param_name' => 'icon_library',
					'hint'       => esc_html__( 'Select icon library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'icon',
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_fontawesome',
					'value'      => 'far fa-bell',
					'settings'   => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'fontawesome',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_openiconic',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'openiconic',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_typicons',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'typicons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_entypo',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'entypo',
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_linecons',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'linecons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_monosocial',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'monosocial',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'param_name' => 'icon_material',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => 'material',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				// array(
				// 'type'       => 'woodmart_title_divider',
				// 'holder'     => 'div',
				// 'title'      => esc_html__( 'Icon', 'woodmart' ),
				// 'group'      => esc_html__( 'Icon', 'woodmart' ),
				// 'param_name' => 'style_icon_divider',
				// ),
					array(
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Icons color', 'woodmart' ),
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'param_name'       => 'marquee_icon_color',
						'css_args'         => array(
							'color' => array(
								' .wd-icon',
							),
						),
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => array( 'icon' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
				array(
					'heading'    => esc_html__( 'Icon size', 'woodmart' ),
					'group'      => esc_html__( 'Icon', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'icon_size',
					'selectors'  => array(
						'{{WRAPPER}} .wd-marquee .wd-icon' => array(
							'font-size: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'      => array(
						'px' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => array( 'icon' ),
					),
				),

				/**
				 * Design Options.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',

				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
			),
		);
	}
}
