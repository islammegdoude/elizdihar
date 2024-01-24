<?php
/**
 * Banner template function.
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_elementor_infobox_carousel_template' ) ) {
	function woodmart_elementor_infobox_carousel_template( $settings, $element ) {
		$default_settings = array(
			'content_repeater'       => array(),

			// Carousel.
			'slides_per_view'        => array( 'size' => 4 ),
			'slides_per_view_tablet' => array( 'size' => '' ),
			'slides_per_view_mobile' => array( 'size' => '' ),
			'slider_spacing'         => 30,
			'slider_spacing_tablet'  => '',
			'slider_spacing_mobile'  => '',
			'custom_sizes'           => apply_filters( 'woodmart_info_box_shortcode_custom_sizes', false ),
		);

		$settings           = wp_parse_args( $settings, array_merge( woodmart_get_carousel_atts(), $default_settings ) );
		$wrapper_classes    = '';
		$extra_classes      = '';
		$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

		if ( ! empty( $settings['carousel_arrows_position'] ) ) {
			$nav_classes = ' wd-pos-' . $settings['carousel_arrows_position'];
		} else {
			$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
		}

		if ( 'disable' !== $arrows_hover_style ) {
			$nav_classes .= ' wd-hover-' . $arrows_hover_style;
		}

		$settings['slides_per_view'] = $settings['slides_per_view']['size'];

		if ( ! empty( $settings['slides_per_view_tablet']['size'] ) || ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
			$settings['custom_sizes'] = array(
				'desktop' => $settings['slides_per_view'],
				'tablet'  => $settings['slides_per_view_tablet']['size'],
				'mobile'  => $settings['slides_per_view_mobile']['size'],
			);
		}

		if ( 'yes' === $settings['scroll_carousel_init'] ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$wrapper_classes .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$extra_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
		}

		$settings['spacing']        = $settings['slider_spacing'];
		$settings['spacing_tablet'] = $settings['slider_spacing_tablet'];
		$settings['spacing_mobile'] = $settings['slider_spacing_mobile'];

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );

		?>
		<div class="wd-carousel-container info-box-carousel-wrapper<?php echo esc_attr( $extra_classes ); ?>">
			<div class="wd-carousel-inner">
				<div class="wd-carousel wd-grid info-box-carousel<?php echo esc_attr( $wrapper_classes ); ?>" <?php echo woodmart_get_carousel_attributes( $settings ); ?>>
					<div class="wd-carousel-wrap">
						<?php foreach ( $settings['content_repeater'] as $index => $infobox ) : ?>
							<?php
							$infobox                    = $infobox + $settings;
							$infobox['wrapper_classes'] = ' elementor-repeater-item-' . $infobox['_id'];
							$infobox['extra_classes']   = ' wd-carousel-item';
							?>
							<?php woodmart_elementor_infobox_template( $infobox, $element ); ?>
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
		<?php
	}
}

if ( ! function_exists( 'woodmart_elementor_infobox_template' ) ) {
	function woodmart_elementor_infobox_template( $settings, $element ) {
		$default_settings = array(
			'link'                        => '',
			'alignment'                   => 'left',
			'image_alignment'             => 'top',
			'image_vertical_alignment'    => 'top',
			'style'                       => '',
			'hover'                       => '',
			'woodmart_color_scheme'       => '',
			'woodmart_hover_color_scheme' => 'light',
			'svg_animation'               => '',

			'bg_hover_color'              => '',
			'bg_hover_color_gradient'     => '',
			'bg_hover_colorpicker'        => 'colorpicker',

			// Icon
			'icon_bg_color'               => '',
			'icon_bg_hover_color'         => '',
			'icon_border_color'           => '',
			'icon_border_hover_color'     => '',
			'image'                       => '',
			'icon_type'                   => 'text',
			'icon_style'                  => 'simple',
			'icon_text'                   => '',
			'icon_text_color'             => '',
			'icon_text_size'              => 'default',

			// Btn
			'btn_text'                    => '',
			'btn_position'                => 'static',
			'btn_color'                   => 'default',
			'btn_style'                   => 'default',
			'btn_shape'                   => 'rectangle',
			'btn_size'                    => 'default',
			'btn_icon_type'               => 'icon',
			'btn_image'                   => '',
			'btn_image_size'              => '',
			'btn_image_custom_dimension'  => '',
			'btn_icon'                    => '',
			'btn_icon_position'           => 'right',

			// Title
			'title'                       => '',
			'title_size'                  => 'default',
			'title_style'                 => 'default',
			'title_color'                 => '',
			'title_font_size'             => '',
			'title_tag'                   => 'h4',

			// Subtitle
			'subtitle'                    => '',
			'subtitle_color'              => 'default',
			'subtitle_custom_color'       => '',
			'subtitle_custom_bg_color'    => '',
			'subtitle_style'              => 'default',

			// Content
			'custom_text_color'           => '',

			// Extra
			'wrapper_classes'             => '',
			'extra_classes'               => '',
		);

		$settings         = wp_parse_args( $settings, $default_settings );
		$wrapper_classes  = '';
		$subtitle_classes = '';
		$title_classes    = '';
		$content_classes  = '';
		$icon_classes     = '';
		$image_output     = '';

		// Wrapper classes.
		$wrapper_classes .= ' text-' . $settings['alignment'];
		$wrapper_classes .= ' box-icon-align-' . $settings['image_alignment'];
		$wrapper_classes .= ' box-style-' . $settings['style'];
		$wrapper_classes .= ' color-scheme-' . $settings['woodmart_color_scheme'];
		$wrapper_classes .= $settings['wrapper_classes'] ? ' ' . $settings['wrapper_classes'] : '';

		if ( in_array( $settings['image_alignment'], array( 'left', 'right' ), true ) ) {
			$wrapper_classes .= ' wd-items-' . $settings['image_vertical_alignment'];
		}

		if ( 'bg-hover' === $settings['style'] ) {
			$wrapper_classes .= ' color-scheme-hover-' . $settings['woodmart_hover_color_scheme'];
		}
		if ( 'yes' === $settings['svg_animation'] ) {
			woodmart_enqueue_js_library( 'vivus' );
			woodmart_enqueue_js_script( 'infobox-element' );
			$wrapper_classes .= ' with-animation';
		}
		if ( $settings['btn_text'] ) {
			$wrapper_classes .= ' with-btn';
			$wrapper_classes .= ' box-btn-' . $settings['btn_position'];
		}

		// Title classes.
		$title_classes .= ' box-title-style-' . $settings['title_style'];
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$title_classes .= ' elementor-inline-editing';
		}
		$title_classes   .= ' ' . woodmart_get_new_size_classes( 'infobox', $settings['title_size'], 'title' );
		$wrapper_classes .= woodmart_get_old_classes( ' box-title-' . $settings['title_size'] );
		$wrapper_classes .= woodmart_get_old_classes( ' woodmart-info-box' );

		// Subtitle classes.
		if ( ! $settings['subtitle_custom_color'] && ! $settings['subtitle_custom_bg_color'] ) {
			$subtitle_classes .= ' subtitle-color-' . $settings['subtitle_color'];
		}
		$subtitle_classes .= ' subtitle-style-' . $settings['subtitle_style'];
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$subtitle_classes .= ' elementor-inline-editing';
		}
		$subtitle_classes .= ' ' . woodmart_get_new_size_classes( 'infobox', $settings['title_size'], 'subtitle' );

		// Content classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$content_classes .= ' elementor-inline-editing';
		}

		// Text classes.
		if ( 'icon' === $settings['icon_type'] ) {
			$icon_classes .= ' box-with-icon';
		} else {
			$icon_classes .= ' box-with-text text-size-' . $settings['icon_text_size'];
		}
		$icon_classes .= ' box-icon-' . $settings['icon_style'];

		// Link settings.
		if ( $settings['link'] && $settings['link']['url'] && ! $settings['btn_text'] ) {
			$element->remove_render_attribute( 'link' );

			$element->add_link_attributes( 'link', $settings['link'] );
			$element->add_render_attribute( 'link', 'class', 'wd-info-box-link wd-fill' );
			$element->add_render_attribute( 'link', 'aria-label', esc_html__( 'Infobox link', 'woodmart' ) );
		}

		// Image settings.
		$rand              = 'svg-' . rand( 999, 9999 );
		$custom_image_size = isset( $settings['image_custom_dimension']['width'] ) && $settings['image_custom_dimension']['width'] ? $settings['image_custom_dimension'] : array(
			'width'  => 128,
			'height' => 128,
		);

		if ( isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$image_output = woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] );

			if ( woodmart_is_svg( $settings['image']['url'] ) && apply_filters( 'woodmart_show_infobox_svg_by_tag', true ) ) {
				$image_output = '<span class="info-svg-wrapper info-icon" style="width:' . esc_attr( $custom_image_size['width'] ) . 'px; height:' . esc_attr( $custom_image_size['height'] ) . 'px;">' . woodmart_get_any_svg( $settings['image']['url'], $rand ) . '</span>';
			}
		}

		woodmart_enqueue_inline_style( 'info-box' );

		if ( 'border' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'info-box-style-brd' );
		} elseif ( in_array( $settings['style'], array( 'shadow', 'bg-hover' ), true ) ) {
			woodmart_enqueue_inline_style( 'info-box-style-shadow-and-bg-hover' );
		}

		if ( $settings['btn_text'] && 'hover' === $settings['btn_position'] ) {
			woodmart_enqueue_inline_style( 'info-box-btn-hover' );
		}

		?>
		<div class="info-box-wrapper<?php echo esc_attr( $settings['extra_classes'] ); ?>">
			<div class="wd-info-box<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php if ( $image_output || $settings['icon_text'] ) : ?>
					<div class="box-icon-wrapper <?php echo esc_attr( $icon_classes ); ?>">
						<div class="info-box-icon">
							<?php if ( 'icon' === $settings['icon_type'] ) : ?>
								<?php echo $image_output; ?>
							<?php else : ?>
								<?php echo esc_attr( $settings['icon_text'] ); ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="info-box-content">
					<?php if ( $settings['subtitle'] ) : ?>
						<div class="info-box-subtitle<?php echo esc_attr( $subtitle_classes ); ?>"
							  data-elementor-setting-key="subtitle">
							<?php echo nl2br( $settings['subtitle'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $settings['title'] ) : ?>
						<<?php echo esc_attr( $settings['title_tag'] ); ?>
						class="info-box-title title<?php echo esc_attr( $title_classes ); ?>" data-elementor-setting-key="title">
								<?php echo nl2br( $settings['title'] ); ?>
						</<?php echo esc_attr( $settings['title_tag'] ); ?>>
					<?php endif; ?>

					<div class="info-box-inner set-cont-mb-s reset-last-child<?php echo esc_attr( $content_classes ); ?>"data-elementor-setting-key="content"><?php echo do_shortcode( wpautop( $settings['content'] ) ); ?></div>

					<?php if ( $settings['btn_text'] ) : ?>
						<div class="info-btn-wrapper">
							<?php
							woodmart_elementor_button_template(
								array(
									'title'         => $settings['btn_text'],
									'color'         => $settings['btn_color'],
									'style'         => $settings['btn_style'],
									'size'          => $settings['btn_size'],
									'align'         => $settings['alignment'],
									'shape'         => $settings['btn_shape'],
									'text'          => $settings['btn_text'],
									'inline_edit'   => false,
									'icon_type'     => $settings['btn_icon_type'],
									'image'         => $settings['btn_image'],
									'icon'          => $settings['btn_icon'],
									'icon_position' => $settings['btn_icon_position'],
									'image_size'    => $settings['btn_image_size'],
									'image_custom_dimension' => $settings['btn_image_custom_dimension'],
								) + $settings
							);
							?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $settings['link'] && $settings['link']['url'] && ! $settings['btn_text'] ) : ?>
					<a <?php echo $element->get_render_attribute_string( 'link' )?>></a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
