<?php
/**
 * This file describes class for render view all checkout detail fields.
 *
 * @package Woodmart.
 */

namespace XTS\Modules\Checkout_Fields\List_Table;

use WP_List_Table;
use XTS\Modules\Checkout_Fields\Helper;
use XTS\Modules\Checkout_Fields\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Fields_Table extends WP_List_Table {
	/**
	 * This table data.
	 *
	 * @var array|array[]
	 */
	public $table_data;

	/**
	 * Instance of the Helper class.
	 *
	 * @var Helper
	 */
	public $helper;

	/**
	 * Instance of the Admin class.
	 *
	 * @var Admin
	 */
	public $admin;

	/**
	 * Constructor.
	 *
	 * @param array|string $args Array or string of arguments.
	 */
	public function __construct( $args = array() ) {
		parent::__construct( $args );

		$this->helper = Helper::get_instance();
		$this->admin  = Admin::get_instance();
	}

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param array  $item        Data.
	 * @param string $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		if ( isset( $item[ $column_name ] ) ) {
			return apply_filters( 'woodmart_column_default', esc_html( $item[ $column_name ] ), $item, $column_name );
		} else {
			// Show the whole array for troubleshooting purposes.
			return apply_filters( 'woodmart_column_default', print_r( $item, true ), $item, $column_name ); // phpcs:ignore.
		}
	}

	/**
	 * Print sort column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_sort( $item ) {
		ob_start();
		?>

		<div class="xts-ui-sortable-handle"></div>

		<?php
		return ob_get_clean();
	}

	/**
	 * Print position column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_position( $item ) {
		$current = '';

		if ( ! empty( $item['class'] ) ) {
			if ( in_array( 'form-row-first', $item['class'], true ) ) {
				$current = 'form-row-first';
			} elseif ( in_array( 'form-row-wide', $item['class'], true ) ) {
				$current = 'form-row-wide';
			} elseif ( in_array( 'form-row-last', $item['class'], true ) ) {
				$current = 'form-row-last';
			}
		}

		if ( ! isset( $item['field_name'] ) ) {
			return '';
		}

		ob_start();

		$this->helper->get_template(
			'select',
			array(
				'id'      => $item['field_name'],
				'label'   => esc_html__( 'Position', 'woodmart' ),
				'options' => array(
					'form-row-first' => esc_html__( 'Left', 'woodmart' ),
					'form-row-wide'  => esc_html__( 'Wide', 'woodmart' ),
					'form-row-last'  => esc_html__( 'Right', 'woodmart' ),
				),
				'current' => $current,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Print required column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_required( $item ) {
		if ( ! isset( $item['field_name'] ) || ! isset( $item['required'] ) ) {
			return '';
		}

		ob_start();

		$this->helper->get_template(
			'status-button',
			array(
				'id'       => $item['field_name'],
				'status'   => $item['required'],
				'text_on'  => esc_html__( 'Yes', 'woodmart' ),
				'text_off' => esc_html__( 'No', 'woodmart' ),
			)
		);

		return ob_get_clean();
	}

	/**
	 * Print label column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_label( $item ) {
		return ! empty( $item['label'] ) ? esc_html( $item['label'] ) : '';
	}

	/**
	 * Print field_name column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_field_name( $item ) {
		return ! empty( $item['field_name'] ) ? esc_html( $item['field_name'] ) : '';
	}

	/**
	 * Print status column.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_status( $item ) {
		if ( ! isset( $item['field_name'] ) ) {
			return '';
		}

		ob_start();

		$this->helper->get_template(
			'status-button',
			array(
				'id'     => $item['field_name'],
				'status' => isset( $item['status'] ) ? $item['status'] : true,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'sort'       => esc_html__( 'Sort', 'woodmart' ),
			'field_name' => esc_html__( 'Name', 'woodmart' ),
			'label'      => esc_html__( 'Label', 'woodmart' ),
			'position'   => esc_html__( 'Position', 'woodmart' ),
			'required'   => esc_html__( 'Required', 'woodmart' ),
			'status'     => esc_html__( 'Status', 'woodmart' ),
		);
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$this->table_data = $this->table_data();
		usort( $this->table_data, array( $this, 'sort_data' ) );

		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = array();

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $this->table_data;
	}

	/**
	 * Get the table data.
	 *
	 * @return array
	 */
	public function table_data() {
		$current_tab             = $this->admin->get_current_tab();
		$change_options          = get_option( 'xts_checkout_fields_manager_options', array() );
		$updated_checkout_fields = $this->helper->recursive_parse_args( $change_options, $this->helper->get_default_fields() );

		return array_key_exists( $current_tab, $updated_checkout_fields ) ? $updated_checkout_fields[ $current_tab ] : array();
	}

	/**
	 * Sort the data by priority.
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		if ( ! isset( $a['priority'], $b['priority'] ) ) {
			return 0;
		}

		$a = $a['priority'];
		$b = $b['priority'];

		if ( $a === $b ) {
			return 0;
		}

		return ( $a < $b ) ? -1 : 1;
	}

	/**
	 * Print filters for current table
	 *
	 * @param string $which Top / Bottom.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	protected function extra_tablenav( $which ) {
		if ( 'bottom' !== $which ) {
			return;
		}

		?>
		<a href="<?php echo esc_attr( add_query_arg( 'reset-all-fields', true, $this->admin->get_base_url() ) ); ?>" class="xts-reset-all-fields xts-btn xts-color-primary">
			<?php esc_html_e( 'Reset all', 'woodmart' ); ?>
		</a>
		<?php
	}

	/**
	 * Override the parent method. Add custom css class to table.
	 *
	 * @return string[] Array of CSS classes for the table tag.
	 */
	protected function get_table_classes() {
		$css_classes   = parent::get_table_classes();
		$css_classes[] = 'xts-ui-sortable';

		return $css_classes;
	}

	/**
	 * Override the parent method. Add custom attributes to single row.
	 *
	 * @param object|array $item The current item.
	 */
	public function single_row( $item ) {
		?>
		<tr data-field-id="<?php echo esc_attr( $item['field_name'] ); ?>">
			<?php $this->single_row_columns( $item ); ?>
		</tr>
		<?php
	}
}
