<?php
/**
 * Products brands map.
 *
 * @package xts
 */

namespace XTS\Elementor;

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
class Products_Brands extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_products_brands';
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
		return esc_html__( 'Brands', 'woodmart' );
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
		return 'wd-icon-product-brands';
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
			'number',
			array(
				'label'       => esc_html__( 'Number', 'woodmart' ),
				'description' => esc_html__( 'Enter the number of categories to display for this element.', 'woodmart' ),
				'type'        => Controls_Manager::NUMBER,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order by', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''        => '',
					'name'    => esc_html__( 'Name', 'woodmart' ),
					'term_id' => esc_html__( 'ID', 'woodmart' ),
					'slug'    => esc_html__( 'Slug', 'woodmart' ),
					'random'  => esc_html__( 'Random order', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'       => esc_html__( 'Sort order', 'woodmart' ),
				'description' => 'Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.',
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Inherit', 'woodmart' ),
					'DESC' => esc_html__( 'Descending', 'woodmart' ),
					'ASC'  => esc_html__( 'Ascending', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'Brands', 'woodmart' ),
				'description' => esc_html__( 'List of product brands to show. Leave empty to show all.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_taxonomies_by_query',
				'render'      => 'woodmart_get_taxonomies_title_by_id',
				'taxonomy'    => woodmart_get_opt( 'brands_attribute' ),
				'multiple'    => true,
				'label_block' => true,
			)
		);

		$this->add_control(
			'hide_empty',
			array(
				'label'        => esc_html__( 'Hide empty', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			)
		);

		$this->add_control(
			'filter_in_current_category',
			array(
				'label'        => esc_html__( 'Filter in current category', 'woodmart' ),
				'description'  => esc_html__( ' Enable this option and all brand links will work inside the current category page. Or it will lead to the shop page if you are not on the category page.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'disable_link',
			array(
				'label'        => esc_html__( 'Disable links', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
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
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => array(
					'carousel' => esc_html__( 'Carousel', 'woodmart' ),
					'grid'     => esc_html__( 'Grid', 'woodmart' ),
					'list'     => esc_html__( 'Links List', 'woodmart' ),
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
					'size' => 3,
				),
				'size_units'  => '',
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					),
				),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'classes'     => 'wd-hide-custom-breakpoints',
				'condition'   => array(
					'style' => array( 'grid', 'list' ),
				),
			)
		);

		$this->add_responsive_control(
			'spacing',
			array(
				'label'     => esc_html__( 'Space between', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'' => esc_html__( 'Default', 'woodmart' ),
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				),
				'default'   => '',
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'classes'   => 'wd-hide-custom-breakpoints',
				'condition' => array(
					'brand_style!' => array( 'bordered' ),
				),
			)
		);

		$this->add_responsive_control(
			'padding',
			array(
				'label'     => esc_html__( 'Padding', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-brands' => '--wd-brand-pd: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
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
				'default' => '',
			)
		);

		$this->add_control(
			'brand_style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'woodmart' ),
					'bordered' => esc_html__( 'Bordered', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'with_bg_color',
			array(
				'label'        => esc_html__( 'With background', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'brand_bg_color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-brands' => '--wd-brand-bg: {{VALUE}};',
				),
				'condition' => array(
					'with_bg_color' => array( 'yes' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'images_style_section',
			array(
				'label' => esc_html__( 'Images', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'hover',
			array(
				'label'   => esc_html__( 'Hover', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'simple'  => esc_html__( 'Simple', 'woodmart' ),
					'alt'     => esc_html__( 'Alternate', 'woodmart' ),
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'     => esc_html__( 'Width', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-brands' => '--wd-brand-img-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'     => esc_html__( 'Height', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-brands' => '--wd-brand-img-height: {{SIZE}}{{UNIT}};',
				),
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
		$default_settings = array(
			'username'                   => 'flickr',
			'number'                     => 20,
			'hover'                      => 'default',
			'target'                     => '_self',
			'link'                       => '',
			'ids'                        => '',
			'style'                      => 'carousel',
			'brand_style'                => 'default',
			'align'                      => '',
			'slides_per_view'            => array( 'size' => 3 ),
			'slides_per_view_tablet'     => array( 'size' => '' ),
			'slides_per_view_mobile'     => array( 'size' => '' ),
			'columns'                    => array( 'size' => 3 ),
			'columns_tablet'             => array( 'size' => '' ),
			'columns_mobile'             => array( 'size' => '' ),
			'orderby'                    => '',
			'hide_empty'                 => 0,
			'order'                      => 'ASC',
			'filter_in_current_category' => 'no',
			'disable_link'               => 'no',
			'custom_sizes'               => apply_filters( 'woodmart_brands_shortcode_custom_sizes', false ),
			'with_bg_color'              => 'no',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), array_merge( woodmart_get_carousel_atts(), $default_settings ) );

		$carousel_id = 'brands_' . rand( 1000, 9999 );

		$attribute = woodmart_get_opt( 'brands_attribute' );

		if ( empty( $attribute ) || ! taxonomy_exists( $attribute ) ) {
			echo '<div class="wd-notice wd-info">' . esc_html__( 'You must select your brand attribute in Theme Settings -> Shop -> Brands', 'woodmart' ) . '</div>';
			return;
		}

		$settings['columns']         = isset( $settings['columns']['size'] ) ? $settings['columns']['size'] : 3;
		$settings['slides_per_view'] = isset( $settings['slides_per_view']['size'] ) ? $settings['slides_per_view']['size'] : 3;

		$carousel_attr = '';
		$nav_classes   = '';

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'wd-brands',
						'brands-widget',
						'slider-' . $carousel_id,
						'wd-hover-' . $settings['hover'],
						'wd-style-' . $settings['brand_style'],
					),
					'id'    => array(
						$carousel_id,
					),
				),
			)
		);

		if ( 'yes' === $settings['with_bg_color'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-with-bg' );
		}

		if ( $settings['align'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'text-' . $settings['align'] );
		}

		if ( $settings['style'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-layout-' . $settings['style'] );
		}

		if ( 'carousel' === $settings['style'] ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );

			$settings['scroll_per_page'] = 'yes';
			$settings['carousel_id']     = $carousel_id;

			if ( ! empty( $settings['slides_per_view_tablet']['size'] ) || ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
				$settings['custom_sizes'] = array(
					'desktop' => $settings['slides_per_view'],
					'tablet'  => $settings['slides_per_view_tablet']['size'],
					'mobile'  => $settings['slides_per_view_mobile']['size'],
				);
			}

			$carousel_attr = woodmart_get_carousel_attributes( $settings );

			$this->add_render_attribute( 'items_wrapper', 'class', 'wd-carousel wd-grid' );
			$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-container' );
			$this->add_render_attribute( 'items', 'class', 'wd-carousel-item' );

			if ( 'yes' === $settings['scroll_carousel_init'] ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$this->add_render_attribute( 'items_wrapper', 'class', 'scroll-init' );
			}

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-dis-mb wd-off-md wd-off-sm' );
			}

			if ( ! empty( $settings['carousel_arrows_position'] ) ) {
				$nav_classes = ' wd-pos-' . $settings['carousel_arrows_position'];
			} else {
				$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
			}

			$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

			if ( 'disable' !== $arrows_hover_style ) {
				$nav_classes .= ' wd-hover-' . $arrows_hover_style;
			}
		} else {
			$this->add_render_attribute( 'items_wrapper', 'class', 'wd-grid-g' );
			$this->add_render_attribute( 'items_wrapper', 'style', woodmart_get_grid_attrs( $settings ) );

			$this->add_render_attribute( 'items', 'class', 'wd-col' );
		}

		$args = array(
			'taxonomy'   => $attribute,
			'hide_empty' => $settings['hide_empty'],
			'order'      => $settings['order'],
			'number'     => $settings['number'],
		);

		if ( $settings['orderby'] ) {
			$args['orderby'] = $settings['orderby'];
		}

		if ( 'random' === $settings['orderby'] ) {
			$args['orderby'] = 'id';
			$brand_count     = wp_count_terms(
				$attribute,
				array(
					'hide_empty' => $settings['hide_empty'],
				)
			);

			$offset = rand( 0, $brand_count - (int) $settings['number'] );
			if ( $offset <= 0 ) {
				$offset = '';
			}
			$args['offset'] = $offset;
		}

		if ( $settings['ids'] ) {
			$args['include'] = $settings['ids'];
		}

		$brands   = get_terms( $args );
		$taxonomy = get_taxonomy( $attribute );

		if ( 'random' === $settings['orderby'] ) {
			shuffle( $brands );
		}

		if ( woodmart_is_shop_on_front() ) {
			$link = home_url();
		} elseif ( 'yes' === $settings['filter_in_current_category'] && is_product_category() ) {
			$link = woodmart_get_current_url();
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		woodmart_enqueue_inline_style( 'brands' );

		if ( 'bordered' === $settings['brand_style'] ) {
			woodmart_enqueue_inline_style( 'brands-style-bordered' );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( 'carousel' === $settings['style'] ) : ?>
				<div class="wd-carousel-inner">
			<?php endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'items_wrapper' ); ?> <?php echo $carousel_attr; ?>>
				<?php if ( 'carousel' === $settings['style'] ) : ?>
					<div class="wd-carousel-wrap">
				<?php endif; ?>

				<?php if ( ! is_wp_error( $brands ) && count( $brands ) > 0 ) : ?>
					<?php foreach ( $brands as $key => $brand ) : ?>
						<?php
						$image       = get_term_meta( $brand->term_id, 'image', true );
						$filter_name = 'filter_' . sanitize_title( str_replace( 'pa_', '', $attribute ) );

						if ( is_object( $taxonomy ) && $taxonomy->public ) {
							$attr_link = get_term_link( $brand->term_id, $brand->taxonomy );
						} else {
							$attr_link = add_query_arg( $filter_name, $brand->slug, $link );
						}

						?>

						<div <?php echo $this->get_render_attribute_string( 'items' ); ?>>
							<div class="wd-brand-item brand-item">
								<?php if ( 'list' === $settings['style'] || ! $image || ( is_array( $image ) && empty( $image['id'] ) ) ) : ?>
									<?php if ( 'yes' !== $settings['disable_link'] ) : ?>
										<a title="<?php echo esc_html( $brand->name ); ?>" href="<?php echo esc_url( $attr_link ); ?>">
									<?php endif; ?>

									<?php echo esc_html( $brand->name ); ?>

									<?php if ( 'yes' !== $settings['disable_link'] ) : ?>
										</a>
									<?php endif; ?>
								<?php elseif ( is_array( $image ) ) : ?>
									<?php if ( 'yes' !== $settings['disable_link'] ) : ?>
										<a title="<?php echo esc_html( $brand->name ); ?>" href="<?php echo esc_url( $attr_link ); ?>" class="wd-fill"></a>
									<?php endif; ?>

									<?php echo wp_get_attachment_image( $image['id'], 'full' ); ?>
								<?php else : ?>
									<?php if ( 'yes' !== $settings['disable_link'] ) : ?>
										<a title="<?php echo esc_html( $brand->name ); ?>" href="<?php echo esc_url( $attr_link ); ?>" class="wd-fill"></a>
									<?php endif; ?>

									<?php echo '<img src="' . $image . '" alt="' . $brand->name . '" title="' . $brand->name . '">'; ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if ( 'carousel' === $settings['style'] ) : ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( 'carousel' === $settings['style'] ) : ?>
				<?php if ( 'yes' !== $settings['hide_prev_next_buttons'] ) : ?>
					<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
				<?php endif; ?>

				</div>

				<?php woodmart_get_carousel_pagination_template( $settings ); ?>
				<?php woodmart_get_carousel_scrollbar_template( $settings ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Products_Brands() );
