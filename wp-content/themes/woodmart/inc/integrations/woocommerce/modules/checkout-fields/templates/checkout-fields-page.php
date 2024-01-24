<?php
/**
 * Checkout fields page template.
 *
 * @var string $base_url Base url.
 * @var array $tabs List of tabs.
 * @var string $current_tab Current tab id.
 * @var object|null $list_table An instance of a class that extends WP_List_Table.
 *
 * @package Woodmart
 */

?>

<div class="wrap">
	<div class="nav-tab-wrapper">
		<?php foreach ( $tabs as $key => $label ) : ?>
			<a class="nav-tab<?php echo $current_tab === $key ? esc_attr( ' nav-tab-active' ) : ''; ?>" href="<?php echo esc_attr( add_query_arg( 'tab', $key, $base_url ) ); ?>">
				<?php echo esc_html( $label ); ?>
			</a>
		<?php endforeach; ?>
	</div>

	<div class="table-wrapper">
		<?php $list_table->display(); ?>
	</div>
</div>
