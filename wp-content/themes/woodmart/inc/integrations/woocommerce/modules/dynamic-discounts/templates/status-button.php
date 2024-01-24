<?php
/**
 * Status button template for Dynamic discounts post type.
 *
 * @var string $status Discount rule status.
 * @var int $post_id Dynamic discounts post id.
 * @package Woodmart
 */

$classes = '';

if ( 'publish' === $status ) {
	$classes .= ' xts-active';
}
?>

<div class="xts-switcher-btn<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-status="<?php echo esc_attr( $status ); ?>">
	<div class="xts-switcher-dot-wrap">
		<div class="xts-switcher-dot"></div>
	</div>
	<div class="xts-switcher-labels">
		<span class="xts-switcher-label xts-on">
			<?php echo esc_html__( 'On', 'woodmart' ); ?>
		</span>

		<span class="xts-switcher-label xts-off">
			<?php echo esc_html__( 'Off', 'woodmart' ); ?>
		</span>
	</div>
</div>
