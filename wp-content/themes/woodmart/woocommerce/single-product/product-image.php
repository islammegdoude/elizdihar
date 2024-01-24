<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

$thumbs_position             = woodmart_get_opt( 'thums_position' );
$image_action                = woodmart_get_opt( 'image_action' );
$is_quick_view               = woodmart_loop_prop( 'is_quick_view' );
$product_design              = woodmart_product_design();
$attachment_ids              = $product->get_gallery_image_ids();
$post_thumbnail_id           = $product->get_image_id();
$placeholder                 = $post_thumbnail_id ? 'with-images' : 'without-images';
$thumb_image_size            = 'woocommerce_single';
$thumbnails_settings         = woodmart_get_product_gallery_settings();
$thumbnails_vertical_columns = ! empty( $thumbnails_settings['thumbs_slider']['items']['vertical_items'] ) ? $thumbnails_settings['thumbs_slider']['items']['vertical_items'] : 3;
$thumbnails_columns_desktop  = ! empty( $thumbnails_settings['thumbs_slider']['items']['desktop'] ) ? $thumbnails_settings['thumbs_slider']['items']['desktop'] : 4;
$thumbnails_columns_tablet   = ! empty( $thumbnails_settings['thumbs_slider']['items']['tablet'] ) ? $thumbnails_settings['thumbs_slider']['items']['tablet'] : 4;
$thumbnails_columns_mobile   = ! empty( $thumbnails_settings['thumbs_slider']['items']['mobile'] ) ? $thumbnails_settings['thumbs_slider']['items']['mobile'] : 3;
$gallery_columns_desktop     = woodmart_get_opt( 'single_product_gallery_column_desktop', 1 );
$gallery_columns_tablet      = woodmart_get_opt( 'single_product_gallery_column_tablet', 1 );
$gallery_columns_mobile      = woodmart_get_opt( 'single_product_gallery_column_mobile', 1 );
$grid_columns_desktop        = woodmart_get_opt( 'single_product_grid_column_desktop', 1 );
$grid_columns_tablet         = woodmart_get_opt( 'single_product_grid_column_tablet', 1 );
$grid_columns_mobile         = woodmart_get_opt( 'single_product_grid_column_mobile', 1 );
$pagination_controls         = woodmart_get_opt( 'pagination_main_gallery' );
$carousel_on_tablet          = woodmart_get_opt( 'main_gallery_on_tablet', true );
$carousel_on_mobile          = woodmart_get_opt( 'main_gallery_on_mobile', true );
$gallery_center_mode         = 'without' === $thumbs_position && woodmart_get_opt( 'main_gallery_center_mode' );
$thumbnails_wrap_in_mobile   = woodmart_get_opt( 'single_product_thumbnails_wrap_in_mobile_devices', true );
$main_gallery_attrs          = array();
$style_attrs                 = '';

// Builder settings.
if ( isset( $args['builder_thumbnails_position'] ) && 'inherit' !== $args['builder_thumbnails_position'] ) {
	$thumbs_position = $args['builder_thumbnails_position'];

	if ( 'left' === $thumbs_position && ! empty( $args['builder_thumbnails_vertical_columns'] ) && 'inherit' !== $args['builder_thumbnails_vertical_columns'] ) {
		$thumbnails_vertical_columns = $args['builder_thumbnails_vertical_columns'];
	}

	if ( 'bottom' === $thumbs_position && ! empty( $args['builder_thumbnails_columns_desktop'] ) && 'inherit' !== $args['builder_thumbnails_columns_desktop'] ) {
		$thumbnails_columns_desktop = $args['builder_thumbnails_columns_desktop'];
	}

	if ( ! empty( $args['builder_thumbnails_columns_tablet'] ) && 'inherit' !== $args['builder_thumbnails_columns_tablet'] ) {
		$thumbnails_columns_tablet = $args['builder_thumbnails_columns_tablet'];
	}
	if ( ! empty( $args['builder_thumbnails_columns_mobile'] ) && 'inherit' !== $args['builder_thumbnails_columns_mobile'] ) {
		$thumbnails_columns_mobile = $args['builder_thumbnails_columns_mobile'];
	}

	if ( ! empty( $args['grid_columns'] ) && 'inherit' !== $args['grid_columns'] ) {
		$grid_columns_desktop = $args['grid_columns'];
	}

	if ( ! empty( $args['grid_columns_tablet'] ) && 'inherit' !== $args['grid_columns_tablet'] ) {
		$grid_columns_tablet = $args['grid_columns_tablet'];
	}

	if ( ! empty( $args['grid_columns_mobile'] ) && 'inherit' !== $args['grid_columns_mobile'] ) {
		$grid_columns_mobile = $args['grid_columns_mobile'];
	}

	if ( 'without' === $thumbs_position ) {
		if ( ! empty( $args['gallery_columns_desktop'] ) && 'inherit' !== $args['gallery_columns_desktop'] ) {
			$gallery_columns_desktop = $args['gallery_columns_desktop'];
		}
		if ( ! empty( $args['gallery_columns_tablet'] ) && 'inherit' !== $args['gallery_columns_desktop'] ) {
			$gallery_columns_tablet = $args['gallery_columns_tablet'];
		}
		if ( ! empty( $args['gallery_columns_mobile'] ) && 'inherit' !== $args['gallery_columns_desktop'] ) {
			$gallery_columns_mobile = $args['gallery_columns_mobile'];
		}

		if ( ! empty( $args['main_gallery_center_mode'] ) && 'inherit' !== $args['main_gallery_center_mode'] ) {
			$gallery_center_mode = 'enable' === $args['main_gallery_center_mode'];
		}
	}

	if ( ! empty( $args['carousel_on_tablet'] ) && 'inherit' !== $args['carousel_on_tablet'] ) {
		$carousel_on_tablet = 'enable' === $args['carousel_on_tablet'];
	}

	if ( ! empty( $args['carousel_on_mobile'] ) && 'inherit' !== $args['carousel_on_mobile'] ) {
		$carousel_on_mobile = 'enable' === $args['carousel_on_mobile'];
	}

	if ( ! empty( $args['pagination_main_gallery'] ) && 'inherit' !== $args['pagination_main_gallery'] ) {
		$pagination_controls = 'enable' === $args['pagination_main_gallery'];
	}

	if ( ! empty( $args['thumbnails_wrap_in_mobile_devices'] ) && 'inherit' !== $args['thumbnails_wrap_in_mobile_devices'] ) {
		$thumbnails_wrap_in_mobile = 'on' === $args['thumbnails_wrap_in_mobile_devices'];
	}
}

$columns              = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size       = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$full_size_image      = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$wrapper_classes      = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
		$attachment_ids ? 'wd-has-thumb' : '',
	)
);
$main_gallery_classes = 'wd-carousel-container wd-gallery-images';
$gallery_classes      = ' wd-carousel wd-grid';

if ( 'without' === $thumbs_position && $gallery_center_mode || 'centered' === $thumbs_position ) {
	$main_gallery_attrs[] = 'data-center_mode="yes"';
}

if ( in_array( $thumbs_position, array( 'carousel_two_columns', 'centered' ), true ) ) {
	$gallery_columns_desktop = 2;
	$gallery_columns_tablet  = 2;
	$gallery_columns_mobile  = 2;

	$thumbs_position = 'without';
} elseif ( in_array( $thumbs_position, array( 'left', 'bottom' ), true ) ) {
	$gallery_columns_desktop = 1;
	$gallery_columns_tablet  = 1;
	$gallery_columns_mobile  = 1;
}

if ( in_array( $thumbs_position, array( 'without', 'left', 'bottom' ), true ) ) {
	$wrapper_classes[] = 'thumbs-position-' . $thumbs_position;

	if ( ! $gallery_columns_desktop ) {
		$gallery_columns_desktop = 1;
	}
	if ( ! $gallery_columns_tablet ) {
		$gallery_columns_tablet = 1;
	}
	if ( ! $gallery_columns_mobile ) {
		$gallery_columns_mobile = 1;
	}

	$style_attrs .= '--wd-col-lg:' . $gallery_columns_desktop . ';';
	$style_attrs .= '--wd-col-md:' . $gallery_columns_tablet . ';';
	$style_attrs .= '--wd-col-sm:' . $gallery_columns_mobile . ';';
} elseif ( in_array( $thumbs_position, array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ), true ) ) {
	$wrapper_classes[]     = 'thumbs-grid-' . $thumbs_position;
	$main_gallery_classes .= ' wd-off-lg';

	if ( ! $grid_columns_desktop ) {
		$grid_columns_desktop = 1;
	}
	if ( ! $grid_columns_tablet ) {
		$grid_columns_tablet = 1;
	}
	if ( ! $grid_columns_mobile ) {
		$grid_columns_mobile = 1;
	}

	if ( in_array( $thumbs_position, array( 'bottom_column', 'bottom_grid' ), true ) ) {
		$style_attrs .= '--wd-col-lg:' . $grid_columns_desktop . ';';
	} else {
		$grid_columns_tablet = 1;
		$grid_columns_mobile = 1;
	}

	$style_attrs .= '--wd-col-md:' . $grid_columns_tablet . ';';
	$style_attrs .= '--wd-col-sm:' . $grid_columns_mobile . ';';

	if ( ! $carousel_on_mobile ) {
		$main_gallery_classes .= ' wd-off-sm';
	}

	if ( ! $carousel_on_tablet ) {
		$main_gallery_classes .= ' wd-off-md';
	}
}

if ( woodmart_get_opt( 'product_slider_auto_height' ) ) {
	$main_gallery_attrs[] = 'data-autoheight="yes"';
}

if ( $style_attrs ) {
	$main_gallery_attrs[] = 'style="' . $style_attrs . '"';
}

if ( 'popup' === $image_action ) {
	woodmart_enqueue_js_library( 'photoswipe-bundle' );
	woodmart_enqueue_inline_style( 'photoswipe' );
	woodmart_enqueue_js_script( 'product-images' );
}

if ( 'zoom' === $image_action ) {
	woodmart_enqueue_js_script( 'init-zoom' );
}

woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery' );

if ( 'left' === $thumbs_position ) {
	if ( $thumbnails_wrap_in_mobile ) {
		$wrapper_classes[] = ' wd-thumbs-wrap';

		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-left-desktop', true );
	} else {
		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-left', true );
	}
}

if ( 'left' !== $thumbs_position && 'bottom' !== $thumbs_position && 'without' !== $thumbs_position ) {
	if ( $carousel_on_tablet && $carousel_on_mobile ) {
		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-grid-lg', true );
	} elseif ( $carousel_on_tablet ) {
		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-grid-sm', true );
	} elseif ( $carousel_on_mobile ) {
		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-grid-md', true );
	} else {
		woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-grid', true );
	}
}

woodmart_enqueue_js_library( 'swiper' );
woodmart_enqueue_js_script( 'swiper-carousel' );
woodmart_enqueue_js_script( 'product-images-gallery' );
woodmart_enqueue_inline_style( 'swiper' );
wp_enqueue_script( 'imagesloaded' );

?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> images image-action-<?php echo esc_attr( $image_action ); ?>">
	<div class="<?php echo esc_attr( $main_gallery_classes ); ?>">
		<div class="wd-carousel-inner">

		<?php do_action( 'woodmart_before_single_product_main_gallery' ); ?>

		<figure class="woocommerce-product-gallery__wrapper<?php echo esc_attr( $gallery_classes ); ?>" <?php echo wp_kses( implode( ' ', $main_gallery_attrs ), true ); ?>>
			<div class="wd-carousel-wrap">

			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
				'data-large_image'        => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
				'data-large_image_width'  => isset( $full_size_image[1] ) ? $full_size_image[1] : '',
				'data-large_image_height' => isset( $full_size_image[2] ) ? $full_size_image[2] : '',
				'class'                   => apply_filters( 'woodmart_single_product_gallery_image_class', 'wp-post-image' ),
			);

			if ( $product->get_image_id() ) {
				$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
				$thumbnail_size    = apply_filters(
					'woocommerce_gallery_thumbnail_size',
					array(
						$gallery_thumbnail['width'],
						$gallery_thumbnail['height'],
					)
				);

				$thumbnail_src = get_the_post_thumbnail_url( $post->ID, $thumbnail_size );
				$html          = '<div class="wd-carousel-item"><figure data-thumb="' . $thumbnail_src . '" class="woocommerce-product-gallery__image"><a data-elementor-open-lightbox="no" href="' . esc_url( $full_size_image[0] ) . '">';
				$html         .= get_the_post_thumbnail( $post->ID, $thumb_image_size, $attributes );
				$html         .= '</a></figure></div>';
			} else {
				$html = '<div class="wd-carousel-item"><figure data-thumb="' . esc_url( wc_placeholder_img_src( $thumb_image_size ) ) . '" class="woocommerce-product-gallery__image--placeholder"><a data-elementor-open-lightbox="no" href="' . esc_url( wc_placeholder_img_src( $thumb_image_size ) ) . '">';

				$html .= sprintf( '<img src="%s" alt="%s" data-src="%s" data-large_image="%s" data-large_image_width="700" data-large_image_height="800" class="attachment-woocommerce_single size-woocommerce_single wp-post-image" />', esc_url( wc_placeholder_img_src( $thumb_image_size ) ), esc_html__( 'Awaiting product image', 'woocommerce' ), esc_url( wc_placeholder_img_src( $thumb_image_size ) ), esc_url( wc_placeholder_img_src( $thumb_image_size ) ) );

				$html .= '</a></figure></div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ) // phpcs:ignore;
			?>

			<?php do_action( 'woocommerce_product_thumbnails' ); ?>
		</figure>

			<?php woodmart_get_carousel_nav_template( ' wd-pos-sep wd-hover-1 wd-custom-style' ); ?>

		<?php do_action( 'woodmart_on_product_image' ); ?>

		</div>

		<?php if ( $pagination_controls ) : ?>
			<?php woodmart_get_carousel_pagination_template( array(), ' wd-style-shape wd-custom-style' ); ?>
		<?php endif; ?>
	</div>

	<?php if ( 'sticky' !== $product_design && ( 'bottom' === $thumbs_position || 'left' === $thumbs_position ) ) : ?>
		<?php
		$thumbs_classes    = '';
		$attributes        = array();
		$style_attrs       = '';
		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$image_size        = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );

		if ( $attachment_ids && $post_thumbnail_id ) {
			array_unshift( $attachment_ids, $post_thumbnail_id );
		}

		if ( woodmart_get_opt( 'single_product_thumbnails_gallery_image_width' ) ) {
			$image_size = array( woodmart_get_opt( 'single_product_thumbnails_gallery_image_width' ), 0 );
		}

		if ( 'left' === $thumbs_position ) {
			if ( 'default' === $thumbnails_vertical_columns ) {
				$thumbnails_vertical_columns = 3;
			}

			$thumbnails_columns_desktop = $thumbnails_vertical_columns;
		}

		$style_attrs .= '--wd-col-lg:' . $thumbnails_columns_desktop . ';';
		$style_attrs .= '--wd-col-md:' . $thumbnails_columns_tablet . ';';
		$style_attrs .= '--wd-col-sm:' . $thumbnails_columns_mobile . ';';

		$attributes[] = 'style="' . $style_attrs . '"';

		$thumb_classes  = ' wd-thumb-nav wd-custom-style';
		$thumb_classes .= ' wd-pos-sep';

		?>
		<div class="wd-carousel-container wd-gallery-thumb">
			<div class="wd-carousel-inner">
				<div class="wd-carousel wd-grid<?php echo esc_attr( $thumbs_classes ); ?>" <?php echo wp_kses( implode( ' ', $attributes ), true ); ?>>
					<div class="wd-carousel-wrap">
						<?php if ( $attachment_ids ) : ?>
							<?php foreach ( $attachment_ids as $attachment_id ) : ?>
								<div class="wd-carousel-item <?php echo esc_attr( apply_filters( 'woodmart_single_product_thumbnail_classes', '', $attachment_id ) ); ?>">
									<?php echo wp_get_attachment_image( $attachment_id, $image_size ); ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<?php woodmart_get_carousel_nav_template( $thumb_classes ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
