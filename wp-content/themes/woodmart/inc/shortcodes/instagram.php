<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Instagram shortcode
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_instagram' ) ) {
	function woodmart_shortcode_instagram( $atts, $content = '' ) {
		$output          = '';
		$pics_classes    = '';
		$picture_classes = '';
		$carousel_atts   = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'title'                 => '',
					'username'              => 'flickr',
					'number'                => 9,
					'size'                  => 'medium',
					'target'                => '_self',
					'link'                  => '',
					'design'                => 'grid',
					'spacing'               => 0,
					'spacing_custom'        => 6,
					'spacing_custom_tablet' => '',
					'spacing_custom_mobile' => '',
					'rounded'               => 0,
					'per_row'               => 3,
					'per_row_tablet'        => 'auto',
					'per_row_mobile'        => 'auto',
					'hide_mask'             => 0,
					'el_class'              => '',
					'ajax_body'             => false,
					'content'               => $content,
					'data_source'           => 'scrape',
					'woodmart_css_id'       => uniqid(),
					'css'                   => '',
					'content_color_scheme'  => '',

					// Images.
					'images'                => array(),
					'images_size'           => 'medium',
					'images_link'           => '',
					'images_likes'          => '1000-10000',
					'images_comments'       => '0-1000',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$carousel_id = 'carousel-' . rand( 100, 999 );

		ob_start();

		$class           = 'wd-insta';
		$content_classes = ! empty( $content_color_scheme ) ? ' color-scheme-' . $content_color_scheme : '';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}
		if ( ! empty( $parsed_atts['woodmart_css_id'] ) ) {
			$class .= ' wd-rs-' . $parsed_atts['woodmart_css_id'];
		}

		$class .= $el_class ? ' ' . $el_class : '';

		if ( $rounded == 1 ) {
			$class .= ' instagram-rounded';
		}

		if ( empty( $per_row_tablet ) ) {
			$per_row_tablet = $per_row;
		}

		if ( empty( $per_row_mobile ) ) {
			$per_row_mobile = round( (int) $per_row / 2 );
		}

		$class .= ' data-source-' . $data_source;

		if ( $design == 'slider' ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );
			$custom_sizes = apply_filters( 'woodmart_instagram_shortcode_custom_sizes', false );

			if ( ( 'auto' !== $per_row_tablet && ! empty( $per_row_tablet ) ) || ( 'auto' !== $per_row_mobile && ! empty( $per_row_mobile ) ) ) {
				$custom_sizes = array(
					'desktop' => $per_row,
					'tablet'  => $per_row_tablet,
					'mobile'  => $per_row_mobile,
				);
			}

			$carousel_atts = woodmart_get_carousel_attributes(
				wp_parse_args(
					array(
						'carousel_id'     => $carousel_id,
						'slides_per_view' => $per_row,
						'custom_sizes'    => $custom_sizes,
						'spacing'         => $spacing ? $parsed_atts['spacing_custom'] : 0,
						'spacing_tablet'  => $spacing ? $parsed_atts['spacing_custom_tablet'] : 0,
						'spacing_mobile'  => $spacing ? $parsed_atts['spacing_custom_mobile'] : 0,
					),
					$parsed_atts
				)
			);

			$pics_classes      .= 'wd-carousel wd-grid';
			$class             .= ' wd-carousel-container';
			$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

			if ( ! empty( $parsed_atts['carousel_arrows_position'] ) ) {
				$nav_classes = ' wd-pos-' . $parsed_atts['carousel_arrows_position'];
			} else {
				$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
			}

			if ( 'disable' !== $arrows_hover_style ) {
				$nav_classes .= ' wd-hover-' . $arrows_hover_style;
			}

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$class .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
			}

			if ( 'yes' === $scroll_carousel_init ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$pics_classes .= ' scroll-init';
			}
		} else {
			$parsed_atts['columns']        = $per_row;
			$parsed_atts['columns_tablet'] = $per_row_tablet;
			$parsed_atts['columns_mobile'] = $per_row_mobile;
			$parsed_atts['spacing']        = $spacing ? $parsed_atts['spacing_custom'] : 0;
			$parsed_atts['spacing_tablet'] = $spacing ? $parsed_atts['spacing_custom_tablet'] : 0;
			$parsed_atts['spacing_mobile'] = $spacing ? $parsed_atts['spacing_custom_mobile'] : 0;

			$pics_classes    .= ' wd-grid-g';
			$picture_classes .= ' wd-col';
			$carousel_atts   .= ' style="' . woodmart_get_grid_attrs( $parsed_atts ) . '"';
		}

		if ( 'images' === $data_source ) {
			$media_array = woodmart_get_instagram_custom_images( $images, $images_size, $images_link, $images_likes, $images_comments );
		} else {
			$media_array = woodmart_scrape_instagram( $username, $number, $ajax_body, $data_source );
		}

		unset( $parsed_atts['ajax_body'] );

		$encoded_atts = json_encode( $parsed_atts );

		if ( is_wp_error( $media_array ) && ( $media_array->get_error_code() === 'invalid_response_429' || apply_filters( 'woodmart_intagram_user_ajax_load', false ) || 'ajax' === $data_source ) ) {
			woodmart_enqueue_js_script( 'instagram-element' );
			$class      .= ' wd-error';
			$media_array = array();
			$hide_mask   = true;
			for ( $i = 0; $i < $number; $i++ ) {
				$media_array[] = array(
					$size      => WOODMART_ASSETS . '/images/settings/instagram/insta-placeholder.jpg',
					'link'     => '#',
					'likes'    => '0',
					'comments' => '0',
				);
			}
		}

		woodmart_enqueue_inline_style( 'instagram' );

		echo '<div id="' . esc_attr( $carousel_id ) . '" data-atts="' . esc_attr( $encoded_atts ) . '" data-username="' . esc_attr( $username ) . '" class="' . esc_attr( $class ) . '">';

		if ( ! empty( $title ) ) {
			echo '<h3 class="title">' . $title . '</h3>';
		};

		if ( $username != '' && ! is_wp_error( $media_array ) ) {
			?>
				<?php if ( 'slider' === $design ) : ?>
					<div class="wd-carousel-inner">
				<?php endif; ?>

				<?php if ( ! empty( $content ) ) : ?>
				<div class="wd-insta-cont wd-fill<?php echo esc_attr( $content_classes ); ?>">
					<div class="wd-insta-cont-inner reset-last-child">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
				<?php endif; ?>

				<div class="<?php echo esc_attr( $pics_classes ); ?>" <?php echo $carousel_atts; ?>>
					<?php if ( 'slider' === $design ) : ?>
						<div class="wd-carousel-wrap">
					<?php endif; ?>

				<?php foreach ( $media_array as $item ) : ?>
					<?php
					$image = '';

					if ( ! empty( $item[ $size ] ) ) {
						$image = $item[ $size ];
					}

					?>
					<?php if ( 'slider' === $design ) : ?>
						<div class="wd-carousel-item">
					<?php endif; ?>

					<div class="wd-insta-item<?php echo esc_attr( $picture_classes ); ?>">
						<a href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $target ); ?>" aria-label="<?php esc_attr_e( 'Instagram picture', 'woodmart' ); ?>"></a>

						<?php
						$size = 'images' === $data_source ? $images_size : $size;

						if ( isset( $item['image_id'] ) && $item['image_id'] ) {
							echo wp_get_attachment_image( $item['image_id'], $size );
						} else {
							echo apply_filters( 'woodmart_image', '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Instagram image', 'woodmart' ) . '"/>' );
						}
						?>

						<?php if ( $hide_mask == 0 ) : ?>
							<div class="wd-insta-meta wd-grid-g">
								<span class="wd-insta-likes instagram-likes"><span><?php echo esc_attr( woodmart_pretty_number( $item['likes'] ) ); ?></span></span>
								<span class="wd-insta-comm instagram-comments"><span><?php echo esc_attr( woodmart_pretty_number( $item['comments'] ) ); ?></span></span>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( 'slider' === $design ) : ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ( 'slider' === $design ) : ?>
					</div>
				<?php endif; ?>
				</div>

				<?php if ( 'slider' === $design ) : ?>
					<?php if ( 'yes' !== $parsed_atts['hide_prev_next_buttons'] ) : ?>
						<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
					<?php endif; ?>

					</div>

					<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
					<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
				<?php endif; ?>
			<?php
		} else {
			echo '<div class="wd-notice wd-info">' . esc_html( $media_array->get_error_message() ) . '</div>';
		}

		if ( $link != '' ) {
			?>
			<a href="//www.instagram.com/<?php echo trim( $username ); ?>" class="wd-insta-link" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_html( $link ); ?></a>
			<?php
		}

		echo '</div>';

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}
}

if ( ! function_exists( 'woodmart_pretty_number' ) ) {
	function woodmart_pretty_number( $x = 0 ) {
		$x = (int) $x;

		if ( $x > 1000000 ) {
			return floor( $x / 1000000 ) . 'M';
		}

		if ( $x > 10000 ) {
			return floor( $x / 1000 ) . 'k';
		}
		return $x;
	}
}

if ( ! function_exists( 'woodmart_scrape_instagram' ) ) {
	function woodmart_scrape_instagram( $username, $slice = 9, $ajax_body = false, $data_source = 'scrape' ) {
		$username       = strtolower( $username );
		$transient_name = 'instagram-media-new-' . sanitize_title_with_dashes( $username ) . '-' . $data_source;
		$instagram      = get_transient( $transient_name );

		if ( false === $instagram ) {
			if ( 'scrape' === $data_source || 'ajax' === $data_source ) {
				$instagram = woodmart_get_scrape_insta_images(
					array(
						'username'  => $username,
						'ajax_body' => $ajax_body,
					)
				);

			} elseif ( 'api' === $data_source ) {
				$instagram = woodmart_get_api_insta_images();
			}

			if ( is_wp_error( $instagram ) ) {
				return $instagram;
			}

			if ( ! empty( $instagram ) ) {
				$instagram = function_exists( 'woodmart_compress' ) ? woodmart_compress( maybe_serialize( $instagram ) ) : '';
				set_transient( $transient_name, $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		if ( ! empty( $instagram ) ) {
			$instagram = function_exists( 'woodmart_decompress' ) ? maybe_unserialize( woodmart_decompress( $instagram ) ) : array();
			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'woodmart' ) );
		}
	}
}

if ( ! function_exists( 'woodmart_get_api_insta_images' ) ) {
	function woodmart_get_api_insta_images() {
		$instagram_account_id   = get_option( 'instagram_account_id' );
		$instagram_access_token = get_option( 'instagram_access_token' );

		if ( ! $instagram_access_token || ! $instagram_account_id ) {
			return new WP_Error( 'no_token', esc_html__( 'You need connect your Instagram account in Theme settings -> General -> Connect instagram account', 'woodmart' ) );
		}

		$images_data = wp_remote_get( 'https://graph.facebook.com/v5.0/' . $instagram_account_id . '/media?access_token=' . $instagram_access_token . '&fields=timestamp,caption,media_type,media_url,thumbnail_url,like_count,comments_count,permalink' );

		if ( is_wp_error( $images_data ) ) {
			return $images_data;
		}

		$images_data_decoded = json_decode( $images_data['body'] );

		if ( is_object( $images_data_decoded ) ) {
			if ( property_exists( $images_data_decoded, 'error' ) ) {
				return new WP_Error( 'no_images', $images_data_decoded->error->message );
			}
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram API did not return any images.', 'woodmart' ) );
		}

		$instagram = array();

		foreach ( $images_data_decoded->data as $image ) {
			$caption = esc_html__( 'Instagram Image', 'woodmart' );

			if ( isset( $image->caption ) ) {
				$caption = $image->caption;
			}

			if ( 'VIDEO' === $image->media_type ) {
				$image_url = $image->thumbnail_url;
			} else {
				$image_url = $image->media_url;
			}

			$instagram[] = array(
				'description' => $caption,
				'link'        => preg_replace( '/^https:/i', '', $image->permalink ),
				'large'       => preg_replace( '/^https:/i', '', $image_url ),
				'image_id'    => xts_insert_image_from_url( $image_url ),
				'comments'    => $image->comments_count,
				'likes'       => $image->like_count,
				'type'        => $image->media_type,
			);
		}

		if ( $instagram && woodmart_get_opt( 'insta_delete_outdated_images' ) ) {
			$image_ids   = array_column( $instagram, 'image_id' );
			$attachments = new WP_Query(
				array(
					'post_type'      => 'attachment',
					'post_status'    => 'any',
					'post__not_in'   => $image_ids,
					'posts_per_page' => -1,
					'meta_query'     => array(
						array(
							'key'     => '_woodmart_instagram_image_name',
							'compare' => 'EXISTS',
						),
					),
				)
			);

			if ( $attachments->have_posts() ) {
				while ( $attachments->have_posts() ) {
					$attachments->the_post();

					$attachment_id = $attachments->post->ID;

					if ( ! in_array( $attachment_id, $image_ids, true ) ) {
						wp_delete_attachment( $attachment_id, true );
					}
				}
			}

			wp_reset_postdata();
		}

		return $instagram;
	}
}

if ( ! function_exists( 'xts_insert_image_from_url' ) ) {
	/**
	 * Insert image from url.
	 *
	 * @param string $url Image url.
	 *
	 * @return int|WP_Error
	 */
	function xts_insert_image_from_url( $url ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png|webp|heic)\b/i', $url, $matches );
		$img_name = wp_basename( $matches[0], '.' . $matches[1] );

		$img_by_slug = woodmart_get_image_id_by_slug( $img_name );

		if ( ! $img_by_slug ) {
			add_action( 'image_sideload_extensions', 'woodmart_get_instagram_image_sideload_extensions' );
			add_filter( 'intermediate_image_sizes', 'woodmart_get_instagram_insert_image_sizes', 10 );
			$upload = media_sideload_image( $url, 0, $img_name, 'id' );
			remove_action( 'intermediate_image_sizes', 'woodmart_get_instagram_insert_image_sizes', 10 );
			remove_action( 'image_sideload_extensions', 'woodmart_get_instagram_image_sideload_extensions' );

			if ( is_wp_error( $upload ) ) {
				return $upload->get_error_message();
			}

			update_post_meta( $upload, '_woodmart_instagram_image_name', $img_name );

			return $upload;
		}

		return $img_by_slug;
	}
}

if ( ! function_exists( 'woodmart_get_image_id_by_slug' ) ) {
	/**
	 * Get image id by slug
	 *
	 * @param string $slug Image slug.
	 *
	 * @return int
	 */
	function woodmart_get_image_id_by_slug( $slug ) {
		if ( ! $slug ) {
			return '';
		}

		$args = array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'meta_key'       => '_woodmart_instagram_image_name',
			'meta_value'     => $slug,
		);

		$post = get_posts( $args );

		if ( $post ) {
			return $post[0]->ID;
		}

		$args = array(
			'post_type'      => 'attachment',
			's'              => sanitize_title( $slug ),
			'posts_per_page' => 1,
		);

		$post = get_posts( $args );

		if ( ! $post ) {
			return '';
		}

		return $post[0]->ID;
	}
}

if ( ! function_exists( 'woodmart_get_instagram_insert_image_sizes' ) ) {
	/**
	 * Default images sizes.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_instagram_insert_image_sizes() {
		return array( 'medium' );
	}
}

if ( ! function_exists( 'woodmart_get_instagram_image_sideload_extensions' ) ) {
	/**
	 * Allowed image extensions for instagram API.
	 *
	 * @param array $allowed_extensions Allowed image extensions.
	 * @return array
	 */
	function woodmart_get_instagram_image_sideload_extensions( $allowed_extensions ) {
		$allowed_extensions[] = 'heic';

		return $allowed_extensions;
	}
}

if ( ! function_exists( 'woodmart_get_scrape_insta_images' ) ) {
	function woodmart_get_scrape_insta_images( $data ) {
		$by_hashtag = substr( $data['username'], 0, 1 ) === '#';

		if ( ! $data['ajax_body'] ) {
			$request_param = $by_hashtag ? 'explore/tags/' . substr( $data['username'], 1 ) : trim( $data['username'] );
			$remote        = wp_remote_get( 'https://www.instagram.com/' . $request_param . '/' );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'woodmart' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response_' . wp_remote_retrieve_response_code( $remote ), esc_html__( 'Instagram did not return a 200.', 'woodmart' ) );
			}

			$shards = explode( 'window._sharedData = ', $remote['body'] );
		} else {
			$remote = stripslashes( $data['ajax_body'] );
			$shards = explode( 'window._sharedData = ', $remote );
		}

		if ( ! isset( $shards[1] ) ) {
			return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
		}

		$insta_json  = explode( ';</script>', $shards[1] );
		$insta_array = json_decode( $insta_json[0], true );

		if ( ! $insta_array ) {
			return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
		}

		if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif ( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
		}

		if ( ! is_array( $images ) ) {
			return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
		}

		$instagram = array();

		foreach ( $images as $image ) {
			$image   = $image['node'];
			$caption = esc_html__( 'Instagram Image', 'woodmart' );
			if ( ! empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
				$caption = $image['edge_media_to_caption']['edges'][0]['node']['text'];
			}

			$image['thumbnail_src'] = preg_replace( '/^https:/i', '', $image['thumbnail_src'] );
			$image['thumbnail']     = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][0]['src'] );
			$image['medium']        = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][2]['src'] );
			$image['large']         = $image['thumbnail_src'];

			$type = ( $image['is_video'] ) ? 'video' : 'image';

			$instagram[] = array(
				'description' => $caption,
				'link'        => '//www.instagram.com/p/' . $image['shortcode'] . '/',
				'comments'    => $image['edge_media_to_comment']['count'],
				'likes'       => $image['edge_liked_by']['count'],
				'thumbnail'   => $image['thumbnail'],
				'medium'      => $image['medium'],
				'large'       => $image['large'],
				'type'        => $type,
			);
		}

		return $instagram;
	}
}

if ( ! function_exists( 'woodmart_instagram_ajax_query' ) ) {
	function woodmart_instagram_ajax_query() {
		if ( ! empty( $_POST['atts'] ) && ! empty( $_POST['body'] ) ) {
			$atts = woodmart_clean( $_POST['atts'] );

			$atts['ajax_body'] = trim( $_POST['body'] );
			$data              = woodmart_shortcode_instagram( $atts );

			wp_send_json( $data );
		}
	}

	add_action( 'wp_ajax_woodmart_instagram_ajax_query', 'woodmart_instagram_ajax_query' );
	add_action( 'wp_ajax_nopriv_woodmart_instagram_ajax_query', 'woodmart_instagram_ajax_query' );
}


if ( ! function_exists( 'woodmart_get_instagram_custom_images' ) ) {
	function woodmart_get_instagram_custom_images( $images, $size, $link, $likes, $comments ) {
		if ( ! $images ) {
			return new WP_Error( 'no_images', esc_html__( 'You need to upload your images manually to the element if you want to load them from your website. Otherwise you will need to connect your real Instagram account via API.', 'woodmart' ) );
		}

		$images_output = array();

		$images   = explode( ',', $images );
		$likes    = explode( '-', $likes );
		$comments = explode( '-', $comments );

		foreach ( $images as $key => $image ) {
			if ( empty( $image ) ) {
				continue;
			}

			$images_output[] = array(
				'image_id' => $image,
				'large'    => wp_get_attachment_image_url( $image, $size ),
				'link'     => $link,
				'likes'    => wp_rand( $likes[0], $likes[1] ),
				'comments' => wp_rand( $comments[0], $comments[1] ),
			);
		}

		return $images_output;
	}
}
