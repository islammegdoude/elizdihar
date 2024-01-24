<?php
/**
 * Menu price map.
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
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
class Menu_Price extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_menu_price';
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
		return esc_html__( 'Menu price', 'woodmart' );
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
		return 'wd-icon-menu-price';
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
			'title',
			array(
				'label'   => esc_html__( 'Title', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Weight Watchers General Tso\'s Chicken',
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'In a medium bowl, whisk together broth, cornstarch, sugar, soy sauce, vinegar and ginger; set aside.',
			)
		);

		$this->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$399.00',
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link', 'woodmart' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$this->add_control(
			'image',
			array(
				'label' => esc_html__( 'Choose image', 'woodmart' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
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
			'image'       => '',
			'title'       => '',
			'description' => '',
			'price'       => '',
			'link'        => array(
				'url'         => '',
				'is_external' => '',
			),
		);

		$settings     = wp_parse_args( $this->get_settings_for_display(), $default_settings );
		$image_output = '';

		$this->add_render_attribute(
			array(
				'wrapper'     => array(
					'class' => array(
						'wd-menu-price',
						woodmart_get_old_classes( 'woodmart-menu-price' ),
					),
				),
				'price'       => array(
					'class' => array(
						'menu-price-price',
						'price',
					),
				),
				'description' => array(
					'class' => array(
						'menu-price-details',
					),
				),
			)
		);

		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'price' );
		$this->add_inline_editing_attributes( 'description' );

		// Image settings.
		if ( isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$image_output = '<span class="img-wrapper">' . woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] ) . '</span>';
		}

		// Link settings.
		if ( $settings['link'] && $settings['link']['url'] ) {
			$this->add_link_attributes( 'link', $settings['link'] );
			$this->add_render_attribute( 'link', 'class', 'wd-menu-price-link wd-fill' );
			$this->add_render_attribute( 'link', 'aria-label', esc_html__( 'Menu price link', 'woodmart' ) );

			$this->add_render_attribute( 'wrapper', 'class', 'wd-with-link' );
		}

		woodmart_enqueue_inline_style( 'menu-price' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $image_output ) : ?>
				<div class="menu-price-image">
					<?php echo $image_output; ?>
				</div>
			<?php endif ?>

			<div class="menu-price-desc-wrapp">
				<div class="menu-price-heading">
					<?php if ( $settings['title'] ) : ?>
						<h3 class="menu-price-title wd-entities-title">
							<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
								<?php echo wp_kses( $settings['title'], woodmart_get_allowed_html() ); ?>
							</span>
						</h3>
					<?php endif ?>

					<div <?php echo $this->get_render_attribute_string( 'price' ); ?>>
						<?php echo wp_kses( $settings['price'], woodmart_get_allowed_html() ); ?>
					</div>
				</div>

				<?php if ( $settings['description'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
						<?php echo do_shortcode( $settings['description'] ); ?>
					</div>
				<?php endif ?>
			</div>

			<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
				<a <?php echo $this->get_render_attribute_string( 'link' )?>></a>
			<?php endif; ?>

		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Menu_Price() );
