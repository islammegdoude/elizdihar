<?php
/**
 * Render dynamic discounts on frontend.
 *
 * @package woodmart
 */

namespace XTS\Modules\Dynamic_Discounts;

use WC_Product;
use XTS\Modules\Layouts\Main as Layouts;
use XTS\Modules\Unit_Of_Measure\Main as Unit_Of_Measure;
use XTS\Singleton;

/**
 * Dynamic discounts class.
 */
class Frontend extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_filter( 'woocommerce_cart_item_price', array( $this, 'cart_item_price' ), 10, 2 );
		add_filter( 'woocommerce_before_mini_cart_contents', array( $this, 'cart_item_price_on_ajax' ), 10, 2 );

		if ( woodmart_get_opt( 'show_discounts_table', 0 ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'render_dynamic_discounts_table' ), 25 );

			add_action( 'wp_ajax_woodmart_update_discount_dynamic_discounts_table', array( $this, 'update_dynamic_discounts_table' ) );
			add_action( 'wp_ajax_nopriv_woodmart_update_discount_dynamic_discounts_table', array( $this, 'update_dynamic_discounts_table' ) );
		}
	}

	/**
	 * Update price in mini cart on get_refreshed_fragments action.
	 *
	 * @codeCoverageIgnore
	 * @return void
	 */
	public function cart_item_price_on_ajax() {
		if ( defined( 'WOOCS_VERSION' ) ) {
			return;
		}

		if ( wp_doing_ajax() && ! empty( $_GET['wc-ajax'] ) && 'get_refreshed_fragments' === $_GET['wc-ajax'] ) { // phpcs:ignore.
			WC()->cart->calculate_totals();
			WC()->cart->set_session();
			WC()->cart->maybe_set_cart_cookies();
		}
	}

	/**
	 * Update price in cart.
	 *
	 * @param string $price_html Product price.
	 * @param array  $cart_item Product data.
	 * @return string
	 */
	public function cart_item_price( $price_html, $cart_item ) {
		$product       = $cart_item['data'];
		$regular_price = $product->get_regular_price();
		$sale_price    = $product->get_price();

		if ( $regular_price === $sale_price ) {
			return $price_html;
		}

		if ( wc_tax_enabled() ) {
			if ( 'incl' === get_option( 'woocommerce_tax_display_cart' ) ) {
				$sale_price = wc_get_price_including_tax( $product, array( 'price' => $sale_price ) );
			} else {
				$sale_price = wc_get_price_excluding_tax( $product, array( 'price' => $sale_price ) );
			}
		}

		$unit_of_measure = Unit_Of_Measure::get_instance()->get_unit_of_measure_db( $product );

		ob_start();
		?>
			<?php echo wc_price( $sale_price ); // phpcs:ignore. ?>

			<?php if ( ! empty( $unit_of_measure ) ) : ?>
				<span class="wd-price-unit">
					 <?php echo $unit_of_measure; //phpcs:ignore. ?>
				</span>
			<?php endif; ?>
		<?php

		return ob_get_clean();
	}

	/**
	 * Render dynamic discounts table.
	 *
	 * @codeCoverageIgnore
	 * @param false|int|string $product_id The product id for which you want to generate the dynamic discounts table. Default is equal false.
	 * @param string           $wrapper_classes Wrapper classes string.
	 * @return false|string
	 */
	public function render_dynamic_discounts_table( $product_id = false, $wrapper_classes = '' ) {
		if ( ! $product_id ) {
			$product_id = is_ajax() && ! empty( wp_unslash( $_GET['variation_id'] ) ) ? wp_unslash( $_GET['variation_id'] ) : false; // phpcs:ignore.
		}

		$product = wc_get_product( $product_id );

		if ( ! $product || empty( $product->get_price() ) ) {
			return false;
		}

		$product_type = $product->get_type();
		$discount     = Manager::get_instance()->get_discount_rules( $product );
		$data         = array();

		if ( ! Manager::get_instance()->check_discount_exist( $product ) || ( ! Layouts::is_layout_type( 'single_product' ) && ! is_product() && ! is_ajax() ) || in_array( $product_type, array( 'grouped', 'external' ), true ) || 'bulk' !== $discount['_woodmart_rule_type'] ) {
			return false;
		}

		// Add last rule for render table.
		$last_rules = end( $discount['discount_rules'] );

		if ( ! empty( $last_rules['_woodmart_discount_rules_to'] ) ) {
			$discount['discount_rules']['last'] = array(
				'_woodmart_discount_rules_from'       => $last_rules['_woodmart_discount_rules_to'] + 1,
				'_woodmart_discount_rules_to'         => '',
				'_woodmart_discount_type'             => 'amount',
				'_woodmart_discount_amount_value'     => 0,
				'_woodmart_discount_percentage_value' => '',
			);
		}

		foreach ( $discount['discount_rules'] as $id => $rules ) {
			// Quantity min.
			$data[ $id ]['min'] = $rules['_woodmart_discount_rules_from'];

			// Quantity max.
			$data[ $id ]['max'] = $rules['_woodmart_discount_rules_to'];

			// Quantity column.
			if ( $rules['_woodmart_discount_rules_from'] === $rules['_woodmart_discount_rules_to'] ) {
				$data[ $id ]['quantity'] = $rules['_woodmart_discount_rules_from'];
			} else {
				$data[ $id ]['quantity'] = sprintf(
					'%s%s%s',
					$rules['_woodmart_discount_rules_from'],
					array_key_last( $discount['discount_rules'] ) !== $id ? '-' : '',
					! empty( $rules['_woodmart_discount_rules_to'] ) ? $rules['_woodmart_discount_rules_to'] : '+'
				);
			}

			// Discount column.
			$data[ $id ]['discount'] = sprintf(
				'%s%s',
				'amount' === $rules['_woodmart_discount_type'] ? apply_filters( 'woodmart_pricing_amount_discounts_value', $rules['_woodmart_discount_amount_value'] ) : $rules['_woodmart_discount_percentage_value'],
				'amount' === $rules['_woodmart_discount_type'] ? get_woocommerce_currency_symbol() : '%'
			);

			// Price column.
			$product_price = Main::get_instance()->get_product_price(
				$product->get_price(),
				array(
					'type'  => $rules['_woodmart_discount_type'],
					'value' => 'amount' === $rules['_woodmart_discount_type'] ? apply_filters( 'woodmart_pricing_amount_discounts_value', $rules['_woodmart_discount_amount_value'] ) : $rules['_woodmart_discount_percentage_value'],
				)
			);

			if ( wc_tax_enabled() ) {
				if ( 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
					$product_price = wc_get_price_including_tax( $product, array( 'price' => $product_price ) );
				} else {
					$product_price = wc_get_price_excluding_tax( $product, array( 'price' => $product_price ) );
				}
			}

			if ( $product_price < 0 ) {
				$product_price = 0;
			}

			$data[ $id ]['price'] = wc_price( $product_price );

			$data[ $id ]['unit_of_measure'] = Unit_Of_Measure::get_instance()->get_unit_of_measure_db( $product );
		}

		if ( empty( $data ) ) {
			return false;
		}

		if ( is_ajax() ) {
			ob_start();
		}

		woodmart_enqueue_inline_style( 'woo-opt-dynamic-discounts' );
		woodmart_enqueue_js_script( 'dynamic-discounts-table' );
		?>
		<?php if ( ! is_ajax() || ( Layouts::is_layout_type( 'single_product' ) && ( ! isset( $_REQUEST['action'] ) || 'woodmart_update_discount_dynamic_discounts_table' !== $_REQUEST['action'] ) ) ) : ?>
			<div class="wd-dynamic-discounts <?php echo esc_attr( $wrapper_classes ); ?>">
		<?php endif; ?>

		<?php
			wc_get_template(
				'single-product/price-table.php',
				array(
					'data' => $data,
				)
			);
		?>

		<div class="wd-loader-overlay wd-fill"></div>

		<?php if ( ! is_ajax() ) : ?>
			</div>
		<?php endif; ?>
		<?php
		if ( is_ajax() ) {
			return ob_get_clean();
		}
	}

	/**
	 * Send new price table html for current variation product.
	 *
	 * @codeCoverageIgnore
	 * @return void
	 */
	public function update_dynamic_discounts_table() {
		$variation_id = wp_unslash( $_GET['variation_id'] ); // phpcs:ignore.

		if ( empty( $variation_id ) ) {
			return;
		}

		if ( ! wc_get_product( $variation_id ) instanceof WC_Product ) {
			return;
		}

		wp_send_json(
			apply_filters( 'woodmart_variation_dynamic_discounts_table', $this->render_dynamic_discounts_table( $variation_id ) )
		);
	}
}

Frontend::get_instance();
