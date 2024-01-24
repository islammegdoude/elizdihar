<?php

use Elementor\Group_Control_Image_Size;

if ( ! function_exists( 'woodmart_otf_get_image_html' ) ) {
	/**
	 * Get image html with custom size.
	 *
	 * @param integer      $image_id Image ID.
	 * @param string|array $size Image size.
	 * @param array        $custom_size Image custom size.
	 * @param array        $attr Image attribute.
	 * @return string
	 */
	function woodmart_otf_get_image_html( $image_id, $size = 'thumbnail', $custom_size = array(), $attr = array() ) {
		if ( apply_filters( 'woodmart_old_image_size_function', false ) ) {
			if ( woodmart_is_elementor_installed() ) {
				$image_html = Group_Control_Image_Size::get_attachment_image_html(
					array(
						'image'                  => array(
							'id' => $image_id,
						),
						'image_size'             => $size,
						'image_custom_dimension' => $custom_size,
					)
				);
			} elseif ( function_exists( 'wpb_getImageBySize' ) ) {
				$img = wpb_getImageBySize(
					array(
						'attach_id'  => $image_id,
						'thumb_size' => $size,
					)
				);

				$image_html = isset( $img['thumbnail'] ) ? $img['thumbnail'] : '';
			} else {
				$image_html = wp_get_attachment_image( $image_id, $size, false, $attr );
			}

			return apply_filters( 'woodmart_get_image_html', $image_html, $image_id, $size, $attr );
		}

		if ( 'custom' === $size ) {
			if ( $custom_size ) {
				if ( is_array( $custom_size ) ) {
					$size = array( null, null );

					if ( ! empty( $custom_size['width'] ) ) {
						$size[0] = $custom_size['width'];
					}

					if ( ! empty( $custom_size['height'] ) ) {
						$size[1] = $custom_size['height'];
					}

					if ( ! $size[0] && ! $size[1] ) {
						$size = 'full';
					}
				} elseif ( is_string( $custom_size ) && strpos( $custom_size, 'x' ) ) {
					$size = explode( 'x', $custom_size );
				}
			} else {
				$size = 'full';
			}
		} elseif ( is_string( $size ) && strpos( $size, 'x' ) && 'woodmart_shop_catalog_x2' !== $size ) {
			$size = explode( 'x', $size );
		}

		if ( is_array( $size ) ) {
			if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
				require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/modules/images/library/otf-regenerate-thumbnails.php' );
			}

			add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		$image_html = wp_get_attachment_image( $image_id, $size, false, $attr );

		if ( is_array( $size ) ) {
			remove_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		return apply_filters( 'woodmart_get_image_html', $image_html, $image_id, $size, $attr );
	}
}

if ( ! function_exists( 'woodmart_otf_get_image_url' ) ) {
	/**
	 * Get image url with custom size.
	 *
	 * @param integer      $image_id Image ID.
	 * @param string|array $size Image size.
	 * @param array        $custom_size Image custom size.
	 * @return string
	 */
	function woodmart_otf_get_image_url( $image_id, $size = 'thumbnail', $custom_size = array() ) {
		if ( apply_filters( 'woodmart_old_image_size_function', false ) ) {
			if ( woodmart_is_elementor_installed() ) {
				$image_url = Group_Control_Image_Size::get_attachment_image_src(
					$image_id,
					'image',
					array(
						'image_size'             => $size,
						'image_custom_dimension' => $custom_size,
					)
				);
			} elseif ( function_exists( 'wpb_resize' ) && ( in_array( $size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) || ( is_string( $size ) && preg_match_all( '/\d+/', $size ) ) ) ) {
				$thumb_size = woodmart_get_image_size( $size );
				$img        = wpb_resize( $image_id, null, $thumb_size[0], $thumb_size[1], true );

				$image_url = isset( $img['url'] ) ? $img['url'] : '';
			} else {
				$image_url = wp_get_attachment_image_url( $image_id, $size );
			}

			return apply_filters( 'woodmart_get_image_src', $image_url, $image_id, $size );
		}

		if ( 'custom' === $size ) {
			if ( $custom_size ) {
				if ( is_array( $custom_size ) ) {
					$size = array( null, null );

					if ( ! empty( $custom_size['width'] ) ) {
						$size[0] = $custom_size['width'];
					}

					if ( ! empty( $custom_size['height'] ) ) {
						$size[1] = $custom_size['height'];
					}

					if ( ! $size[0] && ! $size[1] ) {
						$size = 'full';
					}
				} elseif ( is_string( $custom_size ) && strpos( $custom_size, 'x' ) ) {
					$size = explode( 'x', $custom_size );
				}
			} else {
				$size = 'full';
			}
		} elseif ( is_string( $size ) && strpos( $size, 'x' ) && 'woodmart_shop_catalog_x2' !== $size ) {
			$size = explode( 'x', $size );
		}

		if ( is_array( $size ) ) {
			if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
				require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/modules/images/library/otf-regenerate-thumbnails.php' );
			}

			add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		$image_src = wp_get_attachment_image_url( $image_id, $size );

		if ( is_array( $size ) ) {
			remove_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		return apply_filters( 'woodmart_get_image_src', $image_src, $image_id, $size );
	}
}

if ( ! function_exists( 'woodmart_get_all_image_sizes' ) ) {
	/**
	 * Retrieve available image sizes
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_all_image_sizes() {
		global $_wp_additional_image_sizes;

		$default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
		$image_sizes         = array();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ] = array(
				'width'  => (int) get_option( $size . '_size_w' ),
				'height' => (int) get_option( $size . '_size_h' ),
				'crop'   => (bool) get_option( $size . '_crop' ),
			);
		}

		if ( $_wp_additional_image_sizes ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		$image_sizes['full'] = array();

		return $image_sizes;
	}
}


if ( ! function_exists( 'woodmart_get_image_dimensions_by_size_key' ) ) {
	/**
	 * This function return size array by size key.
	 *
	 * @param string $size_key enter 'thumbnail' if you want to get size thumbnail array.
	 * @return array
	 */
	function woodmart_get_image_dimensions_by_size_key( $size_key ) {
		global $_wp_additional_image_sizes;

		if ( isset( $_wp_additional_image_sizes[ $size_key ] ) ) {
			$res = $_wp_additional_image_sizes[ $size_key ];
		} else {
			$res = woodmart_get_image_size( $size_key );
		}

		if ( strpos( $size_key, 'x' ) && 'woodmart_shop_catalog_x2' !== $size_key ) {
			$res = woodmart_get_explode_size( $size_key, '600' );
		}

		return $res;
	}
}

if ( ! function_exists( 'woodmart_get_image_size' ) ) {
	function woodmart_get_image_size( $thumb_size ) {
		if ( in_array( $thumb_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) {
			$images_sizes = woodmart_get_all_image_sizes();
			$image_size   = $images_sizes[ $thumb_size ];
			if ( 'full' === $thumb_size ) {
				$image_size['width']  = 3000;
				$image_size['height'] = 3000;
			}
			return array( $image_size['width'], $image_size['height'] );
		} elseif ( is_string( $thumb_size ) ) {
			preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$thumb_size = array();
				if ( count( $thumb_matches[0] ) > 1 ) {
					$thumb_size[] = $thumb_matches[0][0]; // Width.
					$thumb_size[] = $thumb_matches[0][1]; // Height.
				} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
					$thumb_size[] = $thumb_matches[0][0]; // Width.
					$thumb_size[] = $thumb_matches[0][0]; // Height.
				} else {
					$thumb_size = false;
				}
			}
		}

		return $thumb_size;
	}
}

if ( ! function_exists( 'woodmart_get_image_src' ) ) {
	function woodmart_get_image_src( $thumb_id, $thumb_size ) {
		if ( ! $thumb_size ) {
			return false;
		}

		$thumb_size = woodmart_get_image_size( $thumb_size );
		$thumbnail  = wpb_resize( $thumb_id, null, $thumb_size[0], $thumb_size[1], true );

		return isset( $thumbnail['url'] ) ? $thumbnail['url'] : '';
	}
}
