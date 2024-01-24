<?php
/**
 * Select template.
 *
 * @var string $id Field id.
 * @var string $label Field label.
 * @var array $options Options list.
 * @var string $current Selected option id.
 *
 * @package Woodmart
 */

if ( empty( $options ) ) {
	return '';
}

?>

<select data-id="<?php echo esc_attr( $id ); ?>" aria-label="<?php echo esc_attr( $label ); ?>">
	<?php foreach ( $options as $option_id => $option_value ) : ?>
		<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $current, $option_id ); ?>>
			<?php echo esc_html( $option_value ); ?>
		</option>
	<?php endforeach; ?>
</select>
