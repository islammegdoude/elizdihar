<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Admin\Modules\Options;

Options::add_field(
	array(
		'id'          => 'carousel_arrows_position',
		'name'        => esc_html__( 'Position', 'woodmart' ),
		'group'       => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'general_carousel',
		'description' => esc_html__( 'Set the global position of carousel arrows, which can be inherited or overwritten by each element\'s carousel.', 'woodmart' ),
		'options'     => array(
			'sep'      => array(
				'name'    => esc_html__( 'Separate', 'woodmart' ),
				'value'   => 'sep',
				'onclick' => 'jQuery(".xts-nav-link[title=\'' . esc_html__( 'Arrows separate', 'woodmart' ) . '\']").parent().addClass("xts-default").siblings().removeClass("xts-default")',
				'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel-arrows-position-separate.mp4" autoplay loop muted></video>',
			),
			'together' => array(
				'name'    => esc_html__( 'Together', 'woodmart' ),
				'value'   => 'together',
				'onclick' => 'jQuery(".xts-nav-link[title=\'' . esc_html__( 'Arrows together', 'woodmart' ) . '\']").parent().addClass("xts-default").siblings().removeClass("xts-default")',
				'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel-arrows-position-together.mp4" autoplay loop muted></video>',
			),
		),
		'default'     => 'sep',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'carousel_arrows_icon_type',
		'name'     => esc_html__( 'Icon type', 'woodmart' ),
		'group'    => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'general_carousel',
		'options'  => array(
			'1' => array(
				'name'  => esc_html__( 'Style 1', 'woodmart' ),
				'value' => '1',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/arrows-style/style-1.jpg',
			),
			'2' => array(
				'name'  => esc_html__( 'Style 2', 'woodmart' ),
				'value' => '2',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/arrows-style/style-2.jpg',
			),
		),
		'default'  => '1',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'carousel_arrows_hover_style',
		'name'     => esc_html__( 'Hover style', 'woodmart' ),
		'group'    => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'general_carousel',
		'options'  => array(
			'disable' => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => 'disable',
			),
			'1'       => array(
				'name'  => esc_html__( 'Style 1', 'woodmart' ),
				'value' => '1',
				'hint'  => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel-arrows-hover-style-1.mp4" autoplay loop muted></video>',
			),
		),
		'default'  => '1',
		't_tab'    => array(
			'id'          => 'carousel_arrows_settings_tabs',
			'tab'         => esc_html__( 'Arrows separate', 'woodmart' ),
			'style'       => 'default',
			'extra_class' => 'sep' === woodmart_get_opt( 'carousel_arrows_position', 'sep' ) ? 'xts-default' : '',
		),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_sep_size',
		'name'          => esc_html__( 'Size', 'woodmart' ),
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_sep_size.mp4" autoplay loop muted></video>',
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-size: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'priority'      => 35,
		'class'         => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_sep_icon_size',
		'name'          => esc_html__( 'Icon size', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_sep_icon_size.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-icon-size: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'priority'      => 40,
		'class'         => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_sep_offset_h',
		'name'          => esc_html__( 'Offset horizontal', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_sep_offset_h.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-offset-h: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => -500,
				'max'  => 500,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'priority'      => 50,
		'class'         => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_sep_offset_v',
		'name'          => esc_html__( 'Offset vertical', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_sep_offset_v.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-offset-v: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => -500,
				'max'  => 500,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'priority'      => 50,
		'class'         => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_sep_color_group',
		'name'         => esc_html__( 'Color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'        => 'carousel_arrows_sep_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_arrows_sep_color_hover',
				'name'      => esc_html__( 'Hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_arrows_sep_color_dis',
				'name'      => esc_html__( 'Disabled', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 60,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_sep_bg_color_group',
		'name'         => esc_html__( 'Background color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'        => 'carousel_arrows_sep_bg_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_arrows_sep_bg_color_hover',
				'name'      => esc_html__( 'Hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_arrows_sep_bg_color_dis',
				'name'      => esc_html__( 'Disabled', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 70,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_sep_radius_group',
		'name'         => esc_html__( 'Border', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'style'        => 'dropdown',
		'btn_settings' => array(
			'label'   => esc_html__( 'Edit settings', 'woodmart' ),
			'classes' => 'xts-i-cog',
		),
		'css_rules'    => array(
			'with_all_value' => true,
		),
		'selectors'    => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-brd: {{CAROUSEL_ARROWS_SEP_BORDER_WIDTH}} {{CAROUSEL_ARROWS_SEP_BORDER_STYLE}};',
			),
		),
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'            => 'carousel_arrows_sep_border_radius',
				'name'          => esc_html__( 'Border radius', 'woodmart' ),
				'type'          => 'responsive_range',
				'selectors'     => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-radius: {{VALUE}}{{UNIT}};',
					),
				),
				'generate_zero' => true,
				'devices'       => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'         => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'priority'      => 10,
			),
			array(
				'id'       => 'carousel_arrows_sep_border_style',
				'name'     => esc_html__( 'Border style', 'woodmart' ),
				'type'     => 'select',
				'options'  => array(
					''       => array(
						'name'  => esc_html__( 'None', 'woodmart' ),
						'value' => '',
					),
					'solid'  => array(
						'name'  => esc_html__( 'Solid', 'woodmart' ),
						'value' => 'solid',
					),
					'dotted' => array(
						'name'  => esc_html__( 'Dotted', 'woodmart' ),
						'value' => 'dotted',
					),
					'double' => array(
						'name'  => esc_html__( 'Double', 'woodmart' ),
						'value' => 'double',
					),
					'dashed' => array(
						'name'  => esc_html__( 'Dashed', 'woodmart' ),
						'value' => 'dashed',
					),
					'groove' => array(
						'name'  => esc_html__( 'Groove', 'woodmart' ),
						'value' => 'groove',
					),
				),
				'default'  => '',
				'priority' => 20,
			),
			array(
				'id'       => 'carousel_arrows_sep_border_width',
				'name'     => esc_html__( 'Border width', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					),
				),
				'requires' => array(
					array(
						'key'     => 'carousel_arrows_sep_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'priority' => 30,
			),
			array(
				'id'        => 'carousel_arrows_sep_border_color',
				'name'      => esc_html__( 'Color', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_sep_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 40,
			),
			array(
				'id'        => 'carousel_arrows_sep_border_color_hover',
				'name'      => esc_html__( 'Color hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_sep_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 50,
			),
			array(
				'id'        => 'carousel_arrows_sep_border_color_dis',
				'name'      => esc_html__( 'Disabled color', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_sep_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 60,
			),
		),
		'class'        => 'xts-col-6',
		'priority'     => 120,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_sep_box_shadow_group',
		'name'         => esc_html__( 'Box shadow', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'style'        => 'dropdown',
		'btn_settings' => array(
			'label'   => esc_html__( 'Edit settings', 'woodmart' ),
			'classes' => 'xts-i-cog',
		),
		'selectors'    => array(
			'.wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-shadow: {{CAROUSEL_ARROWS_SEP_BOX_SHADOW_OFFSET_X}} {{CAROUSEL_ARROWS_SEP_BOX_SHADOW_OFFSET_Y}} {{CAROUSEL_ARROWS_SEP_BOX_SHADOW_BLUR}} {{CAROUSEL_ARROWS_SEP_BOX_SHADOW_SPREAD}} {{CAROUSEL_ARROWS_SEP_BOX_SHADOW_COLOR}};',
			),
		),
		'section'      => 'general_carousel',
		'inner_fields' => array(
			array(
				'id'       => 'carousel_arrows_sep_box_shadow_color',
				'name'     => esc_html__( 'Color', 'woodmart' ),
				'type'     => 'color',
				'default'  => array(),
				'priority' => 10,
			),
			array(
				'id'       => 'carousel_arrows_sep_box_shadow_offset_x',
				'name'     => esc_html__( 'Horizontal offset', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 20,
			),
			array(
				'id'       => 'carousel_arrows_sep_box_shadow_offset_y',
				'name'     => esc_html__( 'Vertical offset', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 30,
			),
			array(
				'id'       => 'carousel_arrows_sep_box_shadow_blur',
				'name'     => esc_html__( 'Blur', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 40,
			),
			array(
				'id'       => 'carousel_arrows_sep_box_shadow_spread',
				'name'     => esc_html__( 'Spread', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 50,
			),
		),
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows separate', 'woodmart' ),
		),
		'class'        => 'xts-col-6',
		'priority'     => 130,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_together_gap',
		'name'          => esc_html__( 'Gap', 'woodmart' ),
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-gap: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'          => 'carousel_arrows_settings_tabs',
			'tab'         => esc_html__( 'Arrows together', 'woodmart' ),
			'extra_class' => 'together' === woodmart_get_opt( 'carousel_arrows_position', 'sep' ) ? 'xts-default' : '',
		),
		'priority'      => 160,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_together_size',
		'name'          => esc_html__( 'Size', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_together_size.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-size: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'class'         => 'xts-col-6',
		'priority'      => 170,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_together_icon_size',
		'name'          => esc_html__( 'Icon size', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_together_icon_size.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-icon-size: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'class'         => 'xts-col-6',
		'priority'      => 180,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_together_offset_h',
		'name'          => esc_html__( 'Offset horizontal', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_together_offset_h.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-offset-h: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => -500,
				'max'  => 500,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'class'         => 'xts-col-6',
		'priority'      => 190,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_arrows_together_offset_v',
		'name'          => esc_html__( 'Offset vertical', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_arrows_together_offset_v.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-offset-v: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => -500,
				'max'  => 500,
				'step' => 1,
			),
		),
		't_tab'         => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'class'         => 'xts-col-6',
		'priority'      => 200,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_together_color_group',
		'name'         => esc_html__( 'Color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'        => 'carousel_arrows_together_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_arrows_together_color_hover',
				'name'      => esc_html__( 'Hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_arrows_together_color_dis',
				'name'      => esc_html__( 'Disabled', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-color-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 210,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_together_bg_color_group',
		'name'         => esc_html__( 'Background color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'        => 'carousel_arrows_together_bg_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_arrows_together_bg_color_hover',
				'name'      => esc_html__( 'Hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_arrows_together_bg_color_dis',
				'name'      => esc_html__( 'Disabled', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-bg-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 220,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_together_radius_group',
		'name'         => esc_html__( 'Border', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'style'        => 'dropdown',
		'btn_settings' => array(
			'label'   => esc_html__( 'Edit settings', 'woodmart' ),
			'classes' => 'xts-i-cog',
		),
		'css_rules'    => array(
			'with_all_value' => true,
		),
		'selectors'    => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-brd: {{CAROUSEL_ARROWS_TOGETHER_BORDER_WIDTH}} {{CAROUSEL_ARROWS_TOGETHER_BORDER_STYLE}};',
			),
		),
		'section'      => 'general_carousel',
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'inner_fields' => array(
			array(
				'id'            => 'carousel_arrows_together_border_radius',
				'name'          => esc_html__( 'Border radius', 'woodmart' ),
				'type'          => 'responsive_range',
				'selectors'     => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-radius: {{VALUE}}{{UNIT}};',
					),
				),
				'generate_zero' => true,
				'devices'       => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'         => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'priority'      => 10,
			),
			array(
				'id'       => 'carousel_arrows_together_border_style',
				'name'     => esc_html__( 'Border style', 'woodmart' ),
				'type'     => 'select',
				'options'  => array(
					''       => array(
						'name'  => esc_html__( 'None', 'woodmart' ),
						'value' => '',
					),
					'solid'  => array(
						'name'  => esc_html__( 'Solid', 'woodmart' ),
						'value' => 'solid',
					),
					'dotted' => array(
						'name'  => esc_html__( 'Dotted', 'woodmart' ),
						'value' => 'dotted',
					),
					'double' => array(
						'name'  => esc_html__( 'Double', 'woodmart' ),
						'value' => 'double',
					),
					'dashed' => array(
						'name'  => esc_html__( 'Dashed', 'woodmart' ),
						'value' => 'dashed',
					),
					'groove' => array(
						'name'  => esc_html__( 'Groove', 'woodmart' ),
						'value' => 'groove',
					),
				),
				'default'  => '',
				'priority' => 20,
			),
			array(
				'id'       => 'carousel_arrows_together_border_width',
				'name'     => esc_html__( 'Border width', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					),
				),
				'requires' => array(
					array(
						'key'     => 'carousel_arrows_together_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'priority' => 30,
			),
			array(
				'id'        => 'carousel_arrows_together_border_color',
				'name'      => esc_html__( 'Color', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_together_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 40,
			),
			array(
				'id'        => 'carousel_arrows_together_border_color_hover',
				'name'      => esc_html__( 'Color hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_together_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 50,
			),
			array(
				'id'        => 'carousel_arrows_together_border_color_dis',
				'name'      => esc_html__( 'Disabled color', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
						'--wd-arrow-brd-color-dis: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_arrows_together_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 60,
			),
		),
		'class'        => 'xts-col-6',
		'priority'     => 280,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_arrows_together_box_shadow_group',
		'name'         => esc_html__( 'Box shadow', 'woodmart' ),
		'group'        => esc_html__( 'Carousel arrow', 'woodmart' ),
		'type'         => 'group',
		'style'        => 'dropdown',
		'btn_settings' => array(
			'label'   => esc_html__( 'Edit settings', 'woodmart' ),
			'classes' => 'xts-i-cog',
		),
		'selectors'    => array(
			'.wd-nav-arrows.wd-pos-together:not(:where(.wd-custom-style))' => array(
				'--wd-arrow-shadow: {{CAROUSEL_ARROWS_TOGETHER_BOX_SHADOW_OFFSET_X}} {{CAROUSEL_ARROWS_TOGETHER_BOX_SHADOW_OFFSET_Y}} {{CAROUSEL_ARROWS_TOGETHER_BOX_SHADOW_BLUR}} {{CAROUSEL_ARROWS_TOGETHER_BOX_SHADOW_SPREAD}} {{CAROUSEL_ARROWS_TOGETHER_BOX_SHADOW_COLOR}};',
			),
		),
		'section'      => 'general_carousel',
		'inner_fields' => array(
			array(
				'id'       => 'carousel_arrows_together_box_shadow_color',
				'name'     => esc_html__( 'Color', 'woodmart' ),
				'type'     => 'color',
				'default'  => array(),
				'priority' => 10,
			),
			array(
				'id'       => 'carousel_arrows_together_box_shadow_offset_x',
				'name'     => esc_html__( 'Horizontal offset', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 20,
			),
			array(
				'id'       => 'carousel_arrows_together_box_shadow_offset_y',
				'name'     => esc_html__( 'Vertical offset', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 30,
			),
			array(
				'id'       => 'carousel_arrows_together_box_shadow_blur',
				'name'     => esc_html__( 'Blur', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 40,
			),
			array(
				'id'       => 'carousel_arrows_together_box_shadow_spread',
				'name'     => esc_html__( 'Spread', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority' => 50,
			),
		),
		't_tab'        => array(
			'id'  => 'carousel_arrows_settings_tabs',
			'tab' => esc_html__( 'Arrows together', 'woodmart' ),
		),
		'class'        => 'xts-col-6',
		'priority'     => 290,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_pagin_size',
		'name'          => esc_html__( 'Size', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_pagin_size.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel pagination', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
				'--wd-pagin-size: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		'priority'      => 310,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_pagin_bg_color_group',
		'name'         => esc_html__( 'Background color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel pagination', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		'inner_fields' => array(
			array(
				'id'        => 'carousel_pagin_bg_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-bg: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_pagin_bg_color_hover',
				'name'      => esc_html__( 'Hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-bg-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_pagin_bg_color_active',
				'name'      => esc_html__( 'Active', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-bg-act: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 320,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_pagin_radius_group',
		'name'         => esc_html__( 'Border', 'woodmart' ),
		'group'        => esc_html__( 'Carousel pagination', 'woodmart' ),
		'type'         => 'group',
		'style'        => 'dropdown',
		'btn_settings' => array(
			'label'   => esc_html__( 'Edit settings', 'woodmart' ),
			'classes' => 'xts-i-cog',
		),
		'css_rules'    => array(
			'with_all_value' => true,
		),
		'selectors'    => array(
			'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
				'--wd-pagin-brd: {{CAROUSEL_PAGIN_BORDER_WIDTH}} {{CAROUSEL_PAGIN_BORDER_STYLE}};',
			),
		),
		'section'      => 'general_carousel',
		'inner_fields' => array(
			array(
				'id'            => 'carousel_pagin_border_radius',
				'name'          => esc_html__( 'Border radius', 'woodmart' ),
				'type'          => 'responsive_range',
				'selectors'     => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-radius: {{VALUE}}{{UNIT}};',
					),
				),
				'generate_zero' => true,
				'devices'       => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'         => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'priority'      => 10,
			),
			array(
				'id'       => 'carousel_pagin_border_style',
				'name'     => esc_html__( 'Border style', 'woodmart' ),
				'type'     => 'select',
				'options'  => array(
					''       => array(
						'name'  => esc_html__( 'None', 'woodmart' ),
						'value' => '',
					),
					'solid'  => array(
						'name'  => esc_html__( 'Solid', 'woodmart' ),
						'value' => 'solid',
					),
					'dotted' => array(
						'name'  => esc_html__( 'Dotted', 'woodmart' ),
						'value' => 'dotted',
					),
					'double' => array(
						'name'  => esc_html__( 'Double', 'woodmart' ),
						'value' => 'double',
					),
					'dashed' => array(
						'name'  => esc_html__( 'Dashed', 'woodmart' ),
						'value' => 'dashed',
					),
					'groove' => array(
						'name'  => esc_html__( 'Groove', 'woodmart' ),
						'value' => 'groove',
					),
				),
				'default'  => '',
				'priority' => 20,
			),
			array(
				'id'       => 'carousel_pagin_border_width',
				'name'     => esc_html__( 'Border width', 'woodmart' ),
				'type'     => 'responsive_range',
				'devices'  => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'    => array(
					'px' => array(
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					),
				),
				'requires' => array(
					array(
						'key'     => 'carousel_pagin_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'priority' => 30,
			),
			array(
				'id'        => 'carousel_pagin_border_color',
				'name'      => esc_html__( 'Color', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-brd-color: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_pagin_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 40,
			),
			array(
				'id'        => 'carousel_pagin_border_color_hover',
				'name'      => esc_html__( 'Color hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-brd-color-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_pagin_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 50,
			),
			array(
				'id'        => 'carousel_pagin_border_color_active',
				'name'      => esc_html__( 'Color active', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-pagin-wrap:not(.wd-custom-style)' => array(
						'--wd-pagin-brd-color-act: {{VALUE}};',
					),
				),
				'default'   => array(),
				'requires'  => array(
					array(
						'key'     => 'carousel_pagin_border_style',
						'compare' => 'not_equals',
						'value'   => '',
					),
				),
				'class'     => 'xts-col-4',
				'priority'  => 60,
			),
		),
		'class'        => 'xts-col-6',
		'priority'     => 350,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_scrollbar_height',
		'name'          => esc_html__( 'Scrollbar height', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_scrollbar_height.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel scrollbar', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-scroll' => array(
				'--wd-nscroll-height: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => 'px',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		'class'         => 'xts-col-6',
		'priority'      => 410,
	)
);

Options::add_field(
	array(
		'id'            => 'carousel_scrollbar_width',
		'name'          => esc_html__( 'Scrollbar width', 'woodmart' ),
		'hint'    => '<video data-src="' . WOODMART_TOOLTIP_URL . 'carousel_scrollbar_width.mp4" autoplay loop muted></video>',
		'group'         => esc_html__( 'Carousel scrollbar', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'general_carousel',
		'selectors'     => array(
			'.wd-nav-scroll' => array(
				'--wd-nscroll-width: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
			'desktop' => array(
				'value' => '',
				'unit'  => '%',
			),
			'tablet'  => array(
				'value' => '',
				'unit'  => '%',
			),
			'mobile'  => array(
				'value' => '',
				'unit'  => '%',
			),
		),
		'range'         => array(
			'%' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		'class'         => 'xts-col-6',
		'priority'      => 420,
	)
);

Options::add_field(
	array(
		'id'           => 'carousel_scrollbar_bg_color_group',
		'name'         => esc_html__( 'Background color', 'woodmart' ),
		'group'        => esc_html__( 'Carousel scrollbar', 'woodmart' ),
		'type'         => 'group',
		'section'      => 'general_carousel',
		'inner_fields' => array(
			array(
				'id'        => 'carousel_scrollbar_bg_color',
				'name'      => esc_html__( 'Regular', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-scroll' => array(
						'--wd-nscroll-bg: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 10,
			),
			array(
				'id'        => 'carousel_scrollbar_drag_bg_color',
				'name'      => esc_html__( 'Dragging', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-scroll' => array(
						'--wd-nscroll-drag-bg: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 20,
			),
			array(
				'id'        => 'carousel_scrollbar_drag_bg_hover_color',
				'name'      => esc_html__( 'Dragging hover', 'woodmart' ),
				'type'      => 'color',
				'selectors' => array(
					'.wd-nav-scroll' => array(
						'--wd-nscroll-drag-bg-hover: {{VALUE}};',
					),
				),
				'default'   => array(),
				'priority'  => 30,
			),
		),
		'priority'     => 430,
	)
);
