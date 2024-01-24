<?php

if ( ! function_exists( 'woodmart_get_vc_carousel_map' ) ) {
	/**
	 * Get animation map settings for VC.
	 */
	function woodmart_get_vc_carousel_map() {
		$settings = array(
			'woodmart_products'          => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'layout',
					'value'   => array( 'carousel' ),
				),
			),
			'products_tab'               => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'layout',
					'value'   => array( 'carousel' ),
				),
			),
			'woodmart_blog'              => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'blog_design',
					'value'   => array( 'carousel' ),
				),
			),
			'woodmart_gallery'           => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'view',
					'value'   => array( 'carousel' ),
				),
			),
			'woodmart_instagram'         => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slides_per_view_tabs', 'slides_per_view', 'slides_per_view_tablet', 'slides_per_view_mobile', 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'design',
					'value'   => array( 'slider' ),
				),
			),
			'woodmart_categories'        => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'style',
					'value'   => array( 'carousel' ),
				),
			),
			'testimonials'               => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'layout',
					'value'   => array( 'slider' ),
				),
			),
			'woodmart_brands'            => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slides_per_view_tabs', 'slides_per_view', 'slides_per_view_tablet', 'slides_per_view_mobile', 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'style',
					'value'   => array( 'carousel' ),
				),
			),
			'woodmart_nested_carousel'   => array(
				'group' => esc_html__( 'Style', 'woodmart' ),
			),
			'banners_carousel'           => array(),
			'woodmart_info_box_carousel' => array(),
			'woodmart_portfolio'         => array(
				'group'      => esc_html__( 'Carousel', 'woodmart' ),
				'exclude'    => array( 'slider_spacing_tabs', 'slider_spacing', 'slider_spacing_tablet', 'slider_spacing_mobile' ),
				'dependency' => array(
					'element' => 'layout',
					'value'   => array( 'carousel' ),
				),
			),
		);

		$fields = array(
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Slides per view', 'woodmart' ),
				'hint'             => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'woodmart' ),
				'param_name'       => 'slides_per_view_tabs',
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_slider',
				'param_name'       => 'slides_per_view',
				'min'              => '1',
				'max'              => '8',
				'step'             => '0.5',
				'default'          => '3',
				'units'            => 'col',
				'wd_dependency'    => array(
					'element' => 'slides_per_view_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_slider',
				'param_name'       => 'slides_per_view_tablet',
				'min'              => '1',
				'max'              => '8',
				'step'             => '0.5',
				'default'          => '',
				'units'            => 'col',
				'wd_dependency'    => array(
					'element' => 'slides_per_view_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_slider',
				'param_name'       => 'slides_per_view_mobile',
				'min'              => '1',
				'max'              => '8',
				'step'             => '0.5',
				'default'          => 'auto',
				'units'            => 'col',
				'wd_dependency'    => array(
					'element' => 'slides_per_view_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),

			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Slider spacing', 'woodmart' ),
				'hint'             => esc_html__( 'Set the interval numbers that you want to display between slider items.', 'woodmart' ),
				'param_name'       => 'slider_spacing_tabs',
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'slider_spacing',
				'value'            => array(
					30,
					20,
					10,
					6,
					2,
					0,
				),
				'wd_dependency'    => array(
					'element' => 'slider_spacing_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'slider_spacing_tablet',
				'value'            => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					'30'                                => '30',
					'20'                                => '20',
					'10'                                => '10',
					'6'                                 => '6',
					'2'                                 => '2',
					'0'                                 => '0',
				),
				'std'              => '',
				'wd_dependency'    => array(
					'element' => 'slider_spacing_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'slider_spacing_mobile',
				'value'            => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					'30'                                => '30',
					'20'                                => '20',
					'10'                                => '10',
					'6'                                 => '6',
					'2'                                 => '2',
					'0'                                 => '0',
				),
				'std'              => '',
				'wd_dependency'    => array(
					'element' => 'slider_spacing_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),

			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Scroll per page', 'woodmart' ),
				'param_name'       => 'scroll_per_page',
				'hint'             => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'std'              => 'yes',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Center mode', 'woodmart' ),
				'param_name'       => 'center_mode',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'wd_dependency'    => array(
					'element' => 'scroll_per_page',
					'value'   => array( 'no' ),
				),
			),
			array(
				'type'       => 'woodmart_empty_space',
				'param_name' => 'woodmart_empty_space',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Slider loop', 'woodmart' ),
				'param_name'       => 'wrap',
				'hint'             => esc_html__( 'Enables loop mode.', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Auto height', 'woodmart' ),
				'param_name'       => 'autoheight',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Slider autoplay', 'woodmart' ),
				'param_name'       => 'autoplay',
				'hint'             => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Slider speed', 'woodmart' ),
				'param_name'       => 'speed',
				'value'            => '5000',
				'hint'             => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
				'wd_dependency'    => array(
					'element' => 'autoplay',
					'value'   => 'yes',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Init carousel on scroll', 'woodmart' ),
				'hint'             => esc_html__( 'This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.', 'woodmart' ),
				'param_name'       => 'scroll_carousel_init',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Disabled overflow', 'woodmart' ),
				'param_name'       => 'disable_overflow_carousel',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'       => 'woodmart_empty_space',
				'param_name' => 'woodmart_empty_space',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
				'param_name'       => 'hide_prev_next_buttons',
				'hint'             => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Carousel arrow position', 'woodmart' ),
				'param_name'       => 'carousel_arrows_position',
				'value'            => array(
					esc_html__( 'Inherit from Theme Settings', 'woodmart' ) => '',
					esc_html__( 'Separate', 'woodmart' ) => 'sep',
					esc_html__( 'Together', 'woodmart' ) => 'together',
				),
				'wd_dependency'    => array(
					'element' => 'hide_prev_next_buttons',
					'value'   => array( 'no' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'wd_slider',
				'param_name'       => 'carousel_arrows_offset_h',
				'heading'          => esc_html__( 'Arrow offset horizontal', 'woodmart' ),
				'devices'          => array(
					'desktop'         => array(
						'unit'  => 'px',
						'value' => '',
					),
					'tablet_vertical' => array(
						'unit'  => 'px',
						'value' => '',
					),
					'mobile'          => array(
						'unit'  => 'px',
						'value' => '',
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => -500,
						'max'  => 500,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}} .wd-nav-arrows' => array(
						'--wd-arrow-offset-h: {{VALUE}}{{UNIT}};',
					),
				),
				'generate_zero'    => true,
				'wd_dependency'    => array(
					'element' => 'hide_prev_next_buttons',
					'value'   => array( 'no' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'wd_slider',
				'param_name'       => 'carousel_arrows_offset_v',
				'heading'          => esc_html__( 'Arrow offset vertical', 'woodmart' ),
				'devices'          => array(
					'desktop'         => array(
						'unit'  => 'px',
						'value' => '',
					),
					'tablet_vertical' => array(
						'unit'  => 'px',
						'value' => '',
					),
					'mobile'          => array(
						'unit'  => 'px',
						'value' => '',
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => -500,
						'max'  => 500,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}} .wd-nav-arrows' => array(
						'--wd-arrow-offset-v: {{VALUE}}{{UNIT}};',
					),
				),
				'generate_zero'    => true,
				'wd_dependency'    => array(
					'element' => 'hide_prev_next_buttons',
					'value'   => array( 'no' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide pagination control', 'woodmart' ),
				'param_name'       => 'hide_pagination_control_tabs',
				'hint'             => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_pagination_control',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'wd_dependency'    => array(
					'element' => 'hide_pagination_control_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_pagination_control_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'yes',
				'wd_dependency'    => array(
					'element' => 'hide_pagination_control_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_pagination_control_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'yes',
				'wd_dependency'    => array(
					'element' => 'hide_pagination_control_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'        => 'woodmart_switch',
				'heading'     => esc_html__( 'Dynamic pagination control', 'woodmart' ),
				'param_name'  => 'dynamic_pagination_control',
				'true_state'  => 'yes',
				'false_state' => 'no',
				'default'     => 'no',
			),

			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide scrollbar', 'woodmart' ),
				'param_name'       => 'hide_scrollbar_tabs',
				'hint'             => esc_html__( 'If "YES" scrollbar will be removed', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_scrollbar',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'yes',
				'wd_dependency'    => array(
					'element' => 'hide_scrollbar_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_scrollbar_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'yes',
				'wd_dependency'    => array(
					'element' => 'hide_scrollbar_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'hide_scrollbar_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'yes',
				'wd_dependency'    => array(
					'element' => 'hide_scrollbar_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
			),

			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Synchronization', 'woodmart' ),
				'param_name'       => 'carousel_sync',
				'value'            => array(
					esc_html__( 'Disabled', 'woodmart' )  => '',
					esc_html__( 'As parent', 'woodmart' ) => 'parent',
					esc_html__( 'As child', 'woodmart' )  => 'child',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'ID', 'woodmart' ),
				'param_name'       => 'sync_parent_id',
				'std'              => 'wd_' . uniqid(),
				'save_always'      => true,
				'wd_dependency'    => array(
					'element' => 'carousel_sync',
					'value'   => array( 'parent' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'ID', 'woodmart' ),
				'param_name'       => 'sync_child_id',
				'wd_dependency'    => array(
					'element' => 'carousel_sync',
					'value'   => array( 'child' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
		);

		foreach ( $settings as $element_key => $setting ) {
			$element_fields = $fields;

			foreach ( $element_fields as $key => $field ) {
				if ( isset( $setting['exclude'], $field['param_name'] ) && in_array( $field['param_name'], $setting['exclude'], true ) ) {
					unset( $element_fields[ $key ] );

					continue;
				}

				if ( isset( $setting['dependency'] ) ) {
					$element_fields[ $key ]['dependency'] = $setting['dependency'];
				}

				if ( isset( $setting['group'] ) ) {
					$element_fields[ $key ]['group'] = $setting['group'];
				}
			}

			vc_add_params( $element_key, $element_fields );
		}
	}

	add_action( 'vc_before_mapping', 'woodmart_get_vc_carousel_map' );
}

if ( ! function_exists( 'woodmart_get_vc_animation_map' ) ) {
	/**
	 * Get animation map settings for VC.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array
	 */
	function woodmart_get_vc_animation_map( $key ) {
		$map = array(
			'wd_animation'          => array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Theme Animation', 'woodmart' ),
				'hint'             => esc_html__( 'Use custom theme animations if you want to run them in the slider element.' ),
				'param_name'       => 'wd_animation',
				'admin_label'      => true,
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Slide from top', 'woodmart' ) => 'slide-from-top',
					esc_html__( 'Slide from bottom', 'woodmart' ) => 'slide-from-bottom',
					esc_html__( 'Slide from left', 'woodmart' ) => 'slide-from-left',
					esc_html__( 'Slide from right', 'woodmart' ) => 'slide-from-right',
					esc_html__( 'Slide short from left', 'woodmart' ) => 'slide-short-from-left',
					esc_html__( 'Slide short from right', 'woodmart' ) => 'slide-short-from-right',
					esc_html__( 'Flip X bottom', 'woodmart' ) => 'bottom-flip-x',
					esc_html__( 'Flip X top', 'woodmart' ) => 'top-flip-x',
					esc_html__( 'Flip Y left', 'woodmart' ) => 'left-flip-y',
					esc_html__( 'Flip Y right', 'woodmart' ) => 'right-flip-y',
					esc_html__( 'Zoom in', 'woodmart' )    => 'zoom-in',
				),
				'std'              => '',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'wd_animation_delay'    => array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Theme Animation Delay (ms)', 'woodmart' ),
				'param_name'       => 'wd_animation_delay',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element'            => 'wd_animation',
					'value_not_equal_to' => array( '' ),
				),
			),
			'wd_animation_duration' => array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Theme Animation duration', 'woodmart' ),
				'param_name'       => 'wd_animation_duration',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'value'            => array(
					esc_html__( 'Slow', 'woodmart' )   => 'slow',
					esc_html__( 'Normal', 'woodmart' ) => 'normal',
					esc_html__( 'Fast', 'woodmart' )   => 'fast',
				),
				'dependency'       => array(
					'element'            => 'wd_animation',
					'value_not_equal_to' => array( '' ),
				),
				'std'              => 'normal',
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_responsive_reset_margin_map' ) ) {
	/**
	 * Get mobile reset option map.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array map.
	 */
	function woodmart_get_responsive_reset_margin_map( $key ) {
		$map = array(
			/**
			 * Responsive Options.
			 */
			'responsive_tabs_reset' => array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Reset margin (deprecated)', 'woodmart' ),
				'param_name'       => 'responsive_tabs_reset',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			'mobile_reset_margin'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'mobile_reset_margin',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_reset',
					'value'   => array( 'mobile' ),
				),
			),
			'tablet_reset_margin'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'tablet_reset_margin',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_reset',
					'value'   => array( 'tablet' ),
				),
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ) {
	/**
	 * Get responsive spacing option map.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_responsive_spacing_map() {
		return array(
			'type'       => 'woodmart_responsive_spacing',
			'param_name' => 'responsive_spacing',
			'group'      => esc_html__( 'Design Options', 'js_composer' ),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_responsive_visible_map' ) ) {
	/**
	 * Get responsive visible option map.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_responsive_visible_map( $key ) {
		$map = array(
			/**
			 * Responsive Options.
			 */
			'responsive_tabs_hide' => array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide element', 'woodmart' ),
				'param_name'       => 'responsive_tabs_hide',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			'wd_hide_on_desktop'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_desktop',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'desktop' ),
				),
			),
			'wd_hide_on_tablet'    => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_tablet',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'tablet' ),
				),
			),
			'wd_hide_on_mobile'    => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_mobile',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'mobile' ),
				),
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_vc_display_inline_map' ) ) {
	/**
	 * Get display inline option map.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_display_inline_map() {
		return array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Display inline', 'woodmart' ),
			'param_name'       => 'woodmart_inline',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);
	}
}

if ( ! function_exists( 'woodmart_contact_form_7_custom_options' ) ) {
	/**
	 * Update custom params map to Default Contact Form 7 element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_contact_form_7_custom_options() {
		$params = array(
			array(
				'type'       => 'woodmart_title_divider',
				'holder'     => 'div',
				'title'      => esc_html__( 'Style', 'woodmart' ),
				'param_name' => 'style_divider',
			),

			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Color presets', 'woodmart' ),
				'param_name' => 'html_class',
				'value'      => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'With background', 'woodmart' ) => 'wd-style-with-bg',
				),
				'std'        => '',
			),

			array(
				'type'       => 'woodmart_title_divider',
				'holder'     => 'div',
				'title'      => esc_html__( 'Form', 'woodmart' ),
				'param_name' => 'form_divider',
				'dependency' => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
			),

			array(
				'heading'          => esc_html__( 'Text color', 'woodmart' ),
				'type'             => 'wd_colorpicker',
				'param_name'       => 'form_color',
				'selectors'        => array(
					'form.wpcf7-form' => array(
						'--wd-form-color: {{VALUE}};',
					),
				),
				'dependency'       => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'heading'          => esc_html__( 'Placeholder color', 'woodmart' ),
				'type'             => 'wd_colorpicker',
				'param_name'       => 'form_placeholder_color',
				'selectors'        => array(
					'form.wpcf7-form' => array(
						'--wd-form-placeholder-color: {{VALUE}};',
					),
				),
				'dependency'       => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'heading'          => esc_html__( 'Border color', 'woodmart' ),
				'type'             => 'wd_colorpicker',
				'param_name'       => 'form_brd_color',
				'selectors'        => array(
					'form.wpcf7-form' => array(
						'--wd-form-brd-color: {{VALUE}};',
					),
				),
				'dependency'       => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'heading'          => esc_html__( 'Border color focus', 'woodmart' ),
				'type'             => 'wd_colorpicker',
				'param_name'       => 'form_brd_color_focus',
				'selectors'        => array(
					'form.wpcf7-form' => array(
						'--wd-form-brd-color-focus: {{VALUE}};',
					),
				),
				'dependency'       => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'heading'          => esc_html__( 'Background color', 'woodmart' ),
				'type'             => 'wd_colorpicker',
				'param_name'       => 'form_bg',
				'selectors'        => array(
					'form.wpcf7-form' => array(
						'--wd-form-bg: {{VALUE}};',
					),
				),
				'dependency'       => array(
					'element'            => 'html_class',
					'value_not_equal_to' => 'wd-style-with-bg',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
		);

		vc_add_params( 'contact-form-7', $params );
	}

	add_action( 'vc_before_init', 'woodmart_contact_form_7_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_column_custom_options' ) ) {
	/**
	 * Update custom params map to Default Column element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_column_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
			/**
			 * Color Scheme Param.
			 */
			array(
				'type'       => 'woodmart_button_set',
				'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
				'param_name' => 'woodmart_color_scheme',
				'value'      => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					esc_html__( 'Light', 'woodmart' )   => 'light',
					esc_html__( 'Dark', 'woodmart' )    => 'dark',
				),
			),
			/**
			 * Parallax On Scroll Option.
			 */
			woodmart_parallax_scroll_map( 'parallax_scroll' ),
			woodmart_parallax_scroll_map( 'scroll_x' ),
			woodmart_parallax_scroll_map( 'scroll_y' ),
			woodmart_parallax_scroll_map( 'scroll_z' ),
			woodmart_parallax_scroll_map( 'scroll_smooth' ),
			/**
			 * Enable sticky column Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Enable sticky column', 'woodmart' ),
				'description'      => esc_html__( 'Also enable equal columns height for the parent row to make it work', 'woodmart' ),
				'param_name'       => 'woodmart_sticky_column',
				'true_state'       => 'true',
				'false_state'      => 'false',
				'default'          => 'false',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( '' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Sticky column offset', 'woodmart' ),
				'param_name'       => 'woodmart_sticky_column_offset',
				'dependency'       => array(
					'element' => 'woodmart_sticky_column',
					'value'   => array( 'true' ),
				),
				'value'            => 150,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Text align Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Text align', 'woodmart' ),
				'param_name'       => 'woodmart_text_align',
				'value'            => array(
					esc_html__( 'Choose', 'woodmart' ) => '',
					esc_html__( 'Left', 'woodmart' )   => 'left',
					esc_html__( 'Center', 'woodmart' ) => 'center',
					esc_html__( 'Right', 'woodmart' )  => 'right',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Collapsible content Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Collapsible content', 'woodmart' ),
				'hint'             => esc_html__( 'Limit the column height and add the "Read more" button. IMPORTANT: you need to add our "Button" element to the end of this column and enable an appropriate option there as well.', 'woodmart' ),
				'param_name'       => 'wd_collapsible_content_switcher',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( '' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_slider',
				'param_name'       => 'wd_collapsible_content_max_height',
				'heading'          => esc_html__( 'Column content height', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 300,
					),
					'tablet'  => array(
						'unit'  => 'px',
						'value' => 200,
					),
					'mobile'  => array(
						'unit'  => 'px',
						'value' => 100,
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => 1,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}}.wd-collapsible-content > .vc_column-inner' => array(
						'max-height: {{VALUE}}{{UNIT}};',
					),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'wd_collapsible_content_switcher',
					'value'   => array( 'yes' ),
				),
			),
			array(
				'type'       => 'wd_colorpicker',
				'param_name' => 'wd_collapsible_content_fade_out_color',
				'heading'    => esc_html__( 'Fade out color', 'woodmart' ),
				'selectors'  => array(
					'{{WRAPPER}}.wd-collapsible-content:not(.wd-opened) > .vc_column-inner > .wpb_wrapper:after' => array(
						'color: {{VALUE}};',
					),
				),
				'default'    => array(
					'value' => '#fff',
				),
				'dependency' => array(
					'element' => 'wd_collapsible_content_switcher',
					'value'   => array( 'yes' ),
				),
			),
			/** Vertical Alignment */
			array(
				'type'             => 'wd_select',
				'heading'          => esc_html__( 'Vertical alignment', 'woodmart' ),
				'param_name'       => 'vertical_alignment',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner > .wpb_wrapper' => array(
						'align-items: {{VALUE}};',
					),
				),
				'devices'          => array(
					'desktop' => array(
						'value' => '',
					),
					'tablet'  => array(
						'value' => '',
					),
					'mobile'  => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Top', 'woodmart' )     => 'flex-start',
					esc_html__( 'Middle', 'woodmart' )  => 'center',
					esc_html__( 'Bottom', 'woodmart' )  => 'flex-end',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/** Horizontal Alignment */
			array(
				'type'             => 'wd_select',
				'heading'          => esc_html__( 'Horizontal alignment', 'woodmart' ),
				'param_name'       => 'horizontal_alignment',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner > .wpb_wrapper' => array(
						'justify-content: {{VALUE}}',
					),
				),
				'devices'          => array(
					'desktop' => array(
						'value' => '',
					),
					'tablet'  => array(
						'value' => '',
					),
					'mobile'  => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Start', 'woodmart' )   => 'flex-start',
					esc_html__( 'Center', 'woodmart' )  => 'center',
					esc_html__( 'End', 'woodmart' )     => 'flex-end',
					esc_html__( 'Space Between', 'woodmart' ) => 'space-between',
					esc_html__( 'Space Around', 'woodmart' ) => 'space-around',
					esc_html__( 'Space Evenly', 'woodmart' ) => 'space-evenly',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/** Off canvas column */
			array(
				'type'             => 'dropdown',
				'heading'          => __( 'Column role for "off-canvas layout"', 'woodmart' ),
				'description'      => esc_html__( 'You can create your page layout with an off-canvas sidebar. In this case, you need to have two columns: one will be set as the off-canvas sidebar and another as the content. NOTE: you need to also display the Off-canvas button element somewhere in your content column to open the sidebar. Also, you need to enable them on specific devices synchronously.', 'woodmart' ),
				'param_name'       => 'wd_column_role',
				'value'            => array(
					esc_html__( 'None', 'woodmart' ) => '',
					esc_html__( 'Off canvas column', 'woodmart' ) => 'offcanvas',
					esc_html__( 'Content column', 'woodmart' ) => 'content',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Desktop', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_desktop',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Tablet', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Mobile', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Desktop', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_desktop',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Tablet', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Mobile', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Off canvas alignment', 'woodmart' ),
				'param_name'       => 'wd_off_canvas_alignment',
				'value'            => array(
					esc_html__( 'Left', 'woodmart' )  => 'left',
					esc_html__( 'Right', 'woodmart' ) => 'right',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
		);

		$design_option = array(
			/**
			 * Background Position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Hide bg img on mobile.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Hide bg img on tablet.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Box Shadow Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'param_name'       => 'woodmart_box_shadow',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_box_shadow',
				'param_name'       => 'wd_box_shadow',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner' => array(
						'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
					),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'woodmart_box_shadow',
					'value'   => array( 'yes' ),
				),
				'default'          => array(
					'horizontal' => '0',
					'vertical'   => '0',
					'blur'       => '9',
					'spread'     => '0',
					'color'      => 'rgba(0, 0, 0, .15)',
				),
			),
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
		);

		$responsive_options = array(
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Reset margin (deprecated)', 'woodmart' ),
				'param_name'       => 'responsive_tabs_advanced',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Reset margin (deprecated) on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'mobile_reset_margin',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Reset margin (deprecated) on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'tablet_reset_margin',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'tablet' ),
				),
			),
		);

		$advanced_options = array(
			/**
			 * Z Index.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		vc_add_params( 'vc_column', $general_options );
		vc_add_params( 'vc_column', $design_option );
		vc_add_params( 'vc_column', $responsive_options );
		vc_add_params( 'vc_column', $advanced_options );

		vc_add_params( 'vc_column_inner', $general_options );
		vc_add_params( 'vc_column_inner', $design_option );
		vc_add_params( 'vc_column_inner', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_column_custom_options' );

}

if ( ! function_exists( 'woodmart_vc_section_custom_options' ) ) {
	/**
	 * Update custom params map to Default Section element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_section_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Section stretch CSS', 'woodmart' ),
				'param_name'  => 'woodmart_stretch_content',
				'value'       => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Stretch section', 'woodmart' ) => 'section-stretch',
					esc_html__( 'Stretch section and content', 'woodmart' ) => 'section-stretch-content',
				),
				'description' => esc_html__( 'Enable this option instead of native WPBakery one to stretch section with CSS and not with JS.', 'woodmart' ),
			),
		);

		$design_options = array(
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
			/**
			 * Background position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Disable background image on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Disable background image on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		$advanced_options = array(
			/**
			 * Z Index Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Disable Overflow Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
				'hint'             => esc_html__( 'Use this option if you have some elements inside this row that needs to overflow the boundaries. Examples: mega menu, filters, search with categories dropdowns.', 'woodmart' ),
				'param_name'       => 'woodmart_disable_overflow',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),

		);

		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$design_options[] = array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background gradient', 'woodmart' ),
				'param_name'       => 'woodmart_gradient_switch',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			);

			$design_options[] = array(
				'type'       => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value'   => array( 'yes' ),
				),
			);
		}

		/**
		 * Box Shadow Option.
		 */
		$design_options[] = array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'param_name'       => 'woodmart_box_shadow',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);
		$design_options[] = array(
			'type'             => 'wd_box_shadow',
			'param_name'       => 'wd_box_shadow',
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'selectors'        => array(
				'{{WRAPPER}}' => array(
					'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				),
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'dependency'       => array(
				'element' => 'woodmart_box_shadow',
				'value'   => array( 'yes' ),
			),
			'default'          => array(
				'horizontal' => '0',
				'vertical'   => '0',
				'blur'       => '9',
				'spread'     => '0',
				'color'      => 'rgba(0, 0, 0, .15)',
			),
		);

		vc_add_params( 'vc_section', $general_options );
		vc_add_params( 'vc_section', $design_options );
		vc_add_params( 'vc_section', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_section_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_empty_space_custom_options' ) ) {
	/**
	 * Update custom params map to Default Empty Space element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_empty_space_custom_options() {
		$advanced_options = array(
			/**
			 * Hide empty space Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide empty space', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Large', 'woodmart' )  => 'large',
					esc_html__( 'Medium', 'woodmart' ) => 'medium',
					esc_html__( 'Small', 'woodmart' )  => 'small',
				),
				'default'          => 'large',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Hide on large.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_large',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'large' ),
				),
			),
			/**
			 * Hide on medium.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_medium',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'medium' ),
				),
			),
			/**
			 * Hide on small.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_small',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'small' ),
				),
			),
		);

		vc_add_params( 'vc_empty_space', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_empty_space_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_row_custom_options' ) ) {
	/**
	 * Update custom params map to Default Row element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_row_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Row stretch CSS', 'woodmart' ),
				'param_name'  => 'woodmart_stretch_content',
				'value'       => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Stretch row', 'woodmart' ) => 'section-stretch',
					esc_html__( 'Stretch row and content', 'woodmart' ) => 'section-stretch-content',
					esc_html__( 'Stretch row and content (no paddings)', 'woodmart' ) => 'section-stretch-content-no-pd',
				),
				'description' => esc_html__( 'Enable this option instead of native WPBakery one to stretch row with CSS and not with JS.', 'woodmart' ),
			),
		);

		$general_options_inner = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
		);

		$design_options = array(
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
			/**
			 * Background Position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Disable background image on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Disable background image on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		$advanced_options = array(
			/**
			 * Z Index Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Disable overflow.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
				'hint'             => esc_html__( 'Use this option if you have some elements inside this row that needs to overflow the boundaries. Examples: mega menu, filters, search with categories dropdowns.', 'woodmart' ),
				'param_name'       => 'woodmart_disable_overflow',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Row reverse', 'woodmart' ),
				'param_name'       => 'responsive_tabs_advanced',
				'hint'             => esc_html__( 'Reverse row columns on mobile and tablet devices.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Row reverse mobile.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'row_reverse_mobile',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Row reverse tablet.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'row_reverse_tablet',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'tablet' ),
				),
			),
		);

		/**
		 * Gradient option.
		 */
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$design_options[] = array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background gradient', 'woodmart' ),
				'param_name'       => 'woodmart_gradient_switch',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			);

			$design_options[] = array(
				'type'       => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value'   => array( 'yes' ),
				),
			);
		}

		/**
		 * Box Shadow Option.
		 */
		$design_options[] = array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'param_name'       => 'woodmart_box_shadow',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);

		$design_options[] = array(
			'type'             => 'wd_box_shadow',
			'param_name'       => 'wd_box_shadow',
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'selectors'        => array(
				'{{WRAPPER}}' => array(
					'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				),
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'dependency'       => array(
				'element' => 'woodmart_box_shadow',
				'value'   => array( 'yes' ),
			),
			'default'          => array(
				'horizontal' => '0',
				'vertical'   => '0',
				'blur'       => '9',
				'spread'     => '0',
				'color'      => 'rgba(0, 0, 0, .15)',
			),
		);

		vc_add_params( 'vc_row', $general_options );
		vc_add_params( 'vc_row', $design_options );
		vc_add_params( 'vc_row', $advanced_options );

		vc_add_params( 'vc_row_inner', $general_options_inner );
		vc_add_params( 'vc_row_inner', $design_options );
		vc_add_params( 'vc_row_inner', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_row_custom_options' );
}
