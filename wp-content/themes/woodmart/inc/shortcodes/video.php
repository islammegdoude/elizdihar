<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Video shortcode
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_shortcode_video' ) ) {
	function woodmart_shortcode_video( $settings ) {
		$default_settings = array(
			'video_type'               => 'hosted',
			'video_hosted'             => '',
			'video_youtube_url'        => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
			'video_vimeo_url'          => 'https://vimeo.com/235215203',
			'video_action_button'      => 'without',
			'play_button_label'        => '',
			'video_overlay_lightbox'   => 'no',

			// Video options.
			'video_autoplay'           => 'no',
			'video_mute'               => 'no',
			'video_loop'               => 'no',
			'video_controls'           => 'yes',
			'video_preload'            => 'metadata',
			'video_poster'             => '',

			// Image overlay.
			'video_image_overlay'      => '',
			'video_image_overlay_size' => '',

			// Button.
			'button_text'              => 'Play video',
			'style'                    => 'default',
			'shape'                    => 'rectangle',
			'size'                     => 'default',
			'color'                    => 'default',
			'color_scheme'             => 'light',
			'color_scheme_hover'       => 'light',
			'align'                    => 'center',
			'full_width'               => 'no',
			'icon_type'                => 'icon',
			'attach_image'             => '',
			'img_size'                 => '',
			'icon_library'             => 'fontawesome',
			'icon_fontawesome'         => '',
			'icon_openiconic'          => '',
			'icon_typicons'            => '',
			'icon_entypo'              => '',
			'icon_linecons'            => '',
			'icon_monosocial'          => '',
			'icon_material'            => '',
			'icon_position'            => 'right',

			// Style.
			'video_size'               => 'custom',

			// Play button.
			'play_button_align'        => 'center',

			'alignment'                => '',
			'css'                      => '',
		);

		$settings        = wp_parse_args( $settings, $default_settings );
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );
		$image_output    = '';
		$video_url       = '';
		$play_classes    = '';

		// Wrapper classes.
		$wrapper_classes .= ' wd-action-' . $settings['video_action_button'];
		$wrapper_classes .= ' wd-video-' . $settings['video_type'];

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( 'play' === $settings['video_action_button'] ) {
			$wrapper_classes .= ' text-' . $settings['play_button_align'];
		}

		if ( 'aspect_ratio' === $settings['video_size'] ) {
			$wrapper_classes .= ' wd-with-aspect-ratio';
		}

		// Play classes.
		if ( 'yes' === $settings['video_overlay_lightbox'] ) {
			$wrapper_classes .= ' wd-lightbox';
			$play_classes    .= ' wd-el-video-lightbox';
		}

		if ( 'hosted' === $settings['video_type'] ) {
			$play_classes .= ' wd-el-video-hosted';
		}

		// Image settings.
		if ( 'overlay' === $settings['video_action_button'] && $settings['video_image_overlay'] ) {
			$image_output = woodmart_otf_get_image_html( $settings['video_image_overlay'], $settings['video_image_overlay_size'] );
		}

		// Video settings.
		if ( 'without' === $settings['video_action_button'] ) {
			$video_params = array(
				'loop'     => 'yes' === $settings['video_loop'] ? 1 : 0,
				'mute'     => 'yes' === $settings['video_mute'] || 'yes' === $settings['video_autoplay'] ? 1 : 0,
				'controls' => 'yes' === $settings['video_controls'] ? 1 : 0,
				'autoplay' => 'yes' === $settings['video_autoplay'] ? 1 : 0,
			);
		} else {
			$video_params = array(
				'loop'     => 0,
				'mute'     => 'youtube' !== $settings['video_type'] ? 1 : 0,
				'controls' => 1,
				'autoplay' => 0,
			);
		}

		if ( 'youtube' === $settings['video_type'] ) {
			$video_url        = $settings['video_youtube_url'];
			$settings['link'] = $settings['video_youtube_url'];
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$primary_color = woodmart_get_opt( 'primary-color' );

			if ( ! empty( $primary_color['idle'] ) ) {
				$video_params['color'] = str_replace( '#', '', $primary_color['idle'] );
			}

			$video_params['muted'] = $video_params['mute'];
			unset( $video_params['mute'] );

			$video_url        = $settings['video_vimeo_url'];
			$settings['link'] = $settings['video_vimeo_url'];
		} elseif ( 'hosted' === $settings['video_type'] ) {
			$settings['link'] = wp_get_attachment_url( $settings['video_hosted'] );
		}

		if ( 'hosted' === $settings['video_type'] ) {
			$video_tag_id                     = uniqid();
			$video_html                       = '';
			$video_attr                       = '';
			$settings['link']                 = '#' . $video_tag_id;
			$settings['button_extra_classes'] = $play_classes;

			if ( ! wp_attachment_is( 'video', $settings['video_hosted'] ) ) {
				return '';
			}

			if ( 'without' === $settings['video_action_button'] ) {
				$video_attr .= ' src="' . wp_get_attachment_url( $settings['video_hosted'] ) . '"';
			} else {
				$video_attr .= ' data-lazy-load="' . wp_get_attachment_url( $settings['video_hosted'] ) . '"';
			}

			$video_attr .= ' playsinline';
			$video_attr .= $video_params['loop'] ? ' loop' : '';
			$video_attr .= $video_params['mute'] ? ' muted' : '';
			$video_attr .= $video_params['controls'] ? ' controls' : '';
			$video_attr .= $video_params['autoplay'] && 'without' === $settings['video_action_button'] ? ' autoplay' : '';

			if ( 'yes' === $settings['video_overlay_lightbox'] || 'action_button' === $settings['video_action_button'] || 'play' === $settings['video_action_button'] ) {
				$video_html .= '<div class="wd-popup wd-video-popup mfp-with-anim mfp-hide" id="' . $video_tag_id . '">';
			}

			if ( ! $video_params['autoplay'] && 'without' === $settings['video_action_button'] ) {
				$video_attr .= ' preload="' . $settings['video_preload'] . '"';
			}

			if ( $settings['video_poster'] && 'without' === $settings['video_action_button'] ) {
				$video_attr .= ' poster="' . wp_get_attachment_image_src( $settings['video_poster'], 'full' )[0] . '"';
			}

			$video_html .= '<video' . $video_attr . '></video>';

			if ( 'yes' === $settings['video_overlay_lightbox'] || 'action_button' === $settings['video_action_button'] || 'play' === $settings['video_action_button'] ) {
				$video_html .= '</div>';
			}
		} else {
			$frame_attributes = array();
			$video_embed_url  = '';

			if ( 'youtube' === $settings['video_type'] ) {
				preg_match( '/^.*(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/', $video_url, $matches );

				if ( ! $matches ) {
					return;
				}

				if ( 'yes' === $settings['video_loop'] ) {
					$video_params['playlist'] = $matches[1];
				}

				$video_embed_url = 'https://www.youtube.com/embed/' . $matches[1] . '?feature=oembed';
			} elseif ( 'vimeo' === $settings['video_type'] ) {
				preg_match( '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/', $video_url, $matches );

				if ( ! $matches ) {
					return;
				}

				$video_embed_url = 'https://player.vimeo.com/video/' . $matches[1] . '?transparent=0';
			}

			if ( 'overlay' === $settings['video_action_button'] ) {
				unset( $video_params['autoplay'] );
			}

			foreach ( $video_params as $key => $param ) {
				if ( $param || 0 === $param ) {
					$video_embed_url .= '&' . $key . '=' . $param;
				}
			}

			if ( 'without' === $settings['video_action_button'] ) {
				$frame_attributes[] = 'src="' . $video_embed_url . '"';
			} else {
				$frame_attributes[] = 'data-lazy-load="' . $video_embed_url . '"';
			}

			$frame_attributes[] = 'allowfullscreen';
			$frame_attributes[] = 'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"';
			$frame_attributes[] = 'width="100%"';
			$frame_attributes[] = 'height="100%"';
			$frame_attributes[] = 'loading="lazy"';

			$video_html = '<iframe ' . implode( ' ', $frame_attributes ) . '></iframe>';

			$settings['link'] = preg_replace( "#^[^:/.]*[:/]+#i", "", $video_url );
		}

		// Button settings.
		if ( 'action_button' === $settings['video_action_button'] ) {
			if ( isset( $settings['button_extra_classes'] ) ) {
				$settings['button_extra_classes'] .= ' wd-el-video-btn';
			} else {
				$settings['button_extra_classes'] = ' wd-el-video-btn';
			}
		}

		ob_start();

		if ( 'action_button' === $settings['video_action_button'] || 'yes' === $settings['video_overlay_lightbox'] || 'play' === $settings['video_action_button'] ) {
			woodmart_enqueue_js_library( 'magnific' );
			woodmart_enqueue_js_script( 'video-element-popup' );
			woodmart_enqueue_inline_style( 'mfp-popup' );
		}

		woodmart_enqueue_js_script( 'video-element' );
		woodmart_enqueue_inline_style( 'el-video' );

		?>
		<div class="wd-el-video wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 'hosted' === $settings['video_type'] || 'without' === $settings['video_action_button'] || 'overlay' === $settings['video_action_button'] && 'yes' !== $settings['video_overlay_lightbox'] ) : ?>
				<?php echo $video_html; ?>
			<?php endif; ?>

			<?php if ( 'action_button' === $settings['video_action_button'] && $settings['button_text'] ) : ?>
				<?php
				$settings['wrapper_class'] = $play_classes;
				$settings['title']         = $settings['button_text'];
				$settings['link']          = 'url:' . $settings['link'] . '|||';
				?>
				<?php echo woodmart_shortcode_button( $settings, true ); ?>
			<?php endif; ?>

			<?php if ( 'play' === $settings['video_action_button'] ) : ?>
				<a href="<?php echo esc_url( $settings['link'] ); ?>" class="wd-el-video-btn<?php echo esc_attr( $play_classes ); ?>">
					<span class="wd-el-video-play-btn"></span>
					<?php if ( $settings['play_button_label'] ) : ?>
						<span class="wd-el-video-play-label">
							<?php echo esc_html( $settings['play_button_label'] ); ?>
						</span>
					<?php endif; ?>
				</a>
			<?php endif; ?>

			<?php if ( 'overlay' === $settings['video_action_button'] ) : ?>
				<div class="wd-el-video-overlay wd-fill">
					<?php echo wp_kses( $image_output, true ); ?>
				</div>
				<div class="wd-el-video-control color-scheme-light wd-fill">
					<span class="wd-el-video-play-btn"></span>
					<?php if ( $settings['play_button_label'] ) : ?>
						<span class="wd-el-video-play-label">
							<?php echo esc_html( $settings['play_button_label'] ); ?>
						</span>
					<?php endif; ?>
				</div>

				<a class="wd-el-video-link wd-el-video-btn-overlay wd-fill<?php echo esc_attr( $play_classes ); ?>" href="<?php echo esc_url( $settings['link'] ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
