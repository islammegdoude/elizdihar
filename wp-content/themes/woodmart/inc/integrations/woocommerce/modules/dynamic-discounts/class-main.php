<?php
/**
 * Dynamic discounts class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Dynamic_Discounts;

use WC_Cart;
use XTS\Admin\Modules\Options;
use XTS\Singleton;

/**
 * Dynamic discounts class.
 */
class Main extends Singleton {
	/**
	 * Make sure that the same discount is not applied twice for the same product.
	 *
	 * @var array A list of product IDs for which a discount has already been applied.
	 */
	public $applied = array();

	/**
	 * Init.
	 */
	public function init() {
		$this->add_options();

		if ( ! woodmart_get_opt( 'discounts_enabled', 0 ) ) {
			return;
		}

		$this->include_files();

		add_action( 'woocommerce_before_calculate_totals', array( $this, 'calculate_discounts' ), 10, 1 );
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'discounts_enabled',
				'name'        => esc_html__( 'Enable "Dynamic discounts"', 'woodmart' ),
				'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'discounts-enabled.jpg" alt="">', 'woodmart' ), true ),
				'description' => esc_html__( 'You can configure your discounts in Dashboard -> Products -> Dynamic Discounts.', 'woodmart' ),
				'group'       => esc_html__( 'Dynamic discounts', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'shop_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 120,
			)
		);

		Options::add_field(
			array(
				'id'          => 'show_discounts_table',
				'name'        => esc_html__( 'Show discounts table', 'woodmart' ),
				'description' => esc_html__( 'Dynamic pricing table on the single product page.', 'woodmart' ),
				'group'       => esc_html__( 'Dynamic discounts', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'shop_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 130,
			)
		);
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$files = array(
			'class-manager',
			'class-admin',
			'class-frontend',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/dynamic-discounts/' . $file . '.php' );
		}
	}

	/**
	 * Calculate price with discounts.
	 *
	 * @param WC_Cart $cart WC_Cart class.
	 *
	 * @return void
	 */
	public function calculate_discounts( $cart ) {
		// @codeCoverageIgnoreStart
		// Woocommerce wpml compatibility. Make sure that the discount is calculated only once.
		if ( class_exists( 'woocommerce_wpml' ) && doing_action( 'woocommerce_cart_loaded_from_session' ) ) {
			return;
		}
		// @codeCoverageIgnoreEnd

		$variations_quantity = array();

		foreach ( $cart->get_cart() as $cart_item ) {
			if ( 'variation' !== $cart_item['data']->get_type() ) {
				continue;
			}

			if ( ! isset( $variations_quantity[ $cart_item['product_id'] ] ) ) {
				$variations_quantity[ $cart_item['product_id'] ] = 0;
			}

			$variations_quantity[ $cart_item['product_id'] ] += (int) $cart_item['quantity'];
		}

		foreach ( $cart->get_cart() as $cart_item ) {
			$product       = $cart_item['data'];
			$item_quantity = $cart_item['quantity'];
			$product_price = apply_filters( 'woodmart_pricing_before_calculate_discounts', (float) $product->get_price(), $cart_item );
			$discount      = Manager::get_instance()->get_discount_rules( $product );

			if ( empty( $product->get_price() ) || empty( $discount ) || ( ! empty( $this->applied ) && in_array( $product->get_id(), $this->applied, true ) ) ) {
				continue;
			}

			$product->set_regular_price( $product_price );

			if ( ! empty( $variations_quantity ) && 'individual_product' === $discount['discount_quantities'] && in_array( $product->parent_id, array_keys( $variations_quantity ), true ) ) {
				$item_quantity = $variations_quantity[ $product->parent_id ];
			}

			switch ( $discount['_woodmart_rule_type'] ) {
				case 'bulk':
					foreach ( $discount['discount_rules'] as $key => $discount_rule ) {
						if ( $discount_rule['_woodmart_discount_rules_from'] <= $item_quantity && ( $item_quantity <= $discount_rule['_woodmart_discount_rules_to'] || ( array_key_last( $discount['discount_rules'] ) === $key && empty( $discount_rule['_woodmart_discount_rules_to'] ) ) ) ) {
							$discount_type  = $discount_rule['_woodmart_discount_type'];
							$discount_value = $discount_rule[ '_woodmart_discount_' . $discount_type . '_value' ];

							// @codeCoverageIgnoreStart
							// WPML woocommerce-multilingual compatibility.
							if ( function_exists( 'woodmart_wpml_shipping_progress_bar_amount' ) && 'amount' === $discount_type ) {
								$discount_value = woodmart_wpml_shipping_progress_bar_amount( $discount_value );
							}
							// @codeCoverageIgnoreEnd

							$product_price = $this->get_product_price(
								$product_price,
								array(
									'type'  => $discount_type,
									'value' => $discount_value,
								)
							);
						}
					}
					break;
			}

			$product_price = apply_filters( 'woodmart_pricing_after_calculate_discounts', $product_price, $cart_item );

			if ( $product_price < 0 ) {
				$product_price = 0;
			}

			$product->set_price( $product_price );
			$product->set_sale_price( $product_price );

			$this->applied[] = $product->get_id();
		}
	}

	/**
	 * Get product price after applying discount.
	 *
	 * @param float $product_price Price before applying discount.
	 * @param array $discount Array with 2 args('type', 'value') for calculate new price.
	 *
	 * @return float
	 */
	public function get_product_price( $product_price, $discount ) {
		if ( empty( $discount['type'] ) || empty( $discount['value'] ) || empty( $product_price ) ) {
			return $product_price;
		}

		switch ( $discount['type'] ) {
			case 'amount':
				$product_price -= $discount['value'];
				break;
			case 'percentage':
				$product_price -= $product_price * ( $discount['value'] / 100 );
				break;
			default:
				break;
		}

		return (float) $product_price;
	}
}

Main::get_instance();
