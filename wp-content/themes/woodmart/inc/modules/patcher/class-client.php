<?php
/**
 * The client class for patch.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Patcher;

use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * The client class for patch.
 */
class Client extends Singleton {
	/**
	 * The uri of the patches remote server.
	 *
	 * @var string
	 */
	public $remote_patches_uri = 'https://xtemos.com/wp-json/xts/v1/patches_maps/';

	/**
	 * Version site.
	 *
	 * @var string
	 */
	public $theme_version;

	/**
	 * Process notices.
	 *
	 * @var array
	 */
	public $notices = array();

	/**
	 * Transient name.
	 *
	 * @var string
	 */
	public $transient_name = '';

	/**
	 * Register hooks and load base data.
	 */
	public function init() {
		$this->theme_version  = WOODMART_VERSION;
		$this->transient_name = 'xts_patches_map_' . $this->theme_version;
	}

	/**
	 * Get count patches map.
	 *
	 * @return string
	 */
	public function get_count_patches_map() {
		global $pagenow;

		$patches_maps = get_transient( $this->transient_name );

		if ( 'admin.php' === $pagenow && isset( $_GET['page'] ) ) { //phpcs:ignore.
			if ( in_array( $_GET['page'], array( 'xts_dashboard', 'xts_theme_settings' ), true ) ) { //phpcs:ignore.
				$patches_maps = $this->get_patches_maps();
			} else if ( 'xts_patcher' === $_GET['page'] ) { //phpcs:ignore.
				$patches_maps = $this->get_patches_maps_from_server();
			}
		}

		if ( ! $patches_maps || ! is_array( $patches_maps ) ) {
			return '';
		}

		$patches_installed = get_option( 'xts_successfully_installed_patches', array() );

		if ( isset( $patches_installed[ $this->theme_version ] ) ) {
			$patches_maps = array_diff_key( $patches_maps, $patches_installed[ $this->theme_version ] );
		}

		$count = count( $patches_maps );

		if ( 0 === $count ) {
			return '';
		}

		ob_start();
		?>
		<span class="xts-patcher-counter update-plugins count-<?php echo esc_attr( $count ); ?>">
			<span class="patcher-count">
				<?php echo esc_html( $count ); ?>
			</span>
		</span>
		<?php

		return ob_get_clean();
	}

	/**
	 * Interface in admin panel.
	 */
	public function render() {
		wp_enqueue_script( 'woodmart-patcher-scripts', WOODMART_ASSETS . '/js/patcher.js', array(), WOODMART_VERSION, true );
		wp_localize_script( 'woodmart-patcher-scripts', 'woodmart_patch_notice', $this->add_localized_settings() );

		$patches               = $this->get_patches_maps();
		$patch_installed       = get_option( 'xts_successfully_installed_patches' );
		$all_patches_installed = empty( array_diff( array_keys( $patches ), isset( $patch_installed[ $this->theme_version ] ) ? array_keys( $patch_installed[ $this->theme_version ] ) : array() ) );

		?>
		<div class="xts-box xts-theme-style">
			<div class="xts-box-header">
				<h3>
					<?php esc_html_e( 'Patcher', 'woodmart' ); ?>
				</h3>
				<?php if ( $patches && $this->check_filesystem_api() ) : ?>
					<div class="xts-patch-button-wrapper <?php echo $all_patches_installed ? 'xts-applied' : ''; ?>">
						<a href="#" class="xts-btn xts-color-primary xts-patch-apply-all xts-i-check">
							<?php esc_html_e( 'Apply all', 'woodmart' ); ?>
						</a>
						<span class="xts-patch-label-applied xts-i-check">
							<?php esc_html_e( 'All applied', 'woodmart' ); ?>
						</span>
					</div>
				<?php endif; ?>
			</div>

			<div class="xts-box-content">
				<?php if ( $patches ) : ?>
					<div class="xts-notices-wrapper xts-patches-notice"><?php $this->print_notices(); // Must be in one line. ?></div>

					<div class="xts-table xts-even xts-patches-wrapper">

						<div class="xts-table-row-heading xts-patch-item xts-patch-title-wrapper">
							<div class="xts-patch-id">
								<?php esc_html_e( 'Patch ID', 'woodmart' ); ?>
							</div>
							<div class="xts-patch-description">
								<?php esc_html_e( 'Description', 'woodmart' ); ?>
							</div>
							<div class="xts-patch-date">
								<?php esc_html_e( 'Date', 'woodmart' ); ?>
							</div>
							<div class="xts-patch-button-wrapper"></div>
						</div>

						<?php foreach ( $patches as $patch_id => $patcher ) : ?>
							<?php $classes = isset( $patch_installed[ $this->theme_version ][ $patch_id ] ) ? ' xts-applied' : ''; ?>
							<div class="xts-table-row xts-patch-item<?php echo esc_attr( $classes ); ?>">
								<div class="xts-patch-id">
									<?php echo esc_html( $patch_id ); ?>
								</div>
								<div class="xts-patch-description">
									<?php echo apply_filters( 'the_content', $patcher['description'] ); //phpcs:ignore ?>
								</div>
								<div class="xts-patch-date">
									<?php echo esc_html( $patcher['date'] ); ?>
								</div>
								<div class="xts-patch-button-wrapper">
									<?php if ( ! $this->check_filesystem_api() ) : ?>
										<a href="<?php echo esc_url( $patcher['patch_link'] ); ?>" class="xts-btn xts-color-primary">
											<?php esc_html_e( 'Download', 'woodmart' ); ?>
										</a>
									<?php else : ?>
										<a href="#" class="xts-btn xts-color-primary xts-patch-apply xts-i-check" data-patches-map='<?php echo wp_json_encode( $patcher['files'] ); ?>' data-id="<?php echo esc_html( $patch_id ); ?>">
											<?php esc_html_e( 'Apply', 'woodmart' ); ?>
										</a>
										<span class="xts-patch-label-applied xts-i-check">
											<?php esc_html_e( 'Applied', 'woodmart' ); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="xts-empty-patches xts-align-center">
						<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/empty-patcher.svg' ); ?>" alt="banner">
						<p>
							<?php esc_html_e( 'There are no patches found for your theme version.', 'woodmart' ); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( ! woodmart_get_opt( 'white_label' ) ) : ?>
				<div class="xts-box-footer">
					<p>
						Read more about automatic patcher tool in our <a href="https://xtemos.com/docs-topic/automatic-patcher/" target="_blank">documentation</a>.
					</p>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Print notices.
	 */
	public function print_notices() {
		if ( ! $this->check_filesystem_api() ) {
			$this->notices['warning'] = esc_html__( 'Direct access to theme file is not allowed on your server. You need to download and replace the files manually.', 'woodmart' );
		}

		if ( ! $this->notices ) {
			return;
		}

		foreach ( $this->notices as $type => $notice ) {
			$this->print_notice( $notice, $type );
		}
	}

	/**
	 * Print notice.
	 *
	 * @param string $message Message.
	 * @param string $type    Type.
	 */
	private function print_notice( $message, $type = 'warning' ) {
		?>
		<div class="xts-notice xts-<?php echo esc_attr( $type ); ?>">
			<?php echo wp_kses( $message, woodmart_get_allowed_html() ); ?>
		</div>
		<?php
	}

	/**
	 * Get patches maps.
	 *
	 * @return array
	 */
	public function get_patches_maps() {
		$patches_maps = get_transient( $this->transient_name );

		if ( ! $patches_maps ) {
			$patches_maps = $this->get_patches_maps_from_server();
		}

		if ( ! is_array( $patches_maps ) ) {
			return array();
		}

		return $patches_maps;
	}

	/**
	 * Queries the patches server for a list of patches.
	 *
	 * @return array
	 */
	public function get_patches_maps_from_server() {
		$url = add_query_arg(
			array(
				'theme_slug' => WOODMART_SLUG,
				'version'    => $this->theme_version,
			),
			$this->remote_patches_uri
		);

		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			$this->notices['error'] = $response->get_error_message();
			$this->update_set_transient( 'error' );
			return array();
		}

		if ( ! isset( $response['body'] ) ) {
			$this->notices['error'] = $response['response']['code'] . ': ' . $response['response']['message'];
			$this->update_set_transient( 'error' );
			return array();
		}

		$response_body = json_decode( $response['body'], true );

		if ( isset( $response_body['code'] ) && isset( $response_body['message'] ) ) {
			$this->notices['error'] = $response_body['message'];
			$this->update_set_transient( 'error' );
			return array();
		}

		if ( isset( $response_body['type'] ) && isset( $response_body['message'] ) ) {
			$this->notices[ $response_body['type'] ] = $response_body['message'];
			$this->update_set_transient( $response_body['type'] );
			return array();
		}

		if ( ! $response_body ) {
			$this->update_set_transient( 'actual' );
			return array();
		}

		$this->update_set_transient( $response_body );

		return $response_body;
	}

	/**
	 * Sets/updates the value of a transient.
	 *
	 * @param string|array $data Value.
	 *
	 * @return void
	 */
	public function update_set_transient( $data ) {
		set_transient( $this->transient_name, $data, DAY_IN_SECONDS );
	}


	/**
	 * Check filesystem API.
	 *
	 * @return bool
	 */
	public function check_filesystem_api() {
		global $wp_filesystem;

		if ( function_exists( 'WP_Filesystem' ) ) {
			WP_Filesystem();
		}

		return 'direct' === $wp_filesystem->method;
	}

	/**
	 * Add localized settings.
	 *
	 * @return array
	 */
	public function add_localized_settings() {
		return array(
			'single_patch_confirm' => esc_html__( 'These files will be updated:', 'woodmart' ),
			'all_patches_confirm'  => esc_html__( 'Are you sure you want to download all patches?', 'woodmart' ),
			'all_patches_applied'  => esc_html__( 'All patches are applied.', 'woodmart' ),
			'ajax_error'           => esc_html__( 'Something wrong with removing data. Please, try to remove data manually or contact our support center for further assistance.', 'woodmart' ),
		);
	}
}
