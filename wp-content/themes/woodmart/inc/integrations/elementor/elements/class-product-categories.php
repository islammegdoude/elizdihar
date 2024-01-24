<?php
/**
 * Title map.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
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
class Product_Categories extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_product_categories';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product categories', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-product-categories';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-nav-product-cat-wrap',
				'prefix_class' => '',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
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
			'data_source',
			array(
				'label'   => esc_html__( 'Data source', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom_query',
				'options' => array(
					'custom_query' => esc_html__( 'Custom query', 'woodmart' ),
					'wc_query'     => esc_html__( 'Woocommerce query', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'navigation' => esc_html__( 'Navigation', 'woodmart' ),
					'grid'       => esc_html__( 'Grid', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'images',
			array(
				'label'        => esc_html__( 'Enable images', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'product_count',
			array(
				'label'        => esc_html__( 'Enable product count', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'mobile_accordion',
			array(
				'label'        => esc_html__( 'Mobile accordion', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'on',
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'on',
				'prefix_class' => 'wd-nav-accordion-mb-',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'shop_categories_ancestors',
			array(
				'label'        => esc_html__( 'Show current category ancestors', 'woodmart' ),
				'description'  => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_block'  => true,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
				'condition'    => array(
					'type'        => array( 'navigation' ),
					'data_source' => array( 'wc_query' ),
				),
			)
		);

		$this->add_control(
			'show_categories_neighbors',
			array(
				'label'        => esc_html__( 'Show category neighbors if there is no children', 'woodmart' ),
				'description'  => esc_html__( 'If the category you visit doesn\'t contain any subcategories, the page title menu will display this category\'s neighbors categories.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_block'  => true,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
				'condition'    => array(
					'type'        => array( 'navigation' ),
					'data_source' => array( 'wc_query' ),
				),
			)
		);

		$this->add_control(
			'number',
			array(
				'label'       => esc_html__( 'Number', 'woodmart' ),
				'description' => esc_html__( 'Enter the number of categories to display for this element.', 'woodmart' ),
				'type'        => Controls_Manager::NUMBER,
				'condition'   => array(
					'data_source' => array( 'custom_query' ),
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'     => esc_html__( 'Order by', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''           => '',
					'id'         => esc_html__( 'ID', 'woodmart' ),
					'date'       => esc_html__( 'Date', 'woodmart' ),
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'menu_order' => esc_html__( 'Menu order', 'woodmart' ),
					'modified'   => esc_html__( 'Last modified date', 'woodmart' ),
				),
				'condition' => array(
					'data_source' => array( 'custom_query' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'     => esc_html__( 'Sort order', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''     => esc_html__( 'Inherit', 'woodmart' ),
					'DESC' => esc_html__( 'Descending', 'woodmart' ),
					'ASC'  => esc_html__( 'Ascending', 'woodmart' ),
				),
				'condition' => array(
					'data_source' => array( 'custom_query' ),
				),
			)
		);

		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'Categories', 'woodmart' ),
				'description' => esc_html__( 'List of product categories.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_taxonomies_by_query',
				'render'      => 'woodmart_get_taxonomies_title_by_id',
				'taxonomy'    => 'product_cat',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => array(
					'data_source' => array( 'custom_query' ),
				),
			)
		);

		$this->add_control(
			'hide_empty',
			array(
				'label'        => esc_html__( 'Hide empty', 'woodmart' ),
				'description'  => esc_html__( 'Don’t display categories that don’t have any products assigned.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * Design settings.
		 */
		$this->start_controls_section(
			'design_style_section',
			array(
				'label' => esc_html__( 'Design', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'categories_design',
			array(
				'label'       => esc_html__( 'Categories design', 'woodmart' ),
				'description' => esc_html__( 'Overrides option from Theme Settings -> Shop', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'inherit',
				'options'     => array(
					'inherit'       => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'default'       => esc_html__( 'Default', 'woodmart' ),
					'alt'           => esc_html__( 'Alternative', 'woodmart' ),
					'center'        => esc_html__( 'Center title', 'woodmart' ),
					'replace-title' => esc_html__( 'Replace title', 'woodmart' ),
					'mask-subcat'   => esc_html__( 'Mask with subcategories', 'woodmart' ),
					'zoom-out'      => esc_html__( 'Zoom out', 'woodmart' ),
				),
				'condition'   => array(
					'type' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'img_size',
			array(
				'label'     => esc_html__( 'Image size', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'large',
				'options'   => woodmart_get_all_image_sizes_names( 'elementor' ),
				'condition' => array(
					'type' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'img_size_custom',
			array(
				'label'       => esc_html__( 'Image dimension', 'woodmart' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'woodmart' ),
				'condition'   => array(
					'type'     => array( 'grid' ),
					'img_size' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'image_container_width',
			array(
				'label'      => esc_html__( 'Image container width', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => 'px',
				),
				'range'      => array(
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
				'selectors'  => array(
					'{{WRAPPER}}' => '--wd-cat-img-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'categories_design' => array( 'alt' ),
				),
			)
		);

		$this->add_control(
			'color_scheme',
			array(
				'label'     => esc_html__( 'Color scheme', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inherit',
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
				),
				'condition' => array(
					'type'              => array( 'grid' ),
					'categories_design' => array( 'default', 'mask-subcat' ),
				),
			)
		);

		$this->add_control(
			'categories_with_shadow',
			array(
				'label'     => esc_html__( 'Categories with shadow', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'condition' => array(
					'type'              => array( 'grid' ),
					'categories_design' => array( 'alt', 'default' ),
				),
			)
		);

		$this->add_control(
			'rounding_size',
			array(
				'label'     => esc_html__( 'Rounding', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'0'      => esc_html__( '0', 'woodmart' ),
					'5'      => esc_html__( '5', 'woodmart' ),
					'8'      => esc_html__( '8', 'woodmart' ),
					'12'     => esc_html__( '12', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-cat-brd-radius: {{VALUE}}px;',
				),
				'condition' => array(
					'type' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'custom_rounding_size',
			array(
				'label'      => esc_html__( 'Rounding', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--wd-cat-brd-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rounding_size' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'nav_alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'woodmart' ),
				'type'         => 'wd_buttons',
				'options'      => array(
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
				'prefix_class' => 'text-',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'nav_color_scheme',
			array(
				'label'        => esc_html__( 'Color scheme', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					''       => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'dark'   => esc_html__( 'Dark', 'woodmart' ),
					'light'  => esc_html__( 'Light', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'prefix_class' => 'color-scheme-',
				'default'      => '',
				'render_type'  => 'template',
				'condition'    => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->start_controls_tabs(
			'title_text_color_tabs',
			array(
				'condition' => array(
					'type'             => array( 'navigation' ),
					'nav_color_scheme' => 'custom',
				),
			)
		);

		$this->start_controls_tab(
			'title_text_color_tab',
			array(
				'label'     => esc_html__( 'Idle', 'woodmart' ),
				'condition' => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'title_text_idle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-nav[class*=wd-style-] > li > a' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_text_hover_color_tab',
			array(
				'label'     => esc_html__( 'Hover', 'woodmart' ),
				'condition' => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->add_control(
			'title_text_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-nav[class*=wd-style-] > li:hover > a' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'type' => array( 'navigation' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} div.product-category .wd-entities-title, {{WRAPPER}} .wd-nav-product-cat>li>a',
			)
		);

		$this->end_controls_section();

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_style_section',
			array(
				'label'     => esc_html__( 'Layout', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'type' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Layout', 'woodmart' ),
				'description' => esc_html__( 'Try out our creative styles for categories block.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'options'     => array(
					'default'       => esc_html__( 'Grid', 'woodmart' ),
					'masonry'       => esc_html__( 'Masonry', 'woodmart' ),
					'masonry-first' => esc_html__( 'Masonry (with first wide)', 'woodmart' ),
					'carousel'      => esc_html__( 'Carousel', 'woodmart' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'woodmart' ),
				'description' => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 4,
				),
				'size_units'  => '',
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					),
				),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'classes'     => 'wd-hide-custom-breakpoints',
				'condition'   => array(
					'style' => array( 'masonry', 'default' ),
				),
			)
		);

		$this->add_control(
			'grid_different_sizes',
			array(
				'label'     => esc_html__( 'Grid items with different sizes', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'ai'        => array(
					'active' => false,
				),
				'condition' => array(
					'style' => array( 'default' ),
				),
			)
		);

		$this->add_responsive_control(
			'spacing',
			array(
				'label'   => esc_html__( 'Space between', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				),
				'default' => '',
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'classes' => 'wd-hide-custom-breakpoints',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		if ( ! woodmart_woocommerce_installed() ) {
			return;
		}

		$default_settings = array(
			// Query.
			'data_source'               => 'custom_query',
			'number'                    => null,
			'orderby'                   => '',
			'order'                     => 'ASC',
			'ids'                       => '',

			'type'                      => 'grid',
			'shop_categories_ancestors' => 'no',
			'show_categories_neighbors' => 'no',
			'images'                    => 'yes',
			'product_count'             => 'yes',
			'mobile_accordion'          => 'on',

			// Layout.
			'columns'                   => array( 'size' => 4 ),
			'columns_tablet'            => array( 'size' => '' ),
			'columns_mobile'            => array( 'size' => '' ),
			'hide_empty'                => 'yes',
			'spacing'                   => woodmart_get_opt( 'products_spacing' ),
			'spacing_tablet'            => woodmart_get_opt( 'products_spacing_tablet', '' ),
			'spacing_mobile'            => woodmart_get_opt( 'products_spacing_mobile', '' ),
			'style'                     => 'default',
			'grid_different_sizes'      => '',

			// Carousel.
			'slides_per_view'           => array( 'size' => 3 ),
			'slides_per_view_tablet'    => array( 'size' => '' ),
			'slides_per_view_mobile'    => array( 'size' => '' ),

			// Design.
			'categories_design'         => woodmart_get_opt( 'categories_design' ),
			'categories_with_shadow'    => woodmart_get_opt( 'categories_with_shadow' ),
			'color_scheme'              => woodmart_get_opt( 'categories_color_scheme' ),

			// Extra.
			'lazy_loading'              => 'no',
			'scroll_carousel_init'      => 'no',
			'custom_sizes'              => apply_filters( 'woodmart_categories_shortcode_custom_sizes', false ),
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), array_merge( woodmart_get_carousel_atts(), $default_settings ) );

		if ( empty( $settings['spacing'] ) && '0' !== $settings['spacing'] && 0 !== $settings['spacing'] ) {
			$settings['spacing'] = woodmart_get_opt( 'products_spacing' );

			if ( '' === $settings['spacing_tablet'] ) {
				$settings['spacing_tablet'] = woodmart_get_opt( 'products_spacing_tablet' );
			}
			if ( '' === $settings['spacing_mobile'] ) {
				$settings['spacing_mobile'] = woodmart_get_opt( 'products_spacing_mobile' );
			}
		}

		if ( 'inherit' === $settings['color_scheme'] || empty( $settings['color_scheme'] ) ) {
			$settings['color_scheme'] = woodmart_get_opt( 'categories_color_scheme' );
		}

		// Query.
		$query_args = array(
			'taxonomy'   => 'product_cat',
			'order'      => $settings['order'],
			'hide_empty' => 'yes' === $settings['hide_empty'],
			'include'    => $settings['ids'],
			'pad_counts' => true,
			'number'     => $settings['number'],
		);

		if ( $settings['orderby'] ) {
			$query_args['orderby'] = $settings['orderby'];
		}

		if ( $settings['mobile_accordion'] ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-nav-mobile-accordion' );
		}

		if ( 'navigation' === $settings['type'] ) {
			woodmart_product_categories_nav( $query_args, $settings );
			return;
		}

		if ( 'wc_query' === $settings['data_source'] ) {
			if ( 'yes' !== $settings['hide_empty'] ) {
				add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );
			}
			$categories = woocommerce_get_product_subcategories( is_product_category() ? get_queried_object_id() : 0 );
		} else {
			$categories = get_terms( $query_args );
		}

		if ( ! $categories ) {
			return;
		}

		// Settings.
		woodmart_set_loop_prop( 'product_categories_color_scheme', $settings['color_scheme'] );
		woodmart_set_loop_prop( 'product_categories_is_element', true );
		woodmart_set_loop_prop( 'products_different_sizes', false );

		if ( ! empty( $settings['img_size'] ) ) {
			woodmart_set_loop_prop( 'product_categories_image_size', $settings['img_size'] );
		}

		if ( isset( $settings['img_size_custom']['width'] ) && ! empty( $settings['img_size_custom']['width'] ) ) {
			woodmart_set_loop_prop( 'product_categories_image_size_custom', $settings['img_size_custom'] );
		}

		if ( 'masonry' === $settings['style'] || 'masonry-first' === $settings['style'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-masonry wd-grid-f-col' );

			if ( 'masonry-first' === $settings['style'] ) {
				woodmart_set_loop_prop( 'products_different_sizes', array( 1 ) );
				$settings['columns']['size'] = 4;

				$this->add_render_attribute( 'wrapper', 'class', 'wd-masonry-first' );
			}

			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		} elseif ( 'default' === $settings['style'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-grid-g' );

			if ( ! empty( $settings['grid_different_sizes'] ) ) {
				woodmart_set_loop_prop( 'grid_items_different_sizes', explode( ',', $settings['grid_different_sizes'] ) );
			}
		}

		if ( 'inherit' === $settings['categories_design'] ) {
			$settings['categories_design'] = woodmart_get_opt( 'categories_design' );
		}

		if ( 'alt' === $settings['categories_design'] && ( ! empty( $settings['image_container_width']['size'] ) || ! empty( $settings['image_container_width_tablet']['size'] ) || ! empty( $settings['image_container_width_mobile']['size'] ) ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-img-width' );
		}

		$settings['columns'] = isset( $settings['columns']['size'] ) ? $settings['columns']['size'] : 4;

		woodmart_set_loop_prop( 'product_categories_design', $settings['categories_design'] );
		if ( ! empty( $settings['categories_with_shadow'] ) ) {
			woodmart_set_loop_prop( 'product_categories_shadow', $settings['categories_with_shadow'] );
		}
		woodmart_set_loop_prop( 'products_columns', $settings['columns'] );
		woodmart_set_loop_prop( 'product_categories_style', $settings['style'] );

		if ( isset( $settings['columns_tablet']['size'] ) && $settings['columns_tablet']['size'] ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $settings['columns_tablet']['size'] );
		}

		if ( isset( $settings['columns_mobile']['size'] ) && $settings['columns_mobile']['size'] ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $settings['columns_mobile']['size'] );
		}

		// Wrapper classes.
		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'wd-cats',
						'products',
						'woocommerce',
						'columns-' . $settings['columns'],
					),
				),
			)
		);

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( woodmart_is_old_category_structure( $settings['categories_design'] ) ) {
			woodmart_set_loop_prop( 'old_structure', true );
		}

		if ( 'alt' !== $settings['categories_design'] && 'inherit' !== $settings['categories_design'] ) {
			woodmart_enqueue_inline_style( 'categories-loop-' . $settings['categories_design'] );
		}

		if ( 'center' === $settings['categories_design'] ) {
			woodmart_enqueue_inline_style( 'categories-loop-center' );
		}

		if ( 'replace-title' === $settings['categories_design'] ) {
			woodmart_enqueue_inline_style( 'categories-loop-replace-title' );
		}

		if ( 'mask-subcat' === $settings['categories_design'] ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-mask-subcat' );
		}

		if ( 'zoom-out' === $settings['categories_design'] ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-zoom-out' );
		}

		if ( 'masonry' === $settings['style'] || 'masonry-first' === $settings['style'] || 'carousel' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-layout-masonry' );
		}

		if ( woodmart_loop_prop( 'old_structure' ) ) {
			woodmart_enqueue_inline_style( 'categories-loop' );
		} else {
			woodmart_enqueue_inline_style( 'woo-categories-loop' );
		}

		?>
		<?php if ( $categories ) : ?>
			<?php if ( 'carousel' === $settings['style'] ) : ?>
				<?php
				$carousel_id                 = 'carousel-' . uniqid();
				$settings['carousel_id']     = $carousel_id;
				$settings['post_type']       = 'product';
				$settings['slides_per_view'] = isset( $settings['slides_per_view']['size'] ) ? $settings['slides_per_view']['size'] : 3;

				if ( ! empty( $settings['carousel_arrows_position'] ) ) {
					$nav_classes = ' wd-pos-' . $settings['carousel_arrows_position'];
				} else {
					$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
				}

				$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

				if ( 'disable' !== $arrows_hover_style ) {
					$nav_classes .= ' wd-hover-' . $arrows_hover_style;
				}

				$this->add_render_attribute(
					array(
						'carousel' => array(
							'class' => array(
								'wd-carousel',
								'wd-grid',
							),
						),
					)
				);

				// Wrapper classes.
				$this->add_render_attribute( 'wrapper', 'class', 'wd-cats-element' );

				if ( 'yes' === $settings['scroll_carousel_init'] ) {
					woodmart_enqueue_js_library( 'waypoints' );
					$this->add_render_attribute( 'carousel', 'class', 'scroll-init' );
				}
				if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
					$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-dis-mb wd-off-md wd-off-sm' );
				}
				$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-container' );
				$this->add_render_attribute( 'wrapper', 'id', $carousel_id );

				if ( ( isset( $settings['slides_per_view_tablet']['size'] ) && ! empty( $settings['slides_per_view_tablet']['size'] ) ) || ( isset( $settings['slides_per_view_mobile']['size'] ) && ! empty( $settings['slides_per_view_mobile']['size'] ) ) ) {
					$settings['custom_sizes'] = array(
						'desktop' => $settings['slides_per_view'],
						'tablet'  => $settings['slides_per_view_tablet']['size'],
						'mobile'  => $settings['slides_per_view_mobile']['size'],
					);
				}

				woodmart_enqueue_js_library( 'swiper' );
				woodmart_enqueue_js_script( 'swiper-carousel' );
				woodmart_enqueue_inline_style( 'swiper' );
				?>

				<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
					<div class="wd-carousel-inner">
						<div <?php echo $this->get_render_attribute_string( 'carousel' ); // phpcs:ignore ?> <?php echo woodmart_get_carousel_attributes( $settings ); // phpcs:ignore ?>>
							<div class="wd-carousel-wrap">
								<?php foreach ( $categories as $category ) : ?>
									<div class="wd-carousel-item">
										<?php
											wc_get_template(
												'content-product-cat.php',
												array(
													'category' => $category,
												)
											);
										?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<?php if ( 'yes' !== $settings['hide_prev_next_buttons'] ) : ?>
							<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
						<?php endif; ?>
					</div>

					<?php woodmart_get_carousel_pagination_template( $settings ); ?>
					<?php woodmart_get_carousel_scrollbar_template( $settings ); ?>
				</div>
			<?php else : ?>
				<?php
				$this->add_render_attribute(
					'wrapper',
					'style',
					woodmart_get_grid_attrs(
						array(
							'columns'        => woodmart_loop_prop( 'products_columns' ),
							'columns_tablet' => woodmart_loop_prop( 'products_columns_tablet' ),
							'columns_mobile' => woodmart_loop_prop( 'products_columns_mobile' ),
							'spacing'        => $settings['spacing'],
							'spacing_tablet' => $settings['spacing_tablet'],
							'spacing_mobile' => $settings['spacing_mobile'],
						)
					)
				);
				?>

				<div class="wd-cats-element">
					<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
						<?php foreach ( $categories as $category ) : ?>
							<?php
							wc_get_template(
								'content-product-cat.php',
								array(
									'category' => $category,
								)
							);
							?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
		woodmart_reset_loop();
		wc_reset_loop();

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_deinit();
		}
	}
}

Plugin::instance()->widgets_manager->register( new Product_Categories() );
