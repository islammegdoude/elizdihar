<?php
/**
 * Instagram map.
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
class Instagram extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_instagram';
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
		return esc_html__( 'Instagram', 'woodmart' );
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
		return 'wd-icon-instagram';
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
		return [ 'wd-elements' ];
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
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
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
			[
				'label'       => esc_html__( 'Source type', 'woodmart' ),
				'description' => 'API request type<br>
Scrape - parse Instagram page and take photos by username. Now deprecated and may be blocked by Instagram.<br>
AJAX - send AJAX request to the Instagram page on frontend. Works more stable then simple scrape.<br>
API - the best safe and legal option to obtain Instagram photos. Requires Instagram APP configuration. <br>
Follow our documentation <a href="https://xtemos.com/docs/woodmart/faq-guides/setup-instagram-api/" target="_blank">here</a>',
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'scrape' => esc_html__( 'Scrape (deprecated)', 'woodmart' ),
					'ajax'   => esc_html__( 'AJAX (deprecated)', 'woodmart' ),
					'api'    => esc_html__( 'API', 'woodmart' ),
					'images' => esc_html__( 'Images', 'woodmart' ),
				],
				'default'     => 'scrape',
			]
		);

		$this->add_control(
			'size',
			[
				'label'       => esc_html__( 'Photo size', 'woodmart' ),
				'description' => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\'. Leave empty to use \'medium\' size.', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'medium',
				'condition'   => [
					'data_source!' => [ 'images' ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Images settings.
		 */
		$this->start_controls_section(
			'images_section',
			[
				'label'     => esc_html__( 'Images', 'woodmart' ),
				'condition' => [
					'data_source' => [ 'images' ],
				],
			]
		);

		$this->add_control(
			'images',
			[
				'label'   => esc_html__( 'Images', 'woodmart' ),
				'type'    => Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'images_size',
			[
				'label'       => esc_html__( 'Images size', 'woodmart' ),
				'description' => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\'. Leave empty to use \'thumbnail\' size.', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'thumbnail',
			]
		);

		$this->add_control(
			'images_link',
			[
				'label' => esc_html__( 'Images link', 'woodmart' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'images_likes',
			[
				'label'       => esc_html__( 'Likes limit', 'woodmart' ),
				'description' => esc_html__( 'Example: 1000-10000', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1000-10000',
			]
		);

		$this->add_control(
			'images_comments',
			[
				'label'       => esc_html__( 'Comments limit', 'woodmart' ),
				'description' => esc_html__( 'Example: 0-1000', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '0-1000',
			]
		);

		$this->end_controls_section();

		/**
		 * Content settings.
		 */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'woodmart' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Instagram text', 'woodmart' ),
				'type'  => Controls_Manager::WYSIWYG,
			]
		);

		$this->end_controls_section();

		/**
		 * Link settings.
		 */
		$this->start_controls_section(
			'link_section',
			[
				'label' => esc_html__( 'Link', 'woodmart' ),
			]
		);

		$this->add_control(
			'username',
			[
				'label'   => esc_html__( 'Username', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'flickr',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link text', 'woodmart' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'target',
			[
				'label'   => esc_html__( 'Open link in', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'_self'  => esc_html__( 'Current window (_self)', 'woodmart' ),
					'_blank' => esc_html__( 'New window (_blank)', 'woodmart' ),
				],
				'default' => '_self',
			]
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_content_section',
			[
				'label' => esc_html__( 'Layout', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'design',
			[
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'grid'   => esc_html__( 'Grid', 'woodmart' ),
					'slider' => esc_html__( 'Carousel', 'woodmart' ),
				],
				'default' => 'grid',
			]
		);

		$this->add_responsive_control(
			'per_row',
			[
				'label'      => esc_html__( 'Photos per row', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 3,
				],
				'size_units' => '',
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					],
				],
				'devices'    => array( 'desktop', 'tablet', 'mobile' ),
				'classes'    => 'wd-hide-custom-breakpoints',
			]
		);

		$this->add_control(
			'number',
			[
				'label'      => esc_html__( 'Number of photos', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 9,
				],
				'size_units' => '',
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 25,
						'step' => 1,
					],
				],
				'condition'  => array(
					'data_source!' => 'images',
				),
			]
		);

		$this->add_control(
			'spacing',
			[
				'label'        => esc_html__( 'Add spaces between photos', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			]
		);

		$this->add_responsive_control(
			'spacing_custom',
			[
				'label'     => esc_html__( 'Space between', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				],
				'default'   => 6,
				'condition' => [
					'spacing' => '1',
				],
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'classes'   => 'wd-hide-custom-breakpoints',
			]
		);

		$this->add_control(
			'hide_mask',
			[
				'label'        => esc_html__( 'Hide likes and comments', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'images_content_section',
			[
				'label' => esc_html__( 'Images', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rounded',
			array(
				'label'        => esc_html__( 'Rounded corners for images', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
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
					'{{WRAPPER}}' => '--wd-brd-radius: {{VALUE}}px;',
				),
				'condition' => array(
					'rounded!' => '1',
				),
			)
		);

		$this->add_control(
			'custom_rounding_size',
			array(
				'label'      => esc_html__( 'Custom rounding', 'woodmart' ),
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
					'{{WRAPPER}}' => '--wd-brd-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rounded!'      => '1',
					'rounding_size' => array( 'custom' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_width',
			array(
				'label'      => esc_html__( 'Content width', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wd-insta-cont-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_color_scheme',
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
			'content_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-insta-cont-inner' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'content_bg_color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-insta-cont-inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-insta-cont-inner',
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
		woodmart_elementor_instagram_template( $this->get_settings_for_display() );
	}
}

Plugin::instance()->widgets_manager->register( new Instagram() );
