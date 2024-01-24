<?php
/**
 * Gallery map.
 *
 * @package xts
 */

namespace XTS\Modules\Layouts;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Gallery extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_gallery';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product gallery', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-gallery';
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
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'zoom', 'wc-single-product' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {

		/**
		 * Content tab.
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-single-gallery elementor-widget-theme-post-content',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'thumbnails_position',
			array(
				'label'       => esc_html__( 'Gallery layout', 'woodmart' ),
				'description' => esc_html__( 'Set your thumbnails display or leave default set from Theme Settings.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'inherit'           => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'left'              => esc_html__( 'Thumbnails left', 'woodmart' ),
					'bottom'            => esc_html__( 'Thumbnails bottom', 'woodmart' ),
					'without'           => esc_html__( 'Carousel', 'woodmart' ),
					'bottom_column'     => esc_html__( 'Grid', 'woodmart' ),
					'bottom_grid'       => esc_html__( 'Bottom grid', 'woodmart' ),
					'bottom_combined'   => esc_html__( 'Combined grid 1', 'woodmart' ),
					'bottom_combined_2' => esc_html__( 'Combined grid 2', 'woodmart' ),
					'bottom_combined_3' => esc_html__( 'Combined grid 3', 'woodmart' ),
				),
				'default'     => 'inherit',
			)
		);

		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'     => esc_html__( 'Slides per view', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''  => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'default'   => '',
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'classes'   => 'wd-hide-custom-breakpoints',
				'condition' => array(
					'thumbnails_position' => array( 'without' ),
				),
			)
		);

		$this->add_responsive_control(
			'grid_columns',
			array(
				'label'     => esc_html__( 'Grid column', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''  => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'default'   => '',
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'classes'   => 'wd-hide-custom-breakpoints',
				'condition' => array(
					'thumbnails_position' => array( 'bottom_column', 'bottom_grid' ),
				),
			)
		);

		$this->add_responsive_control(
			'grid_columns_gap',
			array(
				'label'     => esc_html__( 'Gallery gap', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-product-gallery' => '--wd-gallery-gap: {{SIZE}}{{UNIT}};',
				),
				'default'   => array(),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'condition' => array(
					'thumbnails_position!' => array( 'inherit' ),
				),
			)
		);

		$this->add_control(
			'carousel_on_tablet',
			array(
				'label'     => esc_html__( 'Carousel on tablet', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'thumbnails_position' => array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ),
				),
			)
		);

		$this->add_control(
			'carousel_on_mobile',
			array(
				'label'     => esc_html__( 'Carousel on mobile', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'thumbnails_position' => array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ),
				),
			)
		);

		$this->add_control(
			'main_gallery_center_mode',
			array(
				'label'     => esc_html__( 'Center mode in main gallery', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'thumbnails_position' => array( 'without' ),
				),
			)
		);

		$this->add_control(
			'pagination_main_gallery',
			array(
				'label'     => esc_html__( 'Main carousel with pagination', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'thumbnails_position!' => 'inherit',
				),
			)
		);

		$this->add_responsive_control(
			'thumbnails_left_vertical_columns',
			array(
				'label'          => esc_html__( 'Thumbnails per slide', 'woodmart' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'auto'    => esc_html__( 'Auto', 'woodmart' ),
					'2'       => '2',
					'3'       => '3',
					'4'       => '4',
					'5'       => '5',
					'6'       => '6',
				),
				'default'        => 'inherit',
				'default_tablet' => 'inherit',
				'default_mobile' => 'inherit',
				'devices'        => array( 'desktop', 'tablet', 'mobile' ),
				'classes'        => 'wd-hide-custom-breakpoints',
				'condition'      => array(
					'thumbnails_position' => 'left',
				),
			)
		);

		$this->add_control(
			'thumbnails_wrap_in_mobile_devices',
			array(
				'label'     => esc_html__( 'Thumbnails position bottom on mobile devices', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'on'      => esc_html__( 'On', 'woodmart' ),
					'off'     => esc_html__( 'Off', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'thumbnails_position' => 'left',
				),
			)
		);

		$this->add_responsive_control(
			'thumbnails_left_gallery_width',
			array(
				'label'     => esc_html__( 'Thumbnails gallery width', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-product-gallery.thumbs-position-left' => '--wd-thumbs-width: {{SIZE}}{{UNIT}};',
				),
				'default'   => array(),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'condition' => array(
					'thumbnails_position' => 'left',
				),
			)
		);

		$this->add_responsive_control(
			'thumbnails_left_gallery_height',
			array(
				'label'     => esc_html__( 'Thumbnails gallery height', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-product-gallery.thumbs-position-left' => '--wd-thumbs-height: {{SIZE}}{{UNIT}};',
					'.elementor-editor-active {{WRAPPER}} .woocommerce-product-gallery.thumbs-position-left' => '--wd-thumbs-height: {{SIZE}}{{UNIT}} !important;',
				),
				'default'   => array(),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'condition' => array(
					'thumbnails_position' => 'left',
				),
			)
		);

		$this->add_responsive_control(
			'thumbnails_bottom_columns',
			array(
				'label'          => esc_html__( 'Thumbnails per slide', 'woodmart' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'auto'    => esc_html__( 'Auto', 'woodmart' ),
					'2'       => '2',
					'3'       => '3',
					'4'       => '4',
					'5'       => '5',
					'6'       => '6',
				),
				'default'        => 'inherit',
				'tablet_default' => 'inherit',
				'mobile_default' => 'inherit',
				'devices'        => array( 'desktop', 'tablet', 'mobile' ),
				'classes'        => 'wd-hide-custom-breakpoints',
				'condition'      => array(
					'thumbnails_position' => 'bottom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'thumbnails_position'                     => 'left',
				'product_id'                              => false,
				'thumbnails_bottom_columns_tablet'        => 'inherit',
				'thumbnails_bottom_columns_mobile'        => 'inherit',
				'thumbnails_left_vertical_columns_tablet' => 'inherit',
				'thumbnails_left_vertical_columns_mobile' => 'inherit',
				'slides_per_view'                         => '',
				'slides_per_view_tablet'                  => '',
				'slides_per_view_mobile'                  => '',
				'grid_columns'                            => '',
				'grid_columns_tablet'                     => '',
				'grid_columns_mobile'                     => '',
				'carousel_on_tablet'                      => 'inherit',
				'carousel_on_mobile'                      => 'inherit',
				'pagination_main_gallery'                 => 'inherit',
				'main_gallery_center_mode'                => 'inherit',
				'thumbnails_wrap_in_mobile_devices'       => 'inherit',
			)
		);

		wp_enqueue_script( 'zoom' );

		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview( array(), $settings['product_id'] );

		wc_get_template(
			'single-product/product-image.php',
			array(
				'builder_thumbnails_position'         => $settings['thumbnails_position'],
				'builder_thumbnails_vertical_columns' => $settings['thumbnails_left_vertical_columns'],
				'builder_thumbnails_columns_desktop'  => $settings['thumbnails_bottom_columns'],
				'builder_thumbnails_columns_tablet'   => 'left' === $settings['thumbnails_position'] ? $settings['thumbnails_left_vertical_columns_tablet'] : $settings['thumbnails_bottom_columns_tablet'],
				'builder_thumbnails_columns_mobile'   => 'left' === $settings['thumbnails_position'] ? $settings['thumbnails_left_vertical_columns_mobile'] : $settings['thumbnails_bottom_columns_mobile'],
				'gallery_columns_desktop'             => $settings['slides_per_view'],
				'gallery_columns_tablet'              => $settings['slides_per_view_tablet'],
				'gallery_columns_mobile'              => $settings['slides_per_view_mobile'],
				'carousel_on_tablet'                  => $settings['carousel_on_tablet'],
				'carousel_on_mobile'                  => $settings['carousel_on_mobile'],
				'pagination_main_gallery'             => $settings['pagination_main_gallery'],
				'main_gallery_center_mode'            => $settings['main_gallery_center_mode'],
				'thumbnails_wrap_in_mobile_devices'   => $settings['thumbnails_wrap_in_mobile_devices'],
				'grid_columns'                        => $settings['grid_columns'],
				'grid_columns_tablet'                 => $settings['grid_columns_tablet'],
				'grid_columns_mobile'                 => $settings['grid_columns_mobile'],
			)
		);

		Main::restore_preview( $settings['product_id'] );
	}
}

Plugin::instance()->widgets_manager->register( new Gallery() );
