<?php
/**
 * Nested carousel element.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use  Elementor\Modules\NestedElements\Module as NestedElementsModule;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;
use Elementor\Plugin;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Nested_Carousel extends Widget_Nested_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_nested_carousel';
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
		return esc_html__( 'Nested carousel', 'woodmart' );
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
		return 'wd-icon-nested-carousel';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'nested', 'carousel' );
	}

	public function show_in_panel() {
		return Plugin::$instance->experiments->is_feature_active( 'nested-elements' );
	}

	protected function slide_content_container( int $index ) {
		return array(
			'elType'   => 'container',
			'settings' => array(
				'_title'        => sprintf(
					// translators: %s Slide index.
					esc_html__( 'Slide #%s', 'woodmart' ),
					$index
				),
				'content_width' => 'full',
			),
		);
	}

	protected function get_default_children_elements() {
		return array(
			$this->slide_content_container( 1 ),
			$this->slide_content_container( 2 ),
			$this->slide_content_container( 3 ),
		);
	}

	protected function get_default_repeater_title_setting_key() {
		return 'slide_title';
	}

	protected function get_default_children_title() {
		return esc_html__( 'Slide #%d', 'woodmart' );
	}

	protected function get_default_children_placeholder_selector() {
		return '.wd-carousel-wrap';
	}

	protected function get_html_wrapper_class() {
		return 'wd-nested-carousel';
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'slide_title',
			array(
				'label'       => esc_html__( 'Slide title', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Slide title', 'woodmart' ),
				'placeholder' => esc_html__( 'Slide title', 'woodmart' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'woodmart' ),
				'type'        => Control_Nested_Repeater::CONTROL_TYPE,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slide_title' => esc_html__( 'Slide #1', 'woodmart' ),
					),
					array(
						'slide_title' => esc_html__( 'Slide #2', 'woodmart' ),
					),
					array(
						'slide_title' => esc_html__( 'Slide #3', 'woodmart' ),
					),
				),
				'title_field' => '{{{ slide_title }}}',
				'button_text' => 'Add Slide',
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
		$settings                   = wp_parse_args( $this->get_settings_for_display(), woodmart_get_carousel_atts() );
		$slides                     = $settings['slides'];
		$slide_content_html         = '';
		$carousel_container_classes = '';
		$carousel_classes           = '';
		$carousel_atts              = array(
			'slides_per_view' => $settings['slides_per_view'] ? $settings['slides_per_view']['size'] : 1,
			'scroll_per_page' => $settings['scroll_per_page'],
			'center_mode'     => $settings['center_mode'],
			'wrap'            => $settings['wrap'],
			'autoplay'        => $settings['autoplay'],
			'speed'           => $settings['speed'],
			'spacing'         => $settings['slider_spacing'],
			'spacing_tablet'  => isset( $settings['slider_spacing_tablet'] ) ? $settings['slider_spacing_tablet'] : '',
			'spacing_mobile'  => isset( $settings['slider_spacing_mobile'] ) ? $settings['slider_spacing_mobile'] : '',
		);

		if ( ! empty( $settings['slides_per_view_tablet']['size'] ) ) {
			$carousel_atts['slides_per_view_tablet'] = $settings['slides_per_view_tablet']['size'];
		}

		if ( ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
			$carousel_atts['slides_per_view_mobile'] = $settings['slides_per_view_mobile']['size'];
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

		foreach ( $slides as $index => $item ) {
			// Slide content.
			$children = $this->get_children();

			if ( ! empty( $children[ $index ] ) ) {
				ob_start();

				$children[ $index ]->add_render_attribute( '_wrapper', 'class', 'wd-carousel-item' );
				$children[ $index ]->print_element();

				$slide_content_html .= ob_get_clean();
			}
		}

		if ( 'yes' === $settings['scroll_carousel_init'] ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$carousel_classes .= ' scroll-init';
		}

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );
		?>
		<div class="wd-nested-carousel wd-carousel-container <?php echo esc_attr( $carousel_container_classes ); ?>">
			<div class="wd-carousel-inner">
				<div class="wd-carousel wd-grid<?php echo esc_attr( $carousel_classes ); ?>" <?php echo woodmart_get_carousel_attributes( $carousel_atts ); // phpcs:ignore ?>>
					<div class="wd-carousel-wrap">
						<?php echo $slide_content_html; // phpcs:ignore ?>
					</div>
				</div>

				<?php if ( 'yes' !== $settings['hide_prev_next_buttons'] ) : ?>
					<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
				<?php endif; ?>
			</div>

			<?php woodmart_get_carousel_pagination_template( $settings ); ?>
			<?php woodmart_get_carousel_scrollbar_template( $settings ); ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<# if ( settings['slides'] ) {
			const elementUid = view.getIDInt().toString().substr( 0, 3 );
			const carouselOutsideWrapperKey = 'wd-carousel-wrapper-' + elementUid;
			const carouselInsideWrapperKey = 'wd-carousel-' + elementUid;
			const carouselPaginWrapperKey = 'wd-carousel-pagin-' + elementUid;
			const carouselScrollBarWrapperKey = 'wd-carousel-scrollBar-' + elementUid;
			const carouselArrowsWrapperKey = 'wd-carousel-arrows-' + elementUid;
			const arrowsHoverStyle = '<?php echo esc_attr( woodmart_get_opt( 'carousel_arrows_hover_style', '1' ) ); ?>';
			const arrowsIconType = '<?php echo esc_attr( woodmart_get_opt( 'carousel_arrows_icon_type', '1' ) ); ?>';
			const autoColumns = <?php echo wp_json_encode( $this->get_auto_column() ); ?>;
			const desktopCol = settings['slides_per_view']['size'] ? settings['slides_per_view']['size'] : 1;
			const autoCol = autoColumns[Math.floor(desktopCol)];
			const tabletCol = 'undefined' !== typeof settings['slides_per_view_tablet']['size'] && settings['slides_per_view_tablet']['size'] ? settings['slides_per_view_tablet']['size'] : autoCol.tablet;
			const mobileCol = 'undefined' !== typeof settings['slides_per_view_mobile']['size'] && settings['slides_per_view_mobile']['size'] ? settings['slides_per_view_mobile']['size'] : autoCol.mobile;

			view.addRenderAttribute( carouselOutsideWrapperKey, {
				'class': 'wd-carousel-container',
			} );

			view.addRenderAttribute( carouselInsideWrapperKey, {
				'class': 'wd-carousel wd-grid',
			} );

			if ( desktopCol ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-col-lg:' + desktopCol + ';' );
			}
			if ( tabletCol ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-col-md:' + tabletCol + ';' );
			}
			if ( mobileCol ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-col-sm:' + mobileCol + ';' );
			}

			if ( settings['slider_spacing'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-gap-lg:' + settings['slider_spacing'] + 'px;' );
			}
			if ( 'undefined' !== typeof settings['slider_spacing_tablet'] && settings['slider_spacing_tablet'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-gap-md:' + settings['slider_spacing_tablet'] + 'px;' );
			}
			if ( 'undefined' !== typeof settings['slider_spacing_mobile'] && settings['slider_spacing_mobile'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-gap-sm:' + settings['slider_spacing_tablet'] + 'px;' );
			}

			if ( 'yes' === settings['disable_overflow_carousel'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'style', '--wd-carousel-overflow: visible;' );
			}
			if ( 'yes' === settings['scroll_per_page'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-scroll_per_page', 'yes' );
			}
			if ( 'yes' === settings['center_mode'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-center_mode', 'yes' );
			}
			if ( 'yes' === settings['wrap'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-wrap', 'yes' );
			}
			if ( 'yes' === settings['autoheight'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-autoheight', 'yes' );
			}

			if ( 'yes' === settings['autoplay'] ) {
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-autoplay', 'yes' );
				view.addRenderAttribute( carouselInsideWrapperKey, 'data-speed', settings['speed'] );
			}

			view.addRenderAttribute( carouselArrowsWrapperKey, {
				'class': 'wd-nav-arrows',
			});

			if ( 'undefined' !== typeof settings['carousel_arrows_position'] && settings['carousel_arrows_position'] ) {
				view.addRenderAttribute( carouselArrowsWrapperKey, 'class', 'wd-pos-' + settings['carousel_arrows_position'] );
			} else {
				view.addRenderAttribute( carouselArrowsWrapperKey, 'class', 'wd-pos-<?php echo esc_attr( woodmart_get_opt( 'carousel_arrows_position', 'sep' ) ); ?>' );
			}

			if ( arrowsHoverStyle && 'disable' !== arrowsHoverStyle ) {
				view.addRenderAttribute( carouselArrowsWrapperKey, 'class', 'wd-hover-' + arrowsHoverStyle );
			}

			view.addRenderAttribute( carouselArrowsWrapperKey, 'class', 'wd-icon-' + arrowsIconType );

			view.addRenderAttribute( carouselPaginWrapperKey, {
				'class': 'wd-nav-pagin-wrap wd-style-shape text-center',
			} );

			if ( 'undefined' !== typeof settings['dynamic_pagination_control'] && 'yes' === settings['dynamic_pagination_control'] ) {
				view.addRenderAttribute( carouselPaginWrapperKey, 'class', 'wd-dynamic' );
			}

			if ( 'yes' === settings['hide_pagination_control'] ) {
				view.addRenderAttribute( carouselPaginWrapperKey, 'class', 'wd-hide-lg' );
			}
			if ( 'yes' === settings['hide_pagination_control_tablet'] ) {
				view.addRenderAttribute( carouselPaginWrapperKey, 'class', 'wd-hide-md-sm' );
			}
			if ( 'yes' === settings['hide_pagination_control_mobile'] ) {
				view.addRenderAttribute( carouselPaginWrapperKey, 'class', 'wd-hide-sm' );
			}

			view.addRenderAttribute( carouselScrollBarWrapperKey, {
				'class': 'wd-nav-scroll',
			} );

			if ( 'yes' === settings['hide_scrollbar'] ) {
				view.addRenderAttribute( carouselScrollBarWrapperKey, 'class', 'wd-hide-lg' );
			}
			if ( 'yes' === settings['hide_scrollbar_tablet'] ) {
				view.addRenderAttribute( carouselScrollBarWrapperKey, 'class', 'wd-hide-md-sm' );
			}
			if ( 'yes' === settings['hide_scrollbar_mobile'] ) {
				view.addRenderAttribute( carouselScrollBarWrapperKey, 'class', 'wd-hide-sm' );
			}

			#>
			<div {{{ view.getRenderAttributeString( carouselOutsideWrapperKey ) }}}>
				<div class="wd-carousel-inner">
					<div {{{ view.getRenderAttributeString( carouselInsideWrapperKey ) }}}>
						<div class="wd-carousel-wrap"></div>
					</div>
					<# if ( 'yes' !== settings['hide_prev_next_buttons'] ) { #>
						<div {{{ view.getRenderAttributeString( carouselArrowsWrapperKey ) }}}>
							<div class="wd-btn-arrow wd-prev wd-disabled">
								<div class="wd-arrow-inner"></div>
							</div>
							<div class="wd-btn-arrow wd-next">
								<div class="wd-arrow-inner"></div>
							</div>
						</div>
					<# } #>
				</div>
				<# if ( 'yes' !== settings['hide_pagination_control'] || 'yes' !== settings['hide_pagination_control_tablet'] || 'yes' !== settings['hide_pagination_control_mobile'] ) { #>
					<div {{{ view.getRenderAttributeString( carouselPaginWrapperKey ) }}}>
						<ul class="wd-nav-pagin"></ul>
					</div>
				<# } #>

				<# if ( 'yes' !== settings['hide_scrollbar'] || 'yes' !== settings['hide_scrollbar_tablet'] || 'yes' !== settings['hide_scrollbar_mobile'] ) { #>
					<div {{{ view.getRenderAttributeString( carouselScrollBarWrapperKey ) }}}></div>
				<# } #>
			</div>
		<# } #>
		<?php
	}

	/**
	 * Get auto columns.
	 *
	 * @return array
	 */
	private function get_auto_column() {
		$auto_column = array();

		foreach ( range( 1, 12 ) as $number ) {
			$auto_column[ $number ] = woodmart_get_col_sizes( $number );
		}

		return $auto_column;
	}
}

if ( Plugin::$instance->experiments->is_feature_active( 'nested-elements' ) ) {
	Plugin::instance()->widgets_manager->register( new Nested_Carousel() );
}
