<?php
/**
 * Team member map.
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
class Team_Member extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_team_member';
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
		return esc_html__( 'Team member', 'woodmart' );
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
		return 'wd-icon-team-member';
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
			'image',
			array(
				'label'   => esc_html__( 'Choose image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
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

		$this->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Eric Watson',
			)
		);

		$this->add_control(
			'position',
			array(
				'label'   => esc_html__( 'Position', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Web Developer',
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Content', 'woodmart' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
			)
		);

		$this->end_controls_section();

		/**
		 * Links settings.
		 */
		$this->start_controls_section(
			'links_content_section',
			array(
				'label' => esc_html__( 'Social links', 'woodmart' ),
			)
		);

		$this->add_control(
			'facebook',
			array(
				'label'   => esc_html__( 'Facebook link', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
			)
		);

		$this->add_control(
			'twitter',
			array(
				'label'   => esc_html__( 'X link', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
			)
		);

		$this->add_control(
			'linkedin',
			array(
				'label'   => esc_html__( 'Linkedin link', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
			)
		);

		$this->add_control(
			'skype',
			array(
				'label'   => esc_html__( 'Skype link', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
			)
		);

		$this->add_control(
			'instagram',
			array(
				'label'   => esc_html__( 'Instagram link', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
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
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'hover'   => esc_html__( 'Hover', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Align', 'woodmart' ),
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
				'default' => 'left',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .team-member .member-name',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'label'    => esc_html__( 'Position typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .team-member .member-position',
			)
		);

		$this->end_controls_section();

		/**
		 * Buttons settings.
		 */
		$this->start_controls_section(
			'buttons_style_section',
			array(
				'label' => esc_html__( 'Social buttons', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'size',
			array(
				'label'   => esc_html__( 'Size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default (18px)', 'woodmart' ),
					'small'   => esc_html__( 'Small (14px)', 'woodmart' ),
					'large'   => esc_html__( 'Large (22px)', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'     => esc_html__( 'Default', 'woodmart' ),
					'simple'      => esc_html__( 'Simple', 'woodmart' ),
					'colored'     => esc_html__( 'Colored', 'woodmart' ),
					'colored-alt' => esc_html__( 'Colored alternative', 'woodmart' ),
					'bordered'    => esc_html__( 'Bordered', 'woodmart' ),
					'primary'     => esc_html__( 'Primary color', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'form',
			array(
				'label'   => esc_html__( 'Form', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'circle'  => esc_html__( 'Circle', 'woodmart' ),
					'square'  => esc_html__( 'Square', 'woodmart' ),
					'rounded' => esc_html__( 'Rounded', 'woodmart' ),
				),
				'default' => 'circle',
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
			'align'                 => 'left',
			'name'                  => '',
			'position'              => '',
			'twitter'               => '',
			'facebook'              => '',
			'skype'                 => '',
			'linkedin'              => '',
			'instagram'             => '',
			'image'                 => '',
			'style'                 => 'default', // Circle colored.
			'size'                  => 'default', // Circle colored.
			'form'                  => 'circle',
			'woodmart_color_scheme' => '',
			'layout'                => 'default',
		);

		$settings     = wp_parse_args( $this->get_settings_for_display(), $default_settings );
		$image_output = '';

		$this->add_render_attribute(
			array(
				'wrapper'  => array(
					'class' => array(
						'team-member',
						'member-layout-' . $settings['layout'],
						! empty( $settings['align'] ) ? 'text-' . $settings['align'] : '',
					),
				),
				'name'     => array(
					'class' => array(
						'member-name',
					),
				),
				'position' => array(
					'class' => array(
						'member-position',
					),
				),
				'content'  => array(
					'class' => array(
						'member-bio',
					),
				),
				'social'   => array(
					'class' => array(
						'wd-social-icons',
						woodmart_get_old_classes( ' woodmart-social-icons' ),
						'icons-design-' . $settings['style'],
						'icons-size-' . $settings['size'],
						'social-form-' . $settings['form'],
					),
				),
			)
		);

		if ( $settings['woodmart_color_scheme'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'color-scheme-' . $settings['woodmart_color_scheme'] );
		}

		$this->add_inline_editing_attributes( 'name' );
		$this->add_inline_editing_attributes( 'position' );
		$this->add_inline_editing_attributes( 'content' );

		// Image settings.
		if ( isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$image_output = woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] );
		} elseif ( isset( $settings['image']['url'] ) ) {
			$image_output = '<img src="' . esc_url( $settings['image']['url'] ) . '">';
		}

		woodmart_enqueue_inline_style( 'social-icons' );
		woodmart_enqueue_inline_style( 'team-member' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $image_output && ( ! empty( $settings['image']['id'] ) || ! empty( $settings['image']['url'] ) ) ) : ?>
				<div class="member-image-wrapper">
					<div class="member-image">
						<?php echo $image_output; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="member-details set-mb-s reset-last-child">
				<?php if ( $settings['name'] ) : ?>
					<h4 <?php echo $this->get_render_attribute_string( 'name' ); ?>>
						<?php echo esc_attr( $settings['name'] ); ?>
					</h4>
				<?php endif; ?>

				<?php if ( $settings['position'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'position' ); ?>>
						<?php echo esc_attr( $settings['position'] ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $settings['content'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
						<?php echo do_shortcode( $settings['content'] ); ?>
					</div>
				<?php endif; ?>

				<?php $this->show_member_social( $settings ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render member-social.
	 *
	 * @param array $settings Settings list.
	 *
	 * @return string|void
	 */
	protected function show_member_social( $settings ) {
		if ( ! $settings['facebook'] && ! $settings['twitter'] && ! $settings['linkedin'] && ! $settings['skype'] && ! $settings['instagram'] ) {
			return '';
		}

		?>
		<div class="member-social">
			<div <?php echo $this->get_render_attribute_string( 'social' ); // phpcs:ignore. ?>>
				<?php if ( $settings['facebook'] ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-facebook" href="<?php echo esc_url( $settings['facebook'] ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>

				<?php if ( $settings['twitter'] ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-twitter" href="<?php echo esc_url( $settings['twitter'] ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>

				<?php if ( $settings['linkedin'] ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-linkedin" href="<?php echo esc_url( $settings['linkedin'] ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>

				<?php if ( $settings['skype'] ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-skype" href="<?php echo esc_url( $settings['skype'] ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>

				<?php if ( $settings['instagram'] ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-instagram" href="<?php echo esc_url( $settings['instagram'] ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Team_Member() );
