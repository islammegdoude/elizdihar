<?php
/**
 * Content map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use XTS\Modules\Visitor_Counter\Main as Counter_Visitors;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Visitor_Counter extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_visitor_counter';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product visitor counter', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-product-visitor-counter';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-single-product-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'single_product' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {
		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'with-bg' => esc_html__( 'With background', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->end_controls_section();

		/**
		 * Text settings
		 */
		$this->start_controls_section(
			'text_style_section',
			array(
				'label' => esc_html__( 'Text', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .wd-visits-count',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-count-number, {{WRAPPER}} .wd-count-msg' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Icon settings
		 */
		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => esc_html__( 'Icon', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_type',
			array(
				'label'   => esc_html__( 'Icon type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default icon', 'woodmart' ),
					'icon'    => esc_html__( 'Custom icon', 'woodmart' ),
					'image'   => esc_html__( 'Custom image', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => array(
					'icon_type' => array( 'icon' ),
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon size', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-count-icon' => 'font-size: {{SIZE}}px;',
				),
				'condition' => array(
					'icon_type!' => array( 'image' ),
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-count-icon' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'icon_type!' => array( 'image' ),
				),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings        = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'style' => 'default',
			)
		);
		$icon_output     = '';
		$wrapper_classes = '';

		if ( 'image' === $settings['icon_type'] && isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$icon_output = woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] );

			if ( woodmart_is_svg( $settings['image']['url'] ) ) {
				if ( 'custom' === $settings['image_size'] && ! empty( $settings['image_custom_dimension'] ) ) {
					$icon_output = woodmart_get_svg_html( $settings['image']['id'], $settings['image_custom_dimension'] );
				} else {
					$icon_output = woodmart_get_svg_html( $settings['image']['id'], $settings['image_size'] );
				}
			}

			$icon_output = '<span class="wd-count-icon">' . $icon_output . '</span>';
		} elseif ( 'icon' === $settings['icon_type'] && $settings['icon'] ) {
			$icon_output = woodmart_elementor_get_render_icon( $settings['icon'], array( 'class' => 'wd-count-icon' ), 'span' );

			if ( 'svg' === $settings['icon']['library'] ) {
				$icon_output = sprintf(
					'<span class="wd-count-icon">%s</span>',
					$icon_output
				);
			}
		}

		if ( ( 'icon' === $settings['icon_type'] && ! empty( $settings['icon']['value'] ) ) || ( 'image' === $settings['icon_type'] && ! empty( $settings['image']['id'] ) ) ) {
			$wrapper_classes .= ' wd-with-icon';
		}

		$wrapper_classes .= ' wd-style-' . $settings['style'];

		Main::setup_preview();

		Counter_Visitors::get_instance()->output_count_visitors( $wrapper_classes, $icon_output );

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register( new Visitor_Counter() );
