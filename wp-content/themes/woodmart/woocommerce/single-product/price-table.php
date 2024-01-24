<?php
/**
 * Volume discounts table.
 *
 * @var array $data Data for render table.
 *
 * @package Woodmart
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action( 'woodmart_before_dynamic_discounts_table' ); ?>

<table>
	<thead>
		<tr>
			<th scope="col">
				<?php echo esc_html__( 'Quantity', 'woodmart' ); ?>
			</th>
			<th scope="col">
				<?php echo esc_html__( 'Price', 'woodmart' ); ?>
			</th>
			<th scope="col">
				<?php echo esc_html__( 'Discount', 'woodmart' ); ?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ( $data as $id => $row ) : ?>
		<tr data-min="<?php echo esc_attr( $row['min'] ); ?>" data-max="<?php echo esc_attr( $row['max'] ); ?>">
			<td>
				<span>
					<?php echo esc_html( $row['quantity'] ); ?>
				</span>
			</td>
			<td>
				<?php echo $row['price']; //phpcs:ignore. ?>

				<?php if ( ! empty( $row['unit_of_measure'] ) ) : ?>
					<span class="wd-price-unit">
						 <?php echo $row['unit_of_measure']; //phpcs:ignore. ?>
					</span>
				<?php endif; ?>
			</td>
			<td>
				<span>
					<?php echo esc_html( $row['discount'] ); ?>
				</span>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php do_action( 'woodmart_after_dynamic_discounts_table' ); ?>
