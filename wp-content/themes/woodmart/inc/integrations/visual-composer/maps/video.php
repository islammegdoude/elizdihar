<?php
/**
 * Video map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}


if ( ! function_exists( 'woodmart_get_vc_map_video' ) ) {
	function woodmart_get_vc_map_video() {
		$btn_typography = woodmart_get_typography_map(
			array(
				'key'        => 'button_typography',
				'group'      => esc_html__( 'Style', 'woodmart' ),
				'selector'   => '{{WRAPPER}} .btn',
				'dependency' => array(
					'element' => 'video_action_button',
					'value'   => array( 'action_button' ),
				),
			)
		);

		$label_typography = woodmart_get_typography_map(
			array(
				'title'      => esc_html__( 'Label typography', 'woodmart' ),
				'key'        => 'play_button_label_typography',
				'group'      => esc_html__( 'Style', 'woodmart' ),
				'selector'   => '{{WRAPPER}}.wd-el-video .wd-el-video-play-label',
				'dependency' => array(
					'element' => 'video_action_button',
					'value'   => array( 'play', 'overlay' ),
				),
			)
		);

		return array(
			'name'        => esc_html__( 'Video', 'woodmart' ),
			'base'        => 'woodmart_video',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Embed/Self-hosted video player', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/video.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'heading'          => esc_html__( 'Source', 'woodmart' ),
					'param_name'       => 'video_type',
					'type'             => 'dropdown',
					'value'            => array(
						esc_html__( 'Self hosted', 'woodmart' ) => 'hosted',
						esc_html__( 'YouTube', 'woodmart' ) => 'youtube',
						esc_html__( 'Vimeo', 'woodmart' ) => 'vimeo',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Video', 'woodmart' ),
					'type'             => 'wd_upload',
					'param_name'       => 'video_hosted',
					'attachment_type'  => 'video',
					'value'            => '',
					'hint'             => esc_html__( 'Select video from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'video_type',
						'value'   => array( 'hosted' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Link', 'woodmart' ),
					'type'             => 'textfield',
					'param_name'       => 'video_youtube_url',
					'value'            => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
					'dependency'       => array(
						'element' => 'video_type',
						'value'   => array( 'youtube' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Link', 'woodmart' ),
					'param_name'       => 'video_vimeo_url',
					'value'            => 'https://vimeo.com/235215203',
					'dependency'       => array(
						'element' => 'video_type',
						'value'   => array( 'vimeo' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Action button', 'woodmart' ),
					'param_name' => 'video_action_button',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Without', 'woodmart' ) => 'without',
						esc_html__( 'Play button on image', 'woodmart' ) => 'overlay',
						esc_html__( 'Play button', 'woodmart' ) => 'play',
						esc_html__( 'Button', 'woodmart' ) => 'action_button',
					),
				),
				array(
					'heading'          => esc_html__( 'Lightbox', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'video_overlay_lightbox',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Label', 'woodmart' ),
					'param_name'       => 'play_button_label',
					'type'             => 'textfield',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'overlay', 'play' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Video options', 'woodmart' ),
					'param_name' => 'video_options_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Autoplay', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'video_autoplay',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Mute', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'video_mute',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Loop', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'video_loop',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Controls', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'video_controls',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'yes',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Preload', 'woodmart' ),
					'description'      => esc_html__( 'Preload attribute lets you specify how the video should be loaded when the page loads. ', 'woodmart' ),
					'param_name'       => 'video_preload',
					'type'             => 'dropdown',
					'value'            => array(
						esc_html__( 'Metadata', 'woodmart' ) => 'metadata',
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						esc_html__( 'None', 'woodmart' ) => 'none',
					),
					'std'              => 'metadata',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
					'wd_dependency'    => array(
						'element' => 'video_type',
						'value'   => array( 'hosted' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Poster', 'woodmart' ),
					'type'             => 'attach_image',
					'param_name'       => 'video_poster',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'without' ),
					),
					'wd_dependency'    => array(
						'element' => 'video_type',
						'value'   => array( 'hosted' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image overlay', 'woodmart' ),
					'param_name' => 'image_overlay_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'overlay' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'video_image_overlay',
					'type'             => 'attach_image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'video_image_overlay_size',
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'button_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'heading'          => esc_html__( 'Text', 'woodmart' ),
					'param_name'       => 'button_text',
					'type'             => 'textfield',
					'value'            => 'Play video',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'general_style_divider',
					'dependency' => array(
						'element'            => 'video_action_button',
						'value_not_equal_to' => array( 'action_button', 'play' ),
					),
				),
				array(
					'heading'    => esc_html__( 'Size', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'video_size',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Aspect ratio', 'woodmart' ) => 'aspect_ratio',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'std'        => 'custom',
					'dependency' => array(
						'element'            => 'video_action_button',
						'value_not_equal_to' => array( 'action_button', 'play' ),
					),
				),
				array(
					'heading'    => esc_html__( 'Height', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'video_height',
					'selectors'  => array(
						'{{WRAPPER}}.wd-el-video' => array(
							'height: {{VALUE}}px !important;'
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => 400,
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
					'range'      => array(
						'px' => array(
							'min'  => 100,
							'max'  => 2000,
							'step' => 1,
						),
					),
					'dependency' => array(
						'element' => 'video_size',
						'value'   => 'custom',
					),
				),
				array(
					'heading'    => esc_html__( 'Aspect Ratio', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'video_aspect_ratio',
					'type'       => 'wd_select',
					'style'      => 'select',
					'selectors'  => array(
						'{{WRAPPER}}.wd-el-video' => array(
							'--wd-aspect-ratio: {{VALUE}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '16/9',
						),
					),
					'value'      => array(
						'16:9'  => '16/9',
						'16:10' => '16/10',
						'21:9'  => '21/9',
						'4:3'   => '4/3',
						'3:2'   => '3/2',
						'1:1'   => '1/1',
						'9:16'  => '9/16',
					),
					'dependency' => array(
						'element' => 'video_size',
						'value'   => array( 'aspect_ratio' ),
					),
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button style', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'button_style_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button style', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Flat', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( '3D', 'woodmart' )   => '3d',
					),
					'images_value'     => array(
						'default'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/default.png',
						'bordered' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/bordered.png',
						'link'     => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/link.png',
						'3d'       => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/3d.png',
					),
					'title'            => false,
					'std'              => 'default',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button shape', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'shape',
					'value'            => array(
						esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
						esc_html__( 'Circle', 'woodmart' ) => 'round',
						esc_html__( 'Round', 'woodmart' )  => 'semi-round',
					),
					'images_value'     => array(
						'rectangle'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.jpeg',
						'round'      => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.jpeg',
						'semi-round' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.jpeg',
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'wd_dependency'    => array(
						'element'            => 'style',
						'value_not_equal_to' => array( 'round', 'link' ),
					),
					'title'            => false,
					'std'              => 'rectangle',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-shape',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button size', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'size',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
					'std'              => 'default',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Predefined button color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'color',
					'value'            => array(
						esc_html__( 'Grey', 'woodmart' )   => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'White', 'woodmart' )  => 'white',
						esc_html__( 'Black', 'woodmart' )  => 'black',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'style'            => array(
						'default' => '#f3f3f3',
						'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
						'black'   => '#212121',
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Idle background color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'bg_color',
					'selectors'        => array(
						'{{WRAPPER}}.wd-button-wrapper a' => array(
							'background-color :{{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'color',
						'value'   => array( 'custom' ),
					),
					'wd_dependency'    => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Background color on hover', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'bg_color_hover',
					'selectors'        => array(
						'{{WRAPPER}}.wd-button-wrapper a:hover' => array(
							'background-color :{{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'color',
						'value'   => array( 'custom' ),
					),
					'wd_dependency'    => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Idle text color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'color_scheme',
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Custom text color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'custom_color_scheme',
					'selectors'        => array(
						'{{WRAPPER}}.wd-button-wrapper a' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'color_scheme',
						'value'   => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Text color scheme on hover', 'woodmart' ),
					'param_name'       => 'color_scheme_hover',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Custom text color on hover', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'custom_color_scheme_hover',
					'selectors'        => array(
						'{{WRAPPER}}.wd-button-wrapper a:hover' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'color_scheme_hover',
						'value'   => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),

				$btn_typography['font_family'],
				$btn_typography['font_size'],
				$btn_typography['font_weight'],
				$btn_typography['text_transform'],
				$btn_typography['font_style'],
				$btn_typography['line_height'],

				/**
				 * Layout.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button layout', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'button_layout_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),

				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Align', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'align',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
					'std'              => 'center',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Full width', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'full_width',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),

				/**
				 * Icon
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'button_icon_divider',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Type', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_type',
					'value'      => array(
						esc_html__( 'Icon', 'woodmart' )  => 'icon',
						esc_html__( 'Image', 'woodmart' ) => 'image',
					),
					'default'    => 'icon',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'action_button' ),
					),
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
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
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon library', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
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
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_fontawesome',
					'value'      => '',
					'settings'   => array(
						'emptyIcon'    => true,
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'fontawesome' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_openiconic',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'openiconic' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_typicons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'typicons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_entypo',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'entypo' ),
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_linecons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'linecons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_monosocial',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'monosocial' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_material',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'material' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button icon position', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_position',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'std'              => 'right',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
				),

				/**
				 * Play button settings
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Play button', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'play_button_divider',
					'dependency' => array(
						'element'            => 'video_action_button',
						'value_not_equal_to' => array( 'action_button', 'without' ),
					),
				),

				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'play_button_align',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'play' ),
					),
					'std'              => 'center',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'play' ),
					),
				),

				array(
					'heading'          => esc_html__( 'Label color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'play_button_label_color',
					'selectors'        => array(
						'{{WRAPPER}}.wd-el-video .wd-el-video-play-label' => array(
							'color :{{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'play', 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$label_typography['font_family'],
				$label_typography['font_size'],
				$label_typography['font_weight'],
				$label_typography['text_transform'],
				$label_typography['font_style'],
				$label_typography['line_height'],

				array(
					'heading'    => esc_html__( 'Icon size', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'play_button_icon_size',
					'selectors'  => array(
						'{{WRAPPER}} .wd-el-video-play-btn' => array(
							'font-size: {{VALUE}}px;',
						),
					),
					'devices'    => array(
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
					'range'      => array(
						'px' => array(
							'min'  => 40,
							'max'  => 150,
							'step' => 1,
						),
					),
					'dependency' => array(
						'element' => 'video_action_button',
						'value'   => array( 'play', 'overlay' ),
					),
				),

				array(
					'heading'          => esc_html__( 'Icon color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'play_button_icon_idle_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-el-video-play-btn' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'play', 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Icon color hover', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'play_button_icon_hover_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-el-video-btn:hover .wd-el-video-play-btn, {{WRAPPER}}.wd-action-overlay:hover .wd-el-video-play-btn' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'video_action_button',
						'value'   => array( 'play', 'overlay' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Design options.
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
