<?php
/**
 * Sold counter map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_sold_counter' ) ) {
	/**
	 * Sold counter map.
	 */
	function woodmart_get_vc_map_single_product_sold_counter() {
		$sold_counter_typography = woodmart_get_typography_map(
			array(
				'key'      => 'typography',
				'selector' => '{{WRAPPER}}.wd-sold-count',
				'group'    => esc_html__( 'Style', 'woodmart' ),
			)
		);

		return array(
			'base'        => 'woodmart_single_product_sold_counter',
			'name'        => esc_html__( 'Product sold counter', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Show the number of sales for the last period.', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-sold-counter.svg',
			'params'      => array(
				array(
					'group'      => esc_html__( 'Style', 'js_composer' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'param_name'       => 'style',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Default', 'woodmart' )         => 'default',
						esc_html__( 'With background', 'woodmart' ) => 'with-bg',
					),
					'std'              => 'default',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Text settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Text', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'title_divider_text',
				),
				$sold_counter_typography['font_family'],
				$sold_counter_typography['font_size'],
				$sold_counter_typography['font_weight'],
				$sold_counter_typography['text_transform'],
				$sold_counter_typography['font_style'],
				$sold_counter_typography['line_height'],
				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'text_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-count-number, {{WRAPPER}} .wd-count-msg' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Icon settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'title_divider_icon',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon type', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_type',
					'value'            => array(
						esc_html__( 'Default icon', 'woodmart' ) => 'default',
						esc_html__( 'Custom icon', 'woodmart' ) => 'icon',
						esc_html__( 'Custom image', 'woodmart' ) => 'image',
					),
					'std'              => 'default',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon library', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_library',
					'value'            => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
						esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
						esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
						esc_html__( 'Material', 'woodmart' ) => 'material',
					),
					'hint'             => esc_html__( 'Select icon library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'icon',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_fontawesome',
					'value'            => 'far fa-bell',
					'settings'         => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'fontawesome',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_openiconic',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'openiconic',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_typicons',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'typicons',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_entypo',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'entypo',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_linecons',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'linecons',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_monosocial',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'monosocial',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_material',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'material',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'heading'    => esc_html__( 'Icon size', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'icon_size',
					'selectors'  => array(
						'{{WRAPPER}} .wd-count-icon' => array(
							'font-size: {{VALUE}}px;',
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
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					),
					'dependency' => array(
						'element'            => 'icon_type',
						'value_not_equal_to' => 'image',
					),
				),
				array(
					'heading'          => esc_html__( 'Icon color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'icon_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-count-icon' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element'            => 'icon_type',
						'value_not_equal_to' => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
				// Width option (with dependency Columns option, responsive).
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
