<?php
/**
 * Enable auto updates.
 *
 * @package xts
 */

namespace XTS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use \stdClass;

/**
 * Enable auto updates
 */
class Autoupdates {
	private $_api             = null;
	private $_notices         = null;
	private $_current_version = '';
	private $_theme_name      = '';
	private $old_api_url      = 'https://xtemos.com/licenses/api/';
	private $_info;

	function __construct() {
		$this->_current_version = woodmart_get_theme_info( 'Version' );
		$this->_theme_name      = WOODMART_SLUG;

		$this->_api     = Registry::getInstance()->api;
		$this->_notices = Registry::getInstance()->notices;

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'update_plugins_version' ), 30 );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'update_plugins_version' ), 30 );
		add_filter( 'woodmart_setup_wizard', array( $this, 'update_plugins_version' ), 30 );

		if ( ! woodmart_is_license_activated() ) {
			return;
		}

		add_filter( 'site_transient_update_themes', array( $this, 'update_transient' ), 20, 2 );

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'set_update_transient' ) );
		add_filter( 'themes_api', array( &$this, 'api_results' ), 10, 3 );
	}

	/**
	 * Update transient.
	 *
	 * @param string $value Data.
	 * @param string $transient Transient.
	 *
	 * @return false|mixed
	 */
	public function update_transient( $value, $transient ) {
		if ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) {
			return false;
		}

		return $value;
	}

	/**
	 * Update Transient.
	 *
	 * @param string $transient Transient.
	 *
	 * @return mixed
	 */
	public function set_update_transient( $transient ) {
		$this->check_for_update();

		if ( isset( $transient ) && ! isset( $transient->response ) ) {
			$transient->response = array();
		}

		if ( ! empty( $this->_info ) && is_object( $this->_info ) ) {
			if ( $this->is_update_available() ) {
				$transient->response[ $this->_theme_name ] = json_decode( wp_json_encode( $this->_info ), true );
			}
		}

		remove_action( 'site_transient_update_themes', array( $this, 'update_transient' ), 20, 2 );

		return $transient;
	}


	/**
	 * Get API result.
	 *
	 * @param string $result API result.
	 * @param string $action Action.
	 * @param object $args Args.
	 *
	 * @return mixed
	 */
	public function api_results( $result, $action, $args ) {
		$this->check_for_update();

		if ( isset( $args->slug ) && $args->slug === $this->_theme_name && 'theme_information' === $action ) {
			if ( is_object( $this->_info ) && ! empty( $this->_info ) ) {
				$result = $this->_info;
			}
		}

		return $result;
	}

	/**
	 * Check for theme update.
	 *
	 * @return void
	 */
	protected function check_for_update() {
		$force = false;

		if ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) {
			$force = true;
		}

		// Get data.
		if ( empty( $this->_info ) ) {
			$version_information = get_option( 'woodmart-update-info', false );
			$version_information = $version_information ? $version_information : new stdClass();

			$this->_info = is_object( $version_information ) ? $version_information : maybe_unserialize( $version_information );

		}

		$last_check = get_option( 'woodmart-update-time' );

		if ( ! $last_check ) {
			update_option( 'woodmart-update-time', time() );
		}

		if ( time() - $last_check > 172800 || $force || ! $last_check ) {
			$response = $this->api_info();

			update_option( 'woodmart-update-time', time() );

			$this->_info              = new stdClass();
			$this->_info->new_version = $response->version;
			$this->_info->version     = $response->version;
			$this->_info->theme       = $response->theme;
			$this->_info->checked     = time();
			$this->_info->url         = 'https://xtemos.com/woodmart-changelog.php';
			$this->_info->package     = $this->download_url();

		}

		// Save results.
		update_option( 'woodmart-update-info', $this->_info );
	}

	/**
	 * Get API info.
	 *
	 * @return array|mixed|stdClass|null
	 */
	public function api_info() {
		$version_information = new stdClass();

		$response = $this->_api->call(
			'info/' . $this->_theme_name,
			array(),
			'get',
			$this->old_api_url
		);

		if ( isset( $_GET['xtemos_debug'] ) ) {
			ar( $response );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code != '200' ) {
			return array();
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! $response->version ) {
			return $version_information;
		}

		return $response;
	}

	/**
	 * Update plugin version.
	 *
	 * @param mixed $transient Transient.
	 *
	 * @return mixed
	 */
	public function update_plugins_version( $transient ) {
		$api        = Registry::getInstance()->api;
		$plugins    = array( 'js_composer', 'revslider' );
		$force      = false;
		$last_check = get_option( 'woodmart-plugins-update-time' );

		if ( ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) || ( isset( $_GET['tab'] ) && 'wizard' === $_GET['tab'] ) ) {
			$force = true;
		}

		if ( ! $last_check ) {
			update_option( 'woodmart-plugins-update-time', time() );
		}

		if ( time() - $last_check > 172800 || $force || ! $last_check ) {
			update_option( 'woodmart-plugins-update-time', time() );

			foreach ( $plugins as $plugin ) {
				$query         = $this->_api->call(
					'info/' . $plugin,
					array(),
					'get',
					$this->old_api_url
				);
				$response_code = wp_remote_retrieve_response_code( $query );

				if ( '200' !== (string) $response_code ) {
					continue;
				}

				$response = json_decode( wp_remote_retrieve_body( $query ) );

				if ( ! property_exists( $response, 'version' ) ) {
					continue;
				}

				update_option( 'woodmart_' . $plugin . '_version', $response->version );
			}
		}

		return $transient;
	}

	/**
	 * Check is update available.
	 *
	 * @return bool|int
	 */
	public function is_update_available() {
		return version_compare( $this->_current_version, $this->release_version(), '<' );
	}

	/**
	 * Get download url files.
	 */
	public function download_url() {
		return $this->_api->get_url(
			'download',
			array(
				'token' => get_option( 'woodmart_token' ),
				'theme' => $this->_theme_name,
			)
		);
	}

	/**
	 * Get maybe next version.
	 *
	 * @return mixed
	 */
	public function release_version() {
		$this->check_for_update();
		return $this->_info->new_version;
	}
}
