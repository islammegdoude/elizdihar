<?php
/**
 * Status button template.
 *
 * @var bool $status Field status.
 * @var string $id Field id.
 * @var string $text_on The text that will be displayed when the button is on.
 * @var string $text_off The text that will be displayed when the button is off.
 * @package Woodmart
 */

$classes = '';

if ( $status ) {
	$classes .= ' xts-active';
}
?>

<div class="xts-switcher-btn<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-status="<?php echo esc_attr( $status ); ?>">
	<div class="xts-switcher-dot-wrap">
		<div class="xts-switcher-dot"></div>
	</div>
	<div class="xts-switcher-labels">
		<span class="xts-switcher-label xts-on">
			<?php echo ! empty( $text_on ) ? esc_html( $text_on ) : esc_html__( 'On', 'woodmart' ); ?>
		</span>

		<span class="xts-switcher-label xts-off">
			<?php echo ! empty( $text_off ) ? esc_html( $text_off ) : esc_html__( 'Off', 'woodmart' ); ?>
		</span>
	</div>
</div>
