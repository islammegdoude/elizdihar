<?php

namespace XTS\Modules\Header_Builder;

/**
 * ------------------------------------------------------------------------------------------------
 * Handle backend AJAX actions. Creat, load, remove headers from the backend interface with AJAX.
 * ------------------------------------------------------------------------------------------------
 */
class Manager {
	private $_factory;

	/**
	 * Headers list.
	 *
	 * @var
	 */
	private $_list;

	/**
	 * Constructor.
	 */
	public function __construct( $factory, $list ) {
		$this->_factory = $factory;
		$this->_list    = $list;

		add_action( 'wp_ajax_woodmart_save_header', array( $this, 'save_header' ) );
		add_action( 'wp_ajax_woodmart_duplicate_header', array( $this, 'duplicate_header' ) );
		add_action( 'wp_ajax_woodmart_load_header', array( $this, 'load_header' ) );
		add_action( 'wp_ajax_woodmart_remove_header', array( $this, 'remove_header' ) );
		add_action( 'wp_ajax_woodmart_set_default_header', array( $this, 'set_default_header' ) );
	}

	/**
	 * Duplicate header action.
	 *
	 * @return void
	 */
	public function duplicate_header() {
		check_ajax_referer( 'woodmart-builder-save-header-nonce', 'security' );

		$id        = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : '';
		$header    = $this->_factory->get_header( $id );
		$structure = $header->get_structure();
		$settings  = $header->get_settings();
		$name      = $header->get_name();

		$new_id   = $this->generate_id();
		$new_name = $name . ' ' . esc_html__( '(Copy)', 'woodmart' );

		$header = $this->_factory->create_new( $new_id, $new_name, $structure, $settings );

		$this->_list->add_header( $new_id, $new_name );

		$this->send_header_data( $header );
	}

	/**
	 * Save header settings.
	 *
	 * @return void
	 */
	public function save_header() {
		check_ajax_referer( 'woodmart-builder-save-header-nonce', 'security' );

		$structure = stripslashes( $_POST['structure'] ); //phpcs:ignore
		$settings  = stripslashes( $_POST['settings'] ); //phpcs:ignore

		// If we import a new header we don't have an ID.
		$id   = ( isset( $_POST['id'] ) ) ? sanitize_text_field( stripslashes( $_POST['id'] ) ) : $this->generate_id(); //phpcs:ignore
		$name = sanitize_text_field( stripslashes( $_POST['name'] ) ); //phpcs:ignore

		$header = $this->_factory->update_header( $id, $name, json_decode( $structure, true ), json_decode( $settings, true ) );

		$this->_list->add_header( $id, $name );

		$this->send_header_data( $header );
	}

	/**
	 * Load header.
	 *
	 * @return void
	 */
	public function load_header() {
		check_ajax_referer( 'woodmart-builder-load-header-nonce', 'security' );

		$id   = sanitize_text_field( $_GET['id'] ); //phpcs:ignore
		$base = ( isset( $_GET['base'] ) ) ? sanitize_text_field( $_GET['base'] ) : false; //phpcs:ignore

		if ( isset( $_GET['initial'] ) && $_GET['initial'] || $base ) { //phpcs:ignore
			$header = $this->new_header( $base );
		} else {
			$header = $this->_factory->get_header( $id );
		}

		$this->send_header_data( $header );
	}

	/**
	 * Send header data.
	 *
	 * @param object $header Header data.
	 *
	 * @return void
	 */
	private function send_header_data( $header ) {
		$data = $header->get_data();

		$data['list'] = $this->_list->get_all();

		echo wp_json_encode( $data );

		wp_die();
	}

	/**
	 * Create new header.
	 *
	 * @param string $base Template name.
	 *
	 * @return mixed
	 */
	private function new_header( $base = false ) {
		$list = $this->_list->get_all();
		$id   = $this->generate_id();
		$name = esc_html__( 'Header layout', 'woodmart' ) . ' (' . ( count( $list ) + 1 ) . ')';

		if ( $base ) {
			$examples = $this->_list->get_examples();

			if ( isset( $examples[ $base ] ) ) {
				$data      = json_decode( $this->get_example_json( $base ), true );
				$structure = $data['structure'];
				$settings  = $data['settings'];
				$name      = $data['name'];
			} elseif ( isset( $list[ $base ] ) ) {
				$data      = $this->_factory->get_header( $base );
				$structure = $data->get_structure();
				$settings  = $data->get_settings();
			}

			$header = $this->_factory->create_new( $id, $name, $structure, $settings );
		} else {
			$header = $this->_factory->create_new( $id, $name );
		}

		$this->_list->add_header( $id, $name );

		return $header;
	}

	/**
	 * Get settings header JSON.
	 *
	 * @param string $file File name.
	 *
	 * @return false|string
	 */
	private function get_example_json( $file ) {
		ob_start();

		include WOODMART_THEMEROOT . '/inc/modules/header-builder/examples/' . $file . '.json';

		return ob_get_clean();
	}

	/**
	 * Get random header ID.
	 *
	 * @return string
	 */
	private function generate_id() {
		return 'header_' . wp_rand( 100000, 999999 );
	}

	/**
	 * Remove header.
	 *
	 * @return void
	 */
	public function remove_header() {
		check_ajax_referer( 'woodmart-builder-remove-header-nonce', 'security' );

		$id = sanitize_text_field( stripslashes( $_GET['id'] ) ); //phpcs:ignore

		delete_option( 'whb_' . $id );
		delete_option( 'xts-' . $id . '-file-data' );
		delete_option( 'xts-' . $id . '-css-data' );
		delete_option( 'xts-' . $id . '-version' );
		delete_option( 'xts-' . $id . '-site-url' );
		delete_option( 'xts-' . $id . '-status' );

		echo wp_json_encode(
			array(
				'list' => $this->_list->remove( $id ),
			)
		);

		wp_die();

	}

	/**
	 * Set default header.
	 *
	 * @return void
	 */
	public function set_default_header() {
		check_ajax_referer( 'woodmart-builder-set-default-header-nonce', 'security' );

		$id = sanitize_text_field( stripslashes( $_GET['id'] ) ); //phpcs:ignore

		update_option( 'whb_main_header', $id );

		$options = get_option( 'xts-woodmart-options' );

		$options['default_header'] = $id;

		update_option( 'xts-woodmart-options', $options );

		echo wp_json_encode(
			array(
				'default_header' => $id,
			)
		);

		wp_die();
	}

	/**
	 * Get default header ID.
	 *
	 * @return int
	 */
	public function get_default_header() {
		$id = get_option( 'whb_main_header' );

		if ( ! $id ) {
			$id = WOODMART_HB_DEFAULT_ID;
		}

		return $id;
	}
}
