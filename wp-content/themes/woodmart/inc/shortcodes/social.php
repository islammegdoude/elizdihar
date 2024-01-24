<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Share and follow buttons shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_social' )) {
	function woodmart_shortcode_social($atts) {
		$classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$links_atts = array(
			'fb_link'         => '',
			'twitter_link'    => '',
			'isntagram_link'  => '',
			'pinterest_link'  => '',
			'youtube_link'    => '',
			'tumblr_link'     => '',
			'linkedin_link'   => '',
			'vimeo_link'      => '',
			'flickr_link'     => '',
			'github_link'     => '',
			'dribbble_link'   => '',
			'behance_link'    => '',
			'soundcloud_link' => '',
			'spotify_link'    => '',
			'ok_link'         => '',
			'vk_link'         => '',
			'whatsapp_link'   => '',
			'snapchat_link'   => '',
			'tg_link'         => '',
			'tiktok_link'     => '',
			'discord_link'    => '',
		);

		$default_atts = array(
			'show_label'          => 'no',
			'label_text'          => esc_html__( 'Share: ', 'woodmart' ),
			'is_element'          => false,
			'layout'              => '',
			'type'                => 'share',
			'social_links_source' => 'theme_settings',
			'align'               => 'center',
			'tooltip'             => 'no',
			'style'               => 'default',
			'size'                => 'default',
			'form'                => 'circle',
			'color'               => 'dark',
			'css_animation'       => 'none',
			'el_class'            => '',
			'title_classes'       => '',
			'page_link'           => false,
			'elementor'           => false,
			'sticky'              => false,
			'css'                 => '',
		);

		$atts = shortcode_atts( array_merge( $default_atts, $links_atts ), $atts );

		if ( 'follow' === $atts['type'] && 'theme_settings' === $atts['social_links_source'] ) {
			foreach ( array_keys( $links_atts ) as $link_option_name ) {
				$atts[ $link_option_name ] = woodmart_get_opt( $link_option_name, '' );
			}
		}

		extract( $atts );

		if ( woodmart_get_opt( 'dark_version' ) ) {
			$color = 'light';
		}

		$target        = '_blank';
		$title_classes = $title_classes ? ' ' . $title_classes : '';
		$classes      .= ' wd-social-icons';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$classes .= woodmart_get_old_classes( ' woodmart-social-icons' );
		$classes .= ! empty( $layout ) ? ' wd-layout-' . $layout : '';
		$classes .= ' icons-design-' . $style;
		$classes .= ' icons-size-' . $size;
		$classes .= ' color-scheme-' . $color;
		$classes .= ' social-' . $type;
		$classes .= ' social-form-' . $form;
		$classes .= ( $el_class ) ? ' ' . $el_class : '';

		$classes .= woodmart_get_css_animation( $css_animation );

		$align = $align ? $align : 'center';

		$classes .= ' text-' . $align;

		$thumb_id   = get_post_thumbnail_id();
		$thumb_url  = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
		$page_title = get_the_title();

		if ( ! $page_link ) {
			$page_link = get_the_permalink();
		}

		if ( woodmart_woocommerce_installed() && is_shop() ) {
			$page_link = get_permalink( get_option( 'woocommerce_shop_page_id' ) );
		}
		if ( woodmart_woocommerce_installed() && ( is_product_category() || is_category() ) ) {
			$page_link = get_category_link( get_queried_object()->term_id );
		}
		if ( is_home() && ! is_front_page() ) {
			$page_link = get_permalink( get_option( 'page_for_posts' ) );
		}

		if ( ! $elementor ) {
			ob_start();
		}

		woodmart_enqueue_inline_style( 'social-icons' );
		?>

			<div class="<?php echo esc_attr( $classes ); ?>">

				<?php if ( 'yes' === $show_label ) : ?>
					<span class="wd-label<?php echo esc_attr( $title_classes ); ?>"><?php echo esc_html( $label_text ); ?></span>
				<?php endif; ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_fb') ) || ( $type == 'follow' && $fb_link != '')): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $fb_link ) : 'https://www.facebook.com/sharer/sharer.php?u=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-facebook" aria-label="<?php esc_html_e( 'Facebook social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Facebook', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_twitter') ) || ( $type == 'follow' && $twitter_link != '')): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $twitter_link ) : 'https://x.com/share?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-twitter" aria-label="<?php esc_html_e( 'X social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('X', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_email') ) || ( $type == 'follow' && woodmart_get_opt( 'social_email_links' ) ) ): ?>
					<a rel="noopener noreferrer nofollow" href="mailto:<?php echo '?subject=' . esc_html__('Check%20this%20', 'woodmart') . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-email" aria-label="<?php esc_html_e( 'Email social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Email', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $isntagram_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $isntagram_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-instagram" aria-label="<?php esc_html_e( 'Instagram social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Instagram', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $youtube_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $youtube_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-youtube" aria-label="<?php esc_html_e( 'YouTube social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('YouTube', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_pinterest') ) || ( $type == 'follow' && $pinterest_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $pinterest_link ) : 'https://pinterest.com/pin/create/button/?url=' . $page_link . '&media=' . $thumb_url[0] . '&description=' . urlencode( $page_title ); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-pinterest" aria-label="<?php esc_html_e( 'Pinterest social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Pinterest', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $tumblr_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $tumblr_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-tumblr" aria-label="<?php esc_html_e( 'Tumblr social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Tumblr', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_linkedin') ) || ( $type == 'follow' && $linkedin_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $linkedin_link ) : 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-linkedin" aria-label="<?php esc_html_e( 'Linkedin social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('linkedin', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $vimeo_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $vimeo_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-vimeo" aria-label="<?php esc_html_e( 'Vimeo social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Vimeo', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $flickr_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $flickr_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-flickr" aria-label="<?php esc_html_e( 'Flickr social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Flickr', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $github_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $github_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-github" aria-label="<?php esc_html_e( 'GitHub social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('GitHub', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $dribbble_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $dribbble_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-dribbble" aria-label="<?php esc_html_e( 'Dribbble social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Dribbble', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $behance_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $behance_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-behance" aria-label="<?php esc_html_e( 'Behance social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Behance', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $soundcloud_link != ''): ?>
						<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $soundcloud_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-soundcloud" aria-label="<?php esc_html_e( 'Soundcloud social link', 'woodmart' ); ?>">
							<span class="wd-icon"></span>
							<?php if ( $sticky ) : ?>
								<span class="wd-icon-name"><?php esc_html_e('Soundcloud', 'woodmart') ?></span>
							<?php endif; ?>
						</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $spotify_link != ''): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $spotify_link ) : '' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-spotify" aria-label="<?php esc_html_e( 'Spotify social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Spotify', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_ok') ) || ( $type == 'follow' && $ok_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $ok_link ) : 'https://connect.ok.ru/offer?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-ok" aria-label="<?php esc_html_e( 'Odnoklassniki social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Odnoklassniki', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'share' && woodmart_get_opt('share_whatsapp') || ( $type == 'follow' && $whatsapp_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $whatsapp_link ) : 'https://api.whatsapp.com/send?text=' . urlencode( $page_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="whatsapp-desktop <?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-whatsapp" aria-label="<?php esc_html_e( 'WhatsApp social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('WhatsApp', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
					
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $whatsapp_link ) : 'whatsapp://send?text=' . urlencode( $page_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="whatsapp-mobile <?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-whatsapp" aria-label="<?php esc_html_e( 'WhatsApp social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('WhatsApp', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'share' && woodmart_get_opt('share_vk') || ( $type == 'follow' && $vk_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $vk_link ) : 'https://vk.com/share.php?url=' . $page_link . '&image=' . $thumb_url[0] . '&title=' . $page_title; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-vk" aria-label="<?php esc_html_e( 'VK social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('VK', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>
				
				<?php if ( $type == 'follow' && $snapchat_link != '' ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo esc_url( $snapchat_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-snapchat" aria-label="<?php esc_html_e( 'Snapchat social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Snapchat', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>
				
				<?php if ( $type == 'follow' && $tiktok_link != '' ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo esc_url( $tiktok_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-tiktok" aria-label="<?php esc_html_e( 'TikTok social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('TikTok', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'follow' && $discord_link != '' ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo esc_url( $discord_link ); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-discord" aria-label="<?php esc_html_e( 'Discord social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Discord', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

				<?php if ( $type == 'share' && woodmart_get_opt('share_tg') || ( $type == 'follow' && $tg_link != '' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'follow' === $type ? esc_url( $tg_link ) : 'https://telegram.me/share/url?url=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-tg" aria-label="<?php esc_html_e( 'Telegram social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Telegram', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>
				
				<?php if ( $type == 'share' && woodmart_get_opt( 'share_viber' ) ): ?>
					<a rel="noopener noreferrer nofollow" href="<?php echo 'viber://forward?text=' . $page_link; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'wd-tooltip'; ?> wd-social-icon social-viber" aria-label="<?php esc_html_e( 'Viber social link', 'woodmart' ); ?>">
						<span class="wd-icon"></span>
						<?php if ( $sticky ) : ?>
							<span class="wd-icon-name"><?php esc_html_e('Viber', 'woodmart') ?></span>
						<?php endif; ?>
					</a>
				<?php endif ?>

			</div>

		<?php
		if ( ! $elementor ) {
			$output = ob_get_contents();
			ob_end_clean();
			
			return $output;
		}
	}
}
