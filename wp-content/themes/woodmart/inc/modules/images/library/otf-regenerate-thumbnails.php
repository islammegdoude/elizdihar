<?php
/*
Plugin Name: OTF Regenerate Thumbnails
Plugin URI: http://github.com
Description: Automatically regenerates your thumbnails on the fly (OTF) after changing the thumbnail sizes or switching themes.
Author: Benjamin Intal - Gambit Technologies Inc
Version: 0.3
Author URI: http://gambit.ph
*/

/**
 * Simple but effectively resizes images on the fly. Doesn't upsize, just downsizes like how WordPress likes it.
 * If the image already exists, it's served. If not, the image is resized to the specified size, saved for
 * future use, then served.
 *
 * @author  Benjamin Intal - Gambit Technologies Inc
 * @see https://wordpress.stackexchange.com/questions/53344/how-to-generate-thumbnails-when-needed-only/124790#124790
 * @see http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 */
if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
	/**
	 * The downsizer. This only does something if the existing image size doesn't exist yet.
	 *
	 * @param boolean $out false.
	 * @param int     $id Attachment ID.
	 * @param mixed   $size The size name, or an array containing the width & height.
	 * @return  mixed False if the custom downsize failed, or an array of the image if successful
	 */
	function gambit_otf_regen_thumbs_media_downsize( $out, $id, $size ) {

		// Gather all the different image sizes of WP (thumbnail, medium, large) and,
		// all the theme/plugin-introduced sizes.
		global $_gambit_otf_regen_thumbs_all_image_sizes;
		if ( ! isset( $_gambit_otf_regen_thumbs_all_image_sizes ) ) {
			global $_wp_additional_image_sizes;

			$_gambit_otf_regen_thumbs_all_image_sizes = array();
			$interim_sizes                            = get_intermediate_image_sizes();

			foreach ( $interim_sizes as $size_name ) {
				if ( in_array( $size_name, array( 'thumbnail', 'medium', 'large' ), true ) ) {
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['width']  = get_option( $size_name . '_size_w' );
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['height'] = get_option( $size_name . '_size_h' );
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['crop']   = (bool) get_option( $size_name . '_crop' );

				} elseif ( isset( $_wp_additional_image_sizes[ $size_name ] ) ) {

					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ] = $_wp_additional_image_sizes[ $size_name ];
				}
			}
		}

		// This now contains all the data that we have for all the image sizes.
		$all_sizes = $_gambit_otf_regen_thumbs_all_image_sizes;

		// If image size exists let WP serve it like normally.
		$imagedata = wp_get_attachment_metadata( $id );

		// Image attachment doesn't exist.
		if ( ! is_array( $imagedata ) ) {
			return false;
		}

		$att_url = wp_get_attachment_url( $id );

		// start Woodmart code.
		// define upload path & dir.
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info['basedir'];
		$upload_url  = $upload_info['baseurl'];
		$theme_url   = get_template_directory_uri();
		$theme_dir   = get_template_directory();

		// find the path of the image. Perform 2 checks:
		// #1 check if the image is in the uploads folder
		if ( strpos( $att_url, $upload_url ) !== false ) {
			$rel_path = str_replace( $upload_url, '', $att_url );
			$img_path = $upload_dir . $rel_path;
			// #2 check if the image is in the current theme folder
		} else if ( strpos( $att_url, $theme_url ) !== false ) {
			$rel_path = str_replace( $theme_url, '', $att_url );
			$img_path = $theme_dir . $rel_path;
		}
		// Fail if we can't find the image in our WP local directory
		if ( empty( $img_path ) ) {
			return false;
		}

		// check if img path exists, and is an image indeed
		if ( ! @file_exists( $img_path ) || ! getimagesize( $img_path ) ) {
			if ( ! isset( $imagedata['width'] ) || ! isset( $imagedata['height'] ) ) {
				return false;
			}

			return array( dirname( $att_url ), $imagedata['width'], $imagedata['height'], false );
		}

		if ( is_string( $size ) && ! empty( $all_sizes[ $size ] ) && ( $imagedata['width'] < $all_sizes[ $size ]['width'] || $imagedata['height'] < $all_sizes[ $size ]['height'] ) ) {
			return false;
		} elseif ( is_array( $size ) && ( ( ! empty( $size[0] ) && $imagedata['width'] < $size[0] ) || ( ! empty( $size[1] ) && $imagedata['height'] < $size[1] ) ) ) {
			return false;
		}
		// end Woodmart code.

		// If the size given is a string / a name of a size.
		if ( is_string( $size ) ) {
			// If WP doesn't know about the image size name, then we can't really do any resizing of our own.
			if ( empty( $all_sizes[ $size ] ) ) {
				return false;
			}

			// If the size has already been previously created, use it.
			if ( ! empty( $imagedata['sizes'][ $size ] ) && ! empty( $all_sizes[ $size ] ) ) {

				// But only if the size remained the same.
				if ( $all_sizes[ $size ]['width'] == $imagedata['sizes'][ $size ]['width'] && $all_sizes[ $size ]['height'] == $imagedata['sizes'][ $size ]['height'] ) {
					return false;
				}

				// Or if the size is different and we found out before that the size really was different.
				if ( ! empty( $imagedata['sizes'][ $size ]['width_query'] )
					&& ! empty( $imagedata['sizes'][ $size ]['height_query'] ) ) {
					if ( $imagedata['sizes'][ $size ]['width_query'] == $all_sizes[ $size ]['width'] && $imagedata['sizes'][ $size ]['height_query'] == $all_sizes[ $size ]['height'] ) {
						return false;
					}
				}
			}

			// Resize the image.
			$resized = image_make_intermediate_size(
				get_attached_file( $id ),
				$all_sizes[ $size ]['width'],
				$all_sizes[ $size ]['height'],
				$all_sizes[ $size ]['crop']
			);

			// Resize somehow failed.
			if ( ! $resized ) {
				return false;
			}

			// Save the new size in WP.
			$imagedata['sizes'][ $size ] = $resized;

			// Save some additional info so that we'll know next time whether we've resized this before.
			$imagedata['sizes'][ $size ]['width_query']  = $all_sizes[ $size ]['width'];
			$imagedata['sizes'][ $size ]['height_query'] = $all_sizes[ $size ]['height'];

			wp_update_attachment_metadata( $id, $imagedata );

			// Serve the resized image.
			return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], true );

			// If the size given is a custom array size.
		} elseif ( is_array( $size ) ) {
			$image_path = get_attached_file( $id );
			$crop       = array_key_exists( 2, $size ) ? $size[2] : true;
			$new_width  = $size[0];
			$new_height = $size[1];

			if ( ! empty( $imagedata['sizes'][ $new_width . 'x' . $new_height ]['file'] ) ) {
				$image_size_data  = $imagedata['sizes'][ $new_width . 'x' . $new_height ];
				$maybe_new_width  = $image_size_data['width'];
				$maybe_new_height = $image_size_data['height'];
				$image_ext        = pathinfo( $image_path, PATHINFO_EXTENSION );
				$maybe_image_path = preg_replace( '/^(.*)\.' . $image_ext . '$/', sprintf( '$1-%sx%s.%s', $maybe_new_width, $maybe_new_height, $image_ext ), $image_path );

				// If it already exists, serve it.
				if ( file_exists( $maybe_image_path ) ) {
					return array( dirname( $att_url ) . '/' . basename( $maybe_image_path ), $maybe_new_width, $maybe_new_height, $crop );
				}
			}

			// If crop is false, calculate new image dimensions.
			if ( ! $crop ) {
				if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
					add_filter( 'jetpack_photon_override_image_downsize', '__return_true' );
					$true_data = wp_get_attachment_image_src( $id, 'large' );
					remove_filter( 'jetpack_photon_override_image_downsize', '__return_true' );
				} else {
					$true_data = wp_get_attachment_image_src( $id, 'large' );
				}

				if ( $true_data[1] > $true_data[2] ) {
					// Width > height.
					$ratio      = $true_data[1] / $size[0];
					$new_height = round( $true_data[2] / $ratio );
					$new_width  = $size[0];
				} else {
					// Height > width.
					$ratio      = $true_data[2] / $size[1];
					$new_height = $size[1];
					$new_width  = round( $true_data[1] / $ratio );
				}
			}

			// This would be the path of our resized image if the dimensions existed.
			$image_ext  = pathinfo( $image_path, PATHINFO_EXTENSION );
			$image_path = preg_replace( '/^(.*)\.' . $image_ext . '$/', sprintf( '$1-%sx%s.%s', $new_width, $new_height, $image_ext ), $image_path );

			// If it already exists, serve it.
			if ( file_exists( $image_path ) ) {
				return array( dirname( $att_url ) . '/' . basename( $image_path ), $new_width, $new_height, $crop );
			}

			// If not, resize the image...
			$resized = image_make_intermediate_size(
				get_attached_file( $id ),
				$size[0],
				$size[1],
				$crop
			);

			// Get attachment meta so we can add new size.
			$imagedata = wp_get_attachment_metadata( $id );

			// Save the new size in WP so that it can also perform actions on it.
			$imagedata['sizes'][ $size[0] . 'x' . $size[1] ] = $resized;
			wp_update_attachment_metadata( $id, $imagedata );

			// Resize somehow failed.
			if ( ! $resized ) {
				return false;
			}

			// Then serve it.
			return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], $crop );
		}

		return false;
	}
	// add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
}
