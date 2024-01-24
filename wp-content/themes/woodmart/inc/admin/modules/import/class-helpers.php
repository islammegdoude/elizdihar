<?php
/**
 * Import helpers.
 *
 * @package Woodmart
 */

namespace XTS\Admin\Modules\Import;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import helpers.
 */
class Helpers extends Singleton {
	/**
	 * Links to replace.
	 *
	 * @var array
	 */
	public $links = array(
		'uploads' => array(
			'http://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',
			'https://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',

			'http://dummy.xtemos.com/woodmart2/megamarket-elementor/wp-content/uploads/sites/4/',
			'https://dummy.xtemos.com/woodmart2/megamarket-elementor/wp-content/uploads/sites/4/',
			'http://dummy.xtemos.com/woodmart2/megamarket/wp-content/uploads/sites/3/',
			'https://dummy.xtemos.com/woodmart2/megamarket/wp-content/uploads/sites/3/',

			'http://dummy.xtemos.com/woodmart2/accessories-elementor/wp-content/uploads/sites/6/',
			'https://dummy.xtemos.com/woodmart2/accessories-elementor/wp-content/uploads/sites/6/',
			'http://dummy.xtemos.com/woodmart2/accessories/wp-content/uploads/sites/5/',
			'https://dummy.xtemos.com/woodmart2/accessories/wp-content/uploads/sites/5/',

			'http://dummy.xtemos.com/woodmart2/mega-electronics-elementor/wp-content/uploads/sites/8/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-elementor/wp-content/uploads/sites/8/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics/wp-content/uploads/sites/7/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics/wp-content/uploads/sites/7/',

			'http://dummy.xtemos.com/woodmart2/furniture2-elementor/wp-content/uploads/sites/10/',
			'https://dummy.xtemos.com/woodmart2/furniture2-elementor/wp-content/uploads/sites/10/',
			'http://dummy.xtemos.com/woodmart2/furniture2/wp-content/uploads/sites/9/',
			'https://dummy.xtemos.com/woodmart2/furniture2/wp-content/uploads/sites/9/',

			'http://dummy.xtemos.com/woodmart2/plants-elementor/wp-content/uploads/sites/12/',
			'https://dummy.xtemos.com/woodmart2/plants-elementor/wp-content/uploads/sites/12/',
			'http://dummy.xtemos.com/woodmart2/plants/wp-content/uploads/sites/11/',
			'https://dummy.xtemos.com/woodmart2/plants/wp-content/uploads/sites/11/',

			'http://dummy.xtemos.com/woodmart2/kids-elementor/wp-content/uploads/sites/14/',
			'https://dummy.xtemos.com/woodmart2/kids-elementor/wp-content/uploads/sites/14/',
			'http://dummy.xtemos.com/woodmart2/kids/wp-content/uploads/sites/13/',
			'https://dummy.xtemos.com/woodmart2/kids/wp-content/uploads/sites/13/',

			'http://dummy.xtemos.com/woodmart2/games-elementor/wp-content/uploads/sites/16/',
			'https://dummy.xtemos.com/woodmart2/games-elementor/wp-content/uploads/sites/16/',
			'http://dummy.xtemos.com/woodmart2/games/wp-content/uploads/sites/15/',
			'https://dummy.xtemos.com/woodmart2/games/wp-content/uploads/sites/15/',

			'http://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'https://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'http://woodmart.xtemos.com/wp-content/uploads/',
			'https://woodmart.xtemos.com/wp-content/uploads/',
		),
		'simple'  => array(
			'http://dummy.xtemos.com/woodmart2/megamarket-elementor/',
			'https://dummy.xtemos.com/woodmart2/megamarket-elementor/',
			'http://dummy.xtemos.com/woodmart2/megamarket/',
			'https://dummy.xtemos.com/woodmart2/megamarket/',

			'http://dummy.xtemos.com/woodmart2/accessories-elementor/',
			'https://dummy.xtemos.com/woodmart2/accessories-elementor/',
			'http://dummy.xtemos.com/woodmart2/accessories/',
			'https://dummy.xtemos.com/woodmart2/accessories/',

			'http://dummy.xtemos.com/woodmart2/mega-electronics-elementor/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-elementor/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics/',

			'http://dummy.xtemos.com/woodmart2/furniture2-elementor/',
			'https://dummy.xtemos.com/woodmart2/furniture2-elementor/',
			'http://dummy.xtemos.com/woodmart2/furniture2/',
			'https://dummy.xtemos.com/woodmart2/furniture2/',

			'http://dummy.xtemos.com/woodmart2/plants-elementor/',
			'https://dummy.xtemos.com/woodmart2/plants-elementor/',
			'http://dummy.xtemos.com/woodmart2/plants/',
			'https://dummy.xtemos.com/woodmart2/plants/',

			'http://dummy.xtemos.com/woodmart2/kids-elementor/',
			'https://dummy.xtemos.com/woodmart2/kids-elementor/',
			'http://dummy.xtemos.com/woodmart2/kids/',
			'https://dummy.xtemos.com/woodmart2/kids/',

			'http://dummy.xtemos.com/woodmart2/games-elementor/',
			'https://dummy.xtemos.com/woodmart2/games-elementor/',
			'http://dummy.xtemos.com/woodmart2/games/',
			'https://dummy.xtemos.com/woodmart2/games/',

			'http://dummy.xtemos.com/woodmart2/elementor/',
			'https://dummy.xtemos.com/woodmart2/elementor/',
			'http://dummy.xtemos.com/woodmart2/',
			'https://dummy.xtemos.com/woodmart2/',
			'https://woodmart.xtemos.com/',
			'http://woodmart.xtemos.com/',
		),
	);

	/**
	 * Init.
	 */
	public function init() {
	}

	/**
	 * Send error.
	 *
	 * @param string $message Message.
	 */
	public function send_error_message( $message ) {
		$this->send_message( 'error', $message );
	}

	/**
	 * Send success.
	 *
	 * @param string $message Message.
	 */
	public function send_success_message( $message ) {
		$this->send_message( 'success', $message );
	}

	/**
	 * Send message.
	 *
	 * @param string $status  Status.
	 * @param string $message Message.
	 */
	public function send_message( $status, $message ) {
		echo wp_json_encode(
			array(
				'status'  => $status,
				'message' => $message,
			)
		);
	}

	/**
	 * Get file data.
	 *
	 * @param string $path File path.
	 *
	 * @return false|string
	 */
	public function get_local_file_content( $path ) {
		ob_start();
		include $path;

		return ob_get_clean();
	}

	/**
	 * Get file path.
	 *
	 * @param string $file_name File name.
	 * @param string $version   Version name.
	 *
	 * @return false|string
	 */
	public function get_file_path( $file_name, $version ) {
		$file = $this->get_version_folder_path( $version ) . $file_name;

		if ( ! file_exists( $file ) ) {
			return false;
		}

		return $file;
	}

	/**
	 * Get version folder path.
	 *
	 * @param string $version Version name.
	 *
	 * @return string
	 */
	public function get_version_folder_path( $version ) {
		return WOODMART_THEMEROOT . '/inc/admin/modules/import/dummy-data/' . $version . '/';
	}

	/**
	 * Replace link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $data    Data.
	 * @param string $replace Replace.
	 *
	 * @return string|string[]
	 */
	public function links_replace( $data, $replace = '\/' ) {
		$links = $this->links;

		foreach ( $links as $key => $value ) {
			if ( 'uploads' === $key ) {
				foreach ( $value as $link ) {
					$url_data = wp_upload_dir();
					$data     = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, $url_data['baseurl'] . '/' ), $data );
				}
			}

			if ( 'simple' === $key ) {
				foreach ( $value as $link ) {
					$data = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, get_home_url() . '/' ), $data );
				}
			}
		}

		return $data;
	}

	/**
	 * Get imported data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version name.
	 *
	 * @return array
	 */
	public function get_imported_data( $version ) {
		if ( in_array( $version . '_base', $this->get_base_version(), true ) ) {
			$base = get_option( 'wd_imported_data_' . $version . '_base' );
		} else {
			$base = get_option( 'wd_imported_data_base' );
		}

		$demo = get_option( 'wd_imported_data_' . $version );

		if ( in_array( $version, $this->get_base_version(), true ) ) {
			return $demo;
		}

		if ( $demo && $base ) {
			return array_replace_recursive( $base, $demo );
		} else {
			return array();
		}
	}

	/**
	 * Get base version for import.
	 *
	 * @return array
	 */
	public function get_base_version() {
		return array( 'base', 'megamarket_base', 'accessories_base', 'mega-electronics_base', 'furniture2_base', 'plants_base', 'kids_base', 'games_base-light', 'games_base-dark', 'plants_base', 'kids_base' );
	}
}
