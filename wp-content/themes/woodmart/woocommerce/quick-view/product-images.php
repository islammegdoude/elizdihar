<?php
/**
 * Single Product Images
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$is_quick_view = woodmart_loop_prop( 'is_quick_view' );

$attachment_ids = $product->get_gallery_image_ids();

$attachment_count = count( $attachment_ids );

woodmart_enqueue_inline_style( 'page-single-product' );
woodmart_enqueue_inline_style( 'swiper' );

?>
<div class="wd-carousel-container wd-gallery-images">
	<div class="wd-carousel-inner">
		<div class="woocommerce-product-gallery__wrapper quick-view-gallery wd-carousel wd-grid">
			<?php
				$attributes = array(
					'title' => esc_attr( get_the_title( get_post_thumbnail_id() ) ),
				);

				if ( has_post_thumbnail() ) {
					echo '<div class="wd-carousel-wrap">';
					echo '<div class="wd-carousel-item"><figure class="woocommerce-product-gallery__image">' . get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' ), $attributes ) . '</figure></div>';

					if ( $attachment_count > 0 ) {
						foreach ( $attachment_ids as $attachment_id ) {
							echo '<div class="wd-carousel-item"><figure class="woocommerce-product-gallery__image">' . wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' ), false, array( 'class' => apply_filters( 'woodmart_single_product_gallery_image_class', 'wp-post-image' ) ) ) . '</figure></div>';
						}
					}
					echo '</div>';
				} else {
					echo '<figure class="woocommerce-product-gallery__image--placeholder">' . apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woodmart' ) ), $post->ID ) . '</figure>';
				}
				?>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn view-details-btn">
					<?php esc_html_e( 'View details', 'woodmart' ); ?>
				</a>
		</div>

		<?php woodmart_get_carousel_nav_template( ' wd-pos-sep wd-hover-1 wd-custom-style' ); ?>
	</div>
</div>
