<?php
/**
 * Checkout ajax actions class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Checkout_Fields;

use XTS\Singleton;

/**
 * Checkout ajax actions class.
 */
class Ajax_Actions extends Singleton {
	/**
	 * Instance of the Helper class.
	 *
	 * @var Helper
	 */
	public $helper;

	/**
	 * Init.
	 *
	 * @see Ajax_Actions::save_fields_order() Handler for the 'save_fields_order' ajax event.
	 * @see Ajax_Actions::save_fields_required() Handler for the 'save_fields_required' ajax event.
	 * @see Ajax_Actions::save_fields_status() Handler for the 'save_fields_status' ajax event.
	 * @see Ajax_Actions::save_fields_position() Handler for the 'save_fields_position' ajax event.
	 */
	public function init() {
		$this->helper = Helper::get_instance();

		$actions = array(
			'save_fields_order',
			'save_fields_required',
			'save_fields_status',
			'save_fields_position',
		);

		foreach ( $actions as $action ) {
			add_action( 'wp_ajax_' . $action, array( $this, $action ) );
		}
	}

	/**
	 * Save fields order ajax action.
	 *
	 * @return void
	 */
	public function save_fields_order() {
		check_ajax_referer( 'checkout_fields_manager_nonce', 'security' );

		$field_order    = woodmart_clean( $_POST['sorted_fields'] ); // phpcs:ignore
		$current_tab    = woodmart_clean( $_POST['current_tab'] ); // phpcs:ignore
		$default_fields = $this->helper->get_default_fields( $current_tab );
		$change_options = get_option( 'xts_checkout_fields_manager_options', array() );
		$priority       = 10;

		foreach ( $field_order as $field_id ) {
			if ( ! array_key_exists( $field_id, $default_fields ) ) {
				continue;
			}

			$change_options[ $current_tab ][ $field_id ]['priority'] = $priority;

			$priority += 10;
		}

		update_option( 'xts_checkout_fields_manager_options', $change_options, false );
	}

	/**
	 * Recursively remove empty arrays.
	 *
	 * @param array $haystack The array is not cleared.
	 *
	 * @return array
	 */
	public function recursive_unset_empty_array( $haystack ) {
		foreach ( $haystack as $key => $value ) {
			if ( is_array( $value ) ) {
				$haystack[ $key ] = $this->recursive_unset_empty_array( $haystack[ $key ] );
			}

			if ( is_array( $value ) && empty( $haystack[ $key ] ) ) {
				unset( $haystack[ $key ] );
			}
		}

		return $haystack;
	}

	/**
	 * Save fields required ajax action.
	 *
	 * @return void
	 */
	public function save_fields_required() {
		check_ajax_referer( 'checkout_fields_manager_nonce', 'security' );

		$field_name     = woodmart_clean( $_POST['field_name'] ); // phpcs:ignore
		$status         = woodmart_clean( $_POST['status'] ); // phpcs:ignore
		$current_tab    = woodmart_clean( $_POST['current_tab'] ); // phpcs:ignore
		$default_fields = $this->helper->get_default_fields( $current_tab );
		$change_options = get_option( 'xts_checkout_fields_manager_options', array() );

		if ( array_key_exists( $field_name, $default_fields ) ) {
			if ( (bool) $status !== $default_fields[ $field_name ]['required'] ) {
				$change_options[ $current_tab ][ $field_name ]['required'] = (bool) $status;
			} elseif ( isset( $change_options[ $current_tab ][ $field_name ]['required'] ) ) {
				unset( $change_options[ $current_tab ][ $field_name ]['required'] );
			}

			$change_options = $this->recursive_unset_empty_array( $change_options );
		}

		update_option( 'xts_checkout_fields_manager_options', $change_options, false );

		ob_start();

		$this->helper->get_template(
			'status-button',
			array(
				'id'       => $field_name,
				'status'   => $status,
				'text_on'  => esc_html__( 'Yes', 'woodmart' ),
				'text_off' => esc_html__( 'No', 'woodmart' ),
			)
		);

		$new_html = ob_get_clean();

		wp_send_json(
			array(
				'new_html' => $new_html,
			)
		);
	}

	/**
	 * Save fields status ajax action.
	 *
	 * @return void
	 */
	public function save_fields_status() {
		check_ajax_referer( 'checkout_fields_manager_nonce', 'security' );

		$field_name     = woodmart_clean( $_POST['field_name'] ); // phpcs:ignore
		$status         = woodmart_clean( $_POST['status'] ); // phpcs:ignore
		$current_tab    = woodmart_clean( $_POST['current_tab'] ); // phpcs:ignore
		$default_fields = $this->helper->get_default_fields( $current_tab );
		$change_options = get_option( 'xts_checkout_fields_manager_options', array() );

		if ( array_key_exists( $field_name, $default_fields ) ) {
			if ( (bool) $status !== $default_fields[ $field_name ]['status'] ) {
				$change_options[ $current_tab ][ $field_name ]['status'] = (bool) $status;
			} elseif ( isset( $change_options[ $current_tab ][ $field_name ]['status'] ) ) {
				unset( $change_options[ $current_tab ][ $field_name ]['status'] );
			}

			$change_options = $this->recursive_unset_empty_array( $change_options );
		}

		update_option( 'xts_checkout_fields_manager_options', $change_options, false );

		ob_start();

		$this->helper->get_template(
			'status-button',
			array(
				'id'     => $field_name,
				'status' => $status,
			)
		);

		$new_html = ob_get_clean();

		wp_send_json(
			array(
				'new_html' => $new_html,
			)
		);
	}

	/**
	 * Save fields position ajax action.
	 *
	 * @return void
	 */
	public function save_fields_position() {
		check_ajax_referer( 'checkout_fields_manager_nonce', 'security' );

		$field_name     = woodmart_clean( $_POST['field_name'] ); // phpcs:ignore
		$position       = woodmart_clean( $_POST['position'] ); // phpcs:ignore
		$current_tab    = woodmart_clean( $_POST['current_tab'] ); // phpcs:ignore
		$default_fields = $this->helper->get_default_fields( $current_tab );
		$change_options = get_option( 'xts_checkout_fields_manager_options', array() );

		if ( array_key_exists( $field_name, $default_fields ) ) {
			$remove_classes    = array();
			$positions_classes = array(
				'form-row-first',
				'form-row-wide',
				'form-row-last',
			);

			foreach ( $positions_classes as $positions_class ) {
				if ( ! isset( $change_options[ $current_tab ][ $field_name ]['class'] ) ) {
					continue;
				}

				if ( in_array( $positions_class, $change_options[ $current_tab ][ $field_name ]['class'], true ) ) {
					$remove_classes[] = array_search( $positions_class, $change_options[ $current_tab ][ $field_name ]['class'], true );
				}
			}

			if ( ! empty( $remove_classes ) ) {
				foreach ( $remove_classes as $id ) {
					unset( $change_options[ $current_tab ][ $field_name ]['class'][ $id ] );
				}
			}

			if ( ! in_array( $position, $default_fields[ $field_name ]['class'], true ) ) {
				$change_options[ $current_tab ][ $field_name ]['class'][] = $position;
			}

			$change_options = $this->recursive_unset_empty_array( $change_options );
		}

		update_option( 'xts_checkout_fields_manager_options', $change_options, false );

		ob_start();

		$this->helper->get_template(
			'select',
			array(
				'id'      => $field_name,
				'label'   => esc_html__( 'Position', 'woodmart' ),
				'options' => array(
					'form-row-first' => esc_html__( 'Left', 'woodmart' ),
					'form-row-wide'  => esc_html__( 'Wide', 'woodmart' ),
					'form-row-last'  => esc_html__( 'Right', 'woodmart' ),
				),
				'current' => $position,
			)
		);

		$new_html = ob_get_clean();

		wp_send_json(
			array(
				'new_html' => $new_html,
			)
		);
	}
}

Ajax_Actions::get_instance();
