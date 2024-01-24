<?php
/**
 * Checkout fields class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Checkout_Fields;

use XTS\Singleton;

/**
 * Checkout fields class.
 */
class Helper extends Singleton {
	/**
	 * Init.
	 */
	public function init() {}

	/**
	 * Get default fields list.
	 *
	 * @param string $current_tab Current tab.
	 *
	 * @return array
	 */
	public function get_default_fields( $current_tab = '' ) {
		$default_fields = WC()->checkout()->get_checkout_fields();
		$fields         = get_transient( 'wd_default_checkout_fields' );

		if ( empty( $fields ) ) {
			$fields = array();

			foreach ( $default_fields as $group_key => $checkout_groups_fields ) {
				$new_current_tab_fields = array();

				foreach ( $checkout_groups_fields as $key => $field ) {
					$field['field_name'] = $key;
					$field['status']     = true;
					$field['required']   = ! empty( $field['required'] ) ? $field['required'] : false;
					$field['priority']   = ! empty( $field['priority'] ) ? $field['priority'] : 10;

					$new_current_tab_fields[ $key ] = $field;
				}

				$fields[ $group_key ] = $new_current_tab_fields;
			}

			set_transient( 'wd_default_checkout_fields', $fields );
		}

		if ( ! empty( $current_tab ) && array_key_exists( $current_tab, $fields ) && ! empty( $fields[ $current_tab ] ) ) {
			return $fields[ $current_tab ];
		}

		return $fields;
	}

	/**
	 * Arrays merge recursive.
	 *
	 * @param array $new_array New options list.
	 * @param array $defaults Default options list.
	 *
	 * @return array
	 */
	public function recursive_parse_args( $new_array, $defaults ) {
		$new_args = (array) $defaults;

		foreach ( $new_array as $key => $value ) {
			if ( is_array( $value ) && isset( $new_args[ $key ] ) ) {
				$new_args[ $key ] = $this->recursive_parse_args( $value, $new_args[ $key ] );
			} else {
				$new_args[ $key ] = $value;
			}
		}

		return $new_args;
	}

	/**
	 * Get template.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments for template.
	 *
	 * @return void
	 */
	public function get_template( $template_name, $args = array() ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/checkout-fields/templates/' . $template_name . '.php';
	}
}
