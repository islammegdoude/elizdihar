<?php
/**
 * Checkout admin page class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Checkout_Fields;

use XTS\Modules\Checkout_Fields\List_Table\Fields_Table;
use XTS\Singleton;

/**
 * Checkout admin page class.
 */
class Admin extends Singleton {
	/**
	 * Instance of the Helper class.
	 *
	 * @var Helper
	 */
	public $helper;

	/**
	 * List of registered tabs.
	 *
	 * @var array
	 */
	public $tabs;

	/**
	 * Init.
	 */
	public function init() {
		$this->helper = Helper::get_instance();
		$this->tabs   = array(
			'billing'  => esc_html__( 'Billing details', 'woodmart' ),
			'shipping' => esc_html__( 'Shipping details', 'woodmart' ),
		);

		add_action( 'init', array( $this, 'reset_all_fields' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Add submenu page in admin Woocommerce tab.
	 *
	 * @return void
	 */
	public function add_admin_page() {
		if ( ! woodmart_get_opt( 'checkout_fields_enabled' ) || ! woodmart_woocommerce_installed() ) {
			return;
		}

		add_submenu_page(
			'woocommerce',
			esc_html__( 'Checkout Fields', 'woodmart' ),
			esc_html__( 'Checkout Fields', 'woodmart' ),
			'manage_woocommerce',
			'xts-checkout-fields-page',
			array( $this, 'render_checkout_fields_page' )
		);
	}

	/**
	 * Render 'checkout fields' page in admin Woocommerce tab.
	 *
	 * @return void
	 */
	public function render_checkout_fields_page() {
		$list_table = new Fields_Table();

		$list_table->prepare_items();
		?>
		<?php
			$this->helper->get_template(
				'checkout-fields-page',
				array(
					'base_url'    => $this->get_base_url(),
					'tabs'        => $this->tabs,
					'current_tab' => $this->get_current_tab(),
					'list_table'  => $list_table,
				)
			);
		?>
		<?php
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( ! isset( $_GET['page'] ) || 'xts-checkout-fields-page' !== $_GET['page'] ) { // phpcs:ignore
			return;
		}

		wp_enqueue_style( 'wd-page-checkout-fields-manager', WOODMART_ASSETS . '/css/parts/page-checkout-fields-manager.min.css', array(), WOODMART_VERSION );

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'xts-checkout-fields-manager', WOODMART_ASSETS . '/js/checkoutFieldsManager.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * Reset checkout fields settings to default.
	 *
	 * @return void
	 */
	public function reset_all_fields() {
		if ( ! isset( $_GET['page'] ) || ! isset( $_GET['reset-all-fields'] ) || 'xts-checkout-fields-page' !== $_GET['page'] || empty( $this->tabs ) ) { // phpcs:ignore
			return;
		}

		delete_option( 'xts_checkout_fields_manager_options' );
		delete_transient( 'wd_default_checkout_fields' );

		wp_safe_redirect( $this->get_base_url() );
		exit();
	}

	/**
	 * Get current tab.
	 *
	 * @return string
	 */
	public function get_current_tab() {
		return ! empty( $_GET['tab'] ) && in_array( $_GET['tab'], array_keys( $this->tabs ), true ) ? $_GET['tab'] : 'billing'; // phpcs:ignore.
	}

	/**
	 * Get base url.
	 *
	 * @return string
	 */
	public function get_base_url() {
		return add_query_arg(
			array(
				'page' => 'xts-checkout-fields-page',
			),
			admin_url( 'admin.php' )
		);
	}
}

Admin::get_instance();
