<?php
/**
 * Testimonials map.
 *
 * @package woodmart
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
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
class Testimonials extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_testimonials';
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
		return esc_html__( 'Testimonials', 'woodmart' );
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
		return 'wd-icon-testimonials';
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

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label' => esc_html__( 'Choose image', 'woodmart' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Eric Watson',
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Web Developer',
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label' => esc_html__( 'Text', 'woodmart' ),
				'type'  => Controls_Manager::WYSIWYG,
			)
		);

		$this->add_control(
			'items_repeater',
			array(
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__( 'Items', 'woodmart' ),
				'separator'   => 'before',
				'title_field' => '{{{ name }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'   => 'Environmental Economist',
						'name'    => 'Kingsley Chandler',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					),
					array(
						'title'   => 'Healthcare Social Worker',
						'name'    => 'Orson Lancaster',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					),
					array(
						'title'   => 'Logistician',
						'name'    => 'Harleigh Dodson',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					),
					array(
						'title'   => 'Floor Refinisher',
						'name'    => 'Darin Coulson',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					),
				),
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
			'woodmart_color_scheme',
			array(
				'label'   => esc_html__( 'Color Scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'standard' => esc_html__( 'Standard', 'woodmart' ),
					'boxed'    => esc_html__( 'Boxed', 'woodmart' ),
					'info-top' => esc_html__( 'Information top', 'woodmart' ),
				),
				'default' => 'standard',
			)
		);

		$this->add_control(
			'text_color_normal',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .wd-testimon .wd-testimon-text' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'style' => 'info-top',
				),
			)
		);

		$this->add_control(
			'text_background_color_normal',
			array(
				'label'     => esc_html__( 'Text background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .wd-testimon .wd-testimon-text'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wd-testimon .wd-testimon-text:before' => 'border-bottom-color: {{VALUE}};',
				),
				'condition' => array(
					'style' => 'info-top',
				),
			)
		);

		$this->add_control(
			'text_size',
			array(
				'label'   => esc_html__( 'Text size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''       => esc_html__( 'Default', 'woodmart' ),
					'small'  => esc_html__( 'Small (14px)', 'woodmart' ),
					'medium' => esc_html__( 'Medium (16px)', 'woodmart' ),
					'large'  => esc_html__( 'Large (18px)', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'     => esc_html__( 'Align', 'woodmart' ),
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
					'style!' => 'info-top',
				),
				'default'   => 'center',
			)
		);

		$this->add_control(
			'stars_rating',
			array(
				'label'        => esc_html__( 'Display stars rating', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_style_section',
			array(
				'label' => esc_html__( 'Layout', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'slider' => esc_html__( 'Carousel', 'woodmart' ),
					'grid'   => esc_html__( 'Grid', 'woodmart' ),
				),
				'default' => 'slider',
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
					'layout' => 'grid',
				),
			)
		);

		$this->add_responsive_control(
			'spacing',
			array(
				'label'   => esc_html__( 'Space between', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				),
				'default' => 30,
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
	 * @since  1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_settings = array(
			'layout'                 => 'slider',
			'woodmart_color_scheme'  => '',
			'style'                  => 'standard',
			'align'                  => 'center',
			'text_size'              => '',
			'columns'                => array( 'size' => 3 ),
			'columns_tablet'         => array( 'size' => '' ),
			'columns_mobile'         => array( 'size' => '' ),
			'spacing'                => 30,
			'spacing_tablet'         => '',
			'spacing_mobile'         => '',
			'name'                   => '',
			'title'                  => '',
			'stars_rating'           => 'yes',
			'custom_sizes'           => apply_filters( 'woodmart_testimonials_shortcode_custom_sizes', false ),
			'items_repeater'         => array(),

			// Carousel.
			'slides_per_view'        => array( 'size' => 3 ),
			'slides_per_view_tablet' => array( 'size' => '' ),
			'slides_per_view_mobile' => array( 'size' => '' ),
		);

		$settings                    = wp_parse_args( $this->get_settings_for_display(), array_merge( woodmart_get_carousel_atts(), $default_settings ) );
		$settings['columns']         = isset( $settings['columns']['size'] ) ? $settings['columns']['size'] : 3;
		$settings['slides_per_view'] = isset( $settings['slides_per_view']['size'] ) ? $settings['slides_per_view']['size'] : 3;
		$carousel_attr               = '';
		$carousel_id                 = 'carousel-' . wp_rand( 1000, 10000 );
		$items_classes               = '';
		$nav_classes                 = '';

		$this->add_render_attribute(
			array(
				'wrapper'  => array(
					'class' => array(
						'testimonials',
						'testimon-style-' . $settings['style'],
						woodmart_get_new_size_classes( 'testimonials', $settings['text_size'], 'text' ),
						'color-scheme-' . $settings['woodmart_color_scheme'],
					),
					'id'    => array(
						$carousel_id,
					),
				),
			)
		);

		if ( 'yes' === $settings['stars_rating'] ) {
			woodmart_enqueue_inline_style( 'mod-star-rating' );

			$this->add_render_attribute( 'wrapper', 'class', 'testimon-with-rating' );
		}

		if ( 'info-top' !== $settings['style'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'testimon-align-' . $settings['align'] );
		}

		if ( 'slider' === $settings['layout'] ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );

			$settings['carousel_id'] = $carousel_id;

			if ( ! empty( $settings['slides_per_view_tablet']['size'] ) || ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
				$settings['custom_sizes'] = array(
					'desktop' => $settings['slides_per_view'],
					'tablet'  => $settings['slides_per_view_tablet']['size'],
					'mobile'  => $settings['slides_per_view_mobile']['size'],
				);
			}

			$items_classes .= ' wd-carousel-item';
			$carousel_attr  = woodmart_get_carousel_attributes( $settings );
			$this->add_render_attribute( 'carousel', 'class', 'wd-carousel' );
			$this->add_render_attribute( 'carousel', 'class', 'wd-grid' );

			$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-container' );

			if ( 'yes' === $settings['scroll_carousel_init'] ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$this->add_render_attribute( 'carousel', 'class', 'scroll-init' );
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
			$this->add_render_attribute( 'carousel', 'class', 'wd-grid-g' );
			$this->add_render_attribute( 'carousel', 'style', woodmart_get_grid_attrs( $settings ) );

			$items_classes = ' wd-col';
		}

		if ( 'info-top' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'testimonial' );
		} else {
			woodmart_enqueue_inline_style( 'testimonial-old' );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
			<?php if ( 'slider' === $settings['layout'] ) : ?>
				<div class="wd-carousel-inner">
			<?php endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'carousel' ); // phpcs:ignore ?> <?php echo $carousel_attr; // phpcs:ignore ?>>
				<?php if ( 'slider' === $settings['layout'] ) : ?>
					<div class="wd-carousel-wrap">
				<?php endif; ?>

				<?php foreach ( $settings['items_repeater'] as $item ) : ?>
					<?php
					$image_output = '';

					if ( isset( $item['image']['id'] ) && $item['image']['id'] ) {
						$image_url    = woodmart_otf_get_image_url( $item['image']['id'], $item['image_size'], $item['image_custom_dimension'] );
						$image_output = apply_filters( 'woodmart_image', '<img src="' . esc_url( $image_url ) . '" class="testimonial-avatar-image">' );
					}

					$template_name = 'default.php';

					if ( 'info-top' === $settings['style'] ) {
						$template_name = 'info-top.php';
					}

					woodmart_get_element_template(
						'testimonials',
						array(
							'image'        => $image_output,
							'title'        => $item['title'],
							'name'         => $item['name'],
							'content'      => $item['content'],
							'item_classes' => $items_classes,
						),
						$template_name
					);
					?>
				<?php endforeach; ?>

				<?php if ( 'slider' === $settings['layout'] ) : ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( 'slider' === $settings['layout'] ) : ?>
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

Plugin::instance()->widgets_manager->register( new Testimonials() );
