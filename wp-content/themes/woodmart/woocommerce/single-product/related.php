<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) {
	$product_ids = array();

	foreach ( $related_products as $related_product ) {
		$product_ids[] = $related_product->get_id();
	}

	$products_atts = array(
		'element_title'                => apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) ),
		'layout'                       => 'slider' === woodmart_get_opt( 'related_product_view' ) ? 'carousel' : 'grid',
		'post_type'                    => 'ids',
		'include'                      => $product_ids,
		'slides_per_view'              => woodmart_get_opt( 'related_product_columns', 4 ),
		'slides_per_view_tablet'       => woodmart_get_opt( 'related_product_columns_tablet' ),
		'slides_per_view_mobile'       => woodmart_get_opt( 'related_product_columns_mobile' ),
		'columns'                      => woodmart_get_opt( 'related_product_columns', 4 ),
		'columns_tablet'               => woodmart_get_opt( 'related_product_columns_tablet' ),
		'columns_mobile'               => woodmart_get_opt( 'related_product_columns_mobile' ),
		'img_size'                     => 'woocommerce_thumbnail',
		'products_bordered_grid'       => woodmart_get_opt( 'products_bordered_grid' ),
		'products_bordered_grid_style' => woodmart_get_opt( 'products_bordered_grid_style' ),
		'products_with_background'     => woodmart_get_opt( 'products_with_background' ),
		'products_shadow'              => woodmart_get_opt( 'products_shadow' ),
		'products_color_scheme'        => woodmart_get_opt( 'products_color_scheme' ),
		'custom_sizes'                 => apply_filters( 'woodmart_product_related_custom_sizes', false ),
		'product_quantity'             => woodmart_get_opt( 'product_quantity' ),
		'spacing'                      => woodmart_get_opt( 'products_spacing' ),
		'spacing_tablet'               => woodmart_get_opt( 'products_spacing_tablet', '' ),
		'spacing_mobile'               => woodmart_get_opt( 'products_spacing_mobile', '' ),
		'wrapper_classes'              => ' related-products',
	);

	if ( woodmart_is_elementor_installed() ) {
		$products_atts['columns']         = array( 'size' => $products_atts['columns'] );
		$products_atts['slides_per_view'] = array( 'size' => $products_atts['slides_per_view'] );
		echo woodmart_elementor_products_template( $products_atts ); //phpcs:ignore
	} else {
		$products_atts['include'] = implode( ',', $products_atts['include'] );
		echo woodmart_shortcode_products( $products_atts ); //phpcs:ignore
	}
}
