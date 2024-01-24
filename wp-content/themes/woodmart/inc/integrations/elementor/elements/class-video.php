<?php
/**
 * Video map
 *
 * @package Woodmart
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Video extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_video';
	}

	/**
	 * Get widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Video', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-video';
	}

	/**
	 * Get widget categories.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'extra_width_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-width-100',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'   => esc_html__( 'Source', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'hosted'  => esc_html__( 'Self hosted', 'woodmart' ),
					'youtube' => esc_html__( 'YouTube', 'woodmart' ),
					'vimeo'   => esc_html__( 'Vimeo', 'woodmart' ),
				),
				'default' => 'hosted',
			)
		);

		$this->add_control(
			'video_hosted_url',
			array(
				'label'      => esc_html__( 'Choose video', 'woodmart' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'video_youtube_url',
			array(
				'label'       => esc_html__( 'Link', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your URL', 'woodmart' ) . ' (YouTube)',
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'video_vimeo_url',
			array(
				'label'       => esc_html__( 'Link', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your URL', 'woodmart' ) . ' (Vimeo)',
				'default'     => 'https://vimeo.com/235215203',
				'condition'   => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'video_action_button',
			array(
				'label'   => esc_html__( 'Action button', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'without' => esc_html__( 'Without', 'woodmart' ),
					'overlay' => esc_html__( 'Play button on image', 'woodmart' ),
					'play'    => esc_html__( 'Play button', 'woodmart' ),
					'button'  => esc_html__( 'Button', 'woodmart' ),
				),
				'default' => 'without',
			)
		);

		$this->add_control(
			'video_overlay_lightbox',
			array(
				'label'        => esc_html__( 'Lightbox', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => array(
					'video_action_button' => 'overlay',
				),
			)
		);

		$this->add_control(
			'play_button_label',
			array(
				'label'     => esc_html__( 'Label', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'video_action_button' => array( 'overlay', 'play' ),
				),
				'default'   => '',
			)
		);

		$this->add_control(
			'video_options',
			array(
				'label'     => esc_html__( 'Video Options', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'video_action_button' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'video_autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'video_action_button' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'video_mute',
			array(
				'label'        => esc_html__( 'Mute', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'video_action_button' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'video_loop',
			array(
				'label'        => esc_html__( 'Loop', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'video_action_button' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'video_controls',
			array(
				'label'        => esc_html__( 'Controls', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'video_action_button' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'video_preload',
			array(
				'label'       => esc_html__( 'Preload', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'metadata' => esc_html__( 'Metadata', 'woodmart' ),
					'auto'     => esc_html__( 'Auto', 'woodmart' ),
					'none'     => esc_html__( 'None', 'woodmart' ),
				),
				'description' => esc_html__( 'Preload attribute lets you specify how the video should be loaded when the page loads. ', 'woodmart' ),
				'default'     => 'metadata',
				'condition'   => array(
					'video_type'          => 'hosted',
					'video_autoplay!'     => array( 'yes' ),
					'video_action_button' => 'without',
				),
			)
		);

		$this->add_control(
			'video_poster',
			array(
				'label'     => esc_html__( 'Poster', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'video_type'          => 'hosted',
					'video_action_button' => 'without',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Image overlay settings
		 */
		$this->start_controls_section(
			'image_overlay_section',
			array(
				'label'     => esc_html__( 'Image overlay', 'woodmart' ),
				'condition' => array(
					'video_action_button' => 'overlay',
				),
			)
		);

		$this->add_control(
			'video_image_overlay',
			array(
				'label'   => esc_html__( 'Choose Image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'video_image_overlay',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->end_controls_section();

		/**
		 * Button settings
		 */
		$this->start_controls_section(
			'content_button_section',
			array(
				'label'     => esc_html__( 'Button', 'woodmart' ),
				'condition' => array(
					'video_action_button' => 'button',
				),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Text', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Play video',
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label'     => esc_html__( 'General', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'video_action_button!' => array( 'button', 'play' ),
				),
			)
		);

		$this->add_control(
			'video_size',
			array(
				'label'   => esc_html__( 'Size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'aspect_ratio' => esc_html__( 'Aspect ratio', 'woodmart' ),
					'custom'       => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'custom',
			)
		);

		$this->add_responsive_control(
			'video_height',
			array(
				'label'     => esc_html__( 'Height', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 400,
				),
				'range'     => array(
					'px' => array(
						'min'  => 100,
						'max'  => 2000,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'video_size' => 'custom',
				),
			)
		);

		$this->add_control(
			'video_aspect_ratio',
			array(
				'label'     => esc_html__( 'Aspect Ratio', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video' => '--wd-aspect-ratio: {{VALUE}};',
				),
				'options'   => array(
					'16/9'  => '16:9',
					'16/10' => '16:10',
					'21/9'  => '21:9',
					'4/3'   => '4:3',
					'3/2'   => '3:2',
					'1/1'   => '1:1',
					'9/16'  => '9:16',
				),
				'default'   => '16/9',
				'condition' => array(
					'video_size' => 'aspect_ratio',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Button settings
		 */
		$this->start_controls_section(
			'style_button_section',
			array(
				'label'     => esc_html__( 'Button', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'video_action_button' => 'button',
				),
			)
		);

		woodmart_get_button_style_general_map( $this );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .wd-btn-text',
			)
		);

		$this->add_control(
			'button_style_layout_head',
			array(
				'label'     => esc_html__( 'Layout', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'video_action_button' => 'button',
				),
			)
		);

		woodmart_get_button_style_layout_map( $this );

		$this->add_control(
			'button_style_icon_head',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'video_action_button' => 'button',
				),
			)
		);

		woodmart_get_button_style_icon_map( $this );

		$this->end_controls_section();

		/**
		 * Play button settings
		 */
		$this->start_controls_section(
			'style_play_button_section',
			array(
				'label'     => esc_html__( 'Play button', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'video_action_button' => array( 'play', 'overlay' ),
				),
			)
		);

		$this->add_control(
			'play_button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'woodmart' ),
				'type'      => 'wd_buttons',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'condition' => array(
					'video_action_button' => 'play',
				),
				'separator' => 'after',
				'default'   => 'center',
			)
		);

		// $this->add_control(
		// 	'play_button_label_heading',
		// 	array(
		// 		'label' => esc_html__( 'Label', 'woodmart' ),
		// 		'type'  => Controls_Manager::HEADING,
		// 	)
		// );

		$this->add_control(
			'play_button_label_color',
			array(
				'label'     => esc_html__( 'Label color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video .wd-el-video-play-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'play_button_label_typography',
				'label'    => esc_html__( 'Label typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-el-video .wd-el-video-play-label',
			)
		);

		$this->add_control(
			'play_button_label_divider',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_responsive_control(
			'play_button_icon_size',
			array(
				'label'     => esc_html__( 'Icon size', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 40,
						'max' => 150,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video-play-btn' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'play_button_icon_head',
			array(
				'label'     => esc_html__( 'Icon color', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'play_button_icon_color_tabs' );

		$this->start_controls_tab(
			'play_button_icon_color_tab',
			array(
				'label' => esc_html__( 'Idle', 'woodmart' ),
			)
		);

		$this->add_control(
			'play_button_icon_idle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video-play-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'play_button_icon_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);

		$this->add_control(
			'play_button_icon_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-video-btn:hover .wd-el-video-play-btn, {{WRAPPER}} .wd-action-overlay:hover .wd-el-video-play-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_args = array(
			// General.
			'video_type'             => 'hosted',
			'video_youtube_url'      => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
			'video_vimeo_url'        => 'https://vimeo.com/235215203',
			'video_hosted_url'       => '',
			'video_action_button'    => 'without',

			// Options.
			'video_autoplay'         => 'no',
			'video_mute'             => 'no',
			'video_loop'             => 'no',
			'video_controls'         => 'yes',
			'video_preload'          => 'metadata',
			'video_poster'           => array(),

			// Image overlay.
			'video_image_overlay'    => array(),
			'video_overlay_lightbox' => 'no',

			// Button.
			'button_text'            => 'Play video',
			'play_button_label'      => '',
			'play_button_align'      => 'center',

			// General style.
			'video_size'             => 'custom',
		);

		$element_args = wp_parse_args( $this->get_settings_for_display(), $default_args );

		$image_output    = '';
		$video_url       = '';
		$play_classes    = '';
		$wrapper_classes = '';

		woodmart_enqueue_js_script( 'video-element' );
		woodmart_enqueue_inline_style( 'el-video' );

		// Wrapper classes.
		$wrapper_classes .= ' wd-action-' . $element_args['video_action_button'];
		$wrapper_classes .= ' wd-video-' . $element_args['video_type'];

		if ( 'play' === $element_args['video_action_button'] ) {
			$wrapper_classes .= ' text-' . $element_args['play_button_align'];
		}

		if ( 'aspect_ratio' === $element_args['video_size'] ) {
			$wrapper_classes .= ' wd-with-aspect-ratio';
		}

		// Play classes.
		if ( 'yes' === $element_args['video_overlay_lightbox'] ) {
			$wrapper_classes .= ' wd-lightbox';
			$play_classes    .= ' wd-el-video-lightbox';
		}

		if ( 'hosted' === $element_args['video_type'] ) {
			$play_classes .= ' wd-el-video-hosted';
		}

		// Image settings.
		if ( 'overlay' === $element_args['video_action_button'] && $element_args['video_image_overlay']['id'] ) {
			$image_output = woodmart_otf_get_image_html( $element_args['video_image_overlay']['id'], $element_args['video_image_overlay_size'], $element_args['video_image_overlay_custom_dimension'] );
		}

		// Video settings.
		if ( 'without' === $element_args['video_action_button'] ) {
			$video_params = array(
				'loop'     => 'yes' === $element_args['video_loop'] ? 1 : 0,
				'mute'     => 'yes' === $element_args['video_mute'] || 'yes' === $element_args['video_autoplay'] ? 1 : 0,
				'controls' => 'yes' === $element_args['video_controls'] ? 1 : 0,
				'autoplay' => 'yes' === $element_args['video_autoplay'] && 'without' === $element_args['video_action_button'],
			);
		} else {
			$video_params = array(
				'loop'     => 0,
				'mute'     => 'youtube' !== $element_args['video_type'] ? 1 : 0,
				'controls' => 1,
				'autoplay' => 0,
			);
		}

		if ( 'youtube' === $element_args['video_type'] ) {
			$video_url                   = $element_args['video_youtube_url'];
			$element_args['link']['url'] = $element_args['video_youtube_url'];
		} elseif ( 'vimeo' === $element_args['video_type'] ) {
			$primary_color = woodmart_get_opt( 'primary-color' );

			if ( ! empty( $primary_color['idle'] ) ) {
				$video_params['color'] = str_replace( '#', '', $primary_color['idle'] );
			}

			$video_params['muted'] = $video_params['mute'];
			unset( $video_params['mute'] );

			$video_url                   = $element_args['video_vimeo_url'];
			$element_args['link']['url'] = $element_args['video_vimeo_url'];
		} elseif ( 'hosted' === $element_args['video_type'] ) {
			$element_args['link']['url'] = $element_args['video_hosted_url']['url'];
		}

		if ( 'hosted' === $element_args['video_type'] ) {
			$video_tag_id                         = uniqid();
			$video_html                           = '';
			$video_attr                           = '';
			$element_args['link']['url']          = '#' . $video_tag_id;
			$element_args['button_extra_classes'] = $play_classes;

			if ( 'without' === $element_args['video_action_button'] ) {
				$video_attr .= ' src="' . $element_args['video_hosted_url']['url'] . '"';
			} else {
				$video_attr .= ' data-lazy-load="' . $element_args['video_hosted_url']['url'] . '"';
			}

			$video_attr .= ' playsinline';
			$video_attr .= $video_params['loop'] ? ' loop' : '';
			$video_attr .= $video_params['mute'] ? ' muted' : '';
			$video_attr .= $video_params['controls'] ? ' controls' : '';
			$video_attr .= $video_params['autoplay'] && 'without' === $element_args['video_action_button'] ? ' autoplay' : '';

			if ( 'yes' === $element_args['video_overlay_lightbox'] || 'button' === $element_args['video_action_button'] || 'play' === $element_args['video_action_button'] ) {
				$video_html .= '<div class="wd-popup mfp-with-anim mfp-hide wd-video-popup" id="' . $video_tag_id . '">';
			}

			if ( ! $video_params['autoplay'] && 'without' === $element_args['video_action_button'] ) {
				$video_attr .= ' preload="' . $element_args['video_preload'] . '"';
			}

			if ( ! empty( $element_args['video_poster']['id'] ) && 'without' === $element_args['video_action_button'] ) {
				$video_attr .= ' poster="' . wp_get_attachment_image_src( $element_args['video_poster']['id'], 'full' )[0] . '"';
			}

			$video_html .= '<video' . $video_attr . '></video>';

			if ( 'yes' === $element_args['video_overlay_lightbox'] || 'button' === $element_args['video_action_button'] || 'play' === $element_args['video_action_button'] ) {
				$video_html .= '</div>';
			}
		} else {
			$frame_attributes = array();
			$video_embed_url  = '';

			if ( 'youtube' === $element_args['video_type'] ) {
				preg_match( '/^.*(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/', $video_url, $matches );

				if ( ! $matches ) {
					return;
				}

				if ( 'yes' === $element_args['video_loop'] ) {
					$video_params['playlist'] = $matches[1];
				}

				$video_embed_url = 'https://www.youtube.com/embed/' . $matches[1] . '?feature=oembed';
			} elseif ( 'vimeo' === $element_args['video_type'] ) {
				preg_match( '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/', $video_url, $matches );

				if ( ! $matches ) {
					return;
				}

				$video_embed_url = 'https://player.vimeo.com/video/' . $matches[1] . '?transparent=0';
			}

			if ( 'overlay' === $element_args['video_action_button'] ) {
				unset( $video_params['autoplay'] );
			}

			foreach ( $video_params as $key => $param ) {
				if ( $param || 0 === $param ) {
					$video_embed_url .= '&' . $key . '=' . $param;
				}
			}

			if ( 'without' === $element_args['video_action_button'] ) {
				$frame_attributes[] = 'src="' . $video_embed_url . '"';
			} else {
				$frame_attributes[] = 'data-lazy-load="' . $video_embed_url . '"';
			}

			$frame_attributes[] = 'allowfullscreen';
			$frame_attributes[] = 'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"';
			$frame_attributes[] = 'width="100%"';
			$frame_attributes[] = 'height="100%"';
			$frame_attributes[] = 'loading="lazy"';

			$video_html = '<iframe ' . implode( ' ', $frame_attributes ) . '></iframe>';

			$element_args['link']['url'] = $video_url;
		}

		// Button settings.
		if ( 'button' === $element_args['video_action_button'] ) {
			if ( isset( $element_args['button_extra_classes'] ) ) {
				$element_args['button_extra_classes'] .= ' wd-el-video-btn';
			} else {
				$element_args['button_extra_classes'] = ' wd-el-video-btn';
			}
		}

		if ( 'play' === $element_args['video_action_button'] || 'button' === $element_args['video_action_button'] || 'yes' === $element_args['video_overlay_lightbox'] ) {
			woodmart_enqueue_js_library( 'magnific' );
			woodmart_enqueue_inline_style( 'mfp-popup' );
			woodmart_enqueue_js_script( 'video-element-popup' );
		}
		?>

		<div class="wd-el-video<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 'hosted' === $element_args['video_type'] || 'without' === $element_args['video_action_button'] || 'overlay' === $element_args['video_action_button'] && 'yes' !== $element_args['video_overlay_lightbox'] ) : ?>
				<?php echo $video_html; ?>
			<?php endif; ?>

			<?php if ( 'button' === $element_args['video_action_button'] && $element_args['button_text'] ) : ?>
				<?php $element_args['custom_classes'] = $play_classes; ?>
				<?php woodmart_elementor_button_template( $element_args ); ?>
			<?php endif; ?>

			<?php if ( 'play' === $element_args['video_action_button'] ) : ?>
				<a href="<?php echo esc_url( $element_args['link']['url'] ); ?>" class="wd-el-video-btn<?php echo esc_attr( $play_classes ); ?>">
					<span class="wd-el-video-play-btn"></span>
					<?php if ( $element_args['play_button_label'] ) : ?>
						<span class="wd-el-video-play-label">
							<?php echo esc_html( $element_args['play_button_label'] ); ?>
						</span>
					<?php endif; ?>
				</a>
			<?php endif; ?>

			<?php if ( 'overlay' === $element_args['video_action_button'] ) : ?>
				<div class="wd-el-video-overlay wd-fill">
					<?php echo wp_kses( $image_output, true ); ?>
				</div>
				<div class="wd-el-video-control color-scheme-light wd-fill">
					<span class="wd-el-video-play-btn"></span>
					<?php if ( $element_args['play_button_label'] ) : ?>
						<span class="wd-el-video-play-label">
							<?php echo esc_html( $element_args['play_button_label'] ); ?>
						</span>
					<?php endif; ?>
				</div>

				<a class="wd-el-video-link wd-el-video-btn-overlay wd-fill<?php echo esc_attr( $play_classes ); ?>" href="<?php echo esc_url( $element_args['link']['url'] ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Video() );
