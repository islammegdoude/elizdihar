<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Pricing tables shortcodes
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_pricing_tables' ) ) {
	function woodmart_shortcode_pricing_tables( $atts = array(), $content = null ) {
		$classes     = '';
		$style_attrs = '';
		$atts        = shortcode_atts(
			array(
				'el_class'         => '',
				'woodmart_css_id'  => '',
				'css'              => '',
				'display_grid'     => 'stretch',
				'display_grid_col' => '',
				'space_between'    => '20',
			),
			$atts
		);

		$wrapper_class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		if ( $atts['css'] && function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_class .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		if ( $atts['el_class'] ) {
			$classes .= ' ' . $atts['el_class'];
		}

		$atts['space_between_tablet'] = woodmart_vc_get_control_data( $atts['space_between'], 'tablet' );
		$atts['space_between_mobile'] = woodmart_vc_get_control_data( $atts['space_between'], 'mobile' );
		$atts['space_between']        = woodmart_vc_get_control_data( $atts['space_between'], 'desktop' );

		$atts['display_grid_col_desktop'] = woodmart_vc_get_control_data( $atts['display_grid_col'], 'desktop' );
		$atts['display_grid_col_tablet']  = woodmart_vc_get_control_data( $atts['display_grid_col'], 'tablet' );
		$atts['display_grid_col_mobile']  = woodmart_vc_get_control_data( $atts['display_grid_col'], 'mobile' );

		if ( 'number' === $atts['display_grid'] ) {
			$classes .= ' wd-grid-g';

			$style_attrs .= woodmart_get_grid_attrs(
				array(
					'columns'        => $atts['display_grid_col_desktop'],
					'columns_tablet' => $atts['display_grid_col_tablet'],
					'columns_mobile' => $atts['display_grid_col_mobile'],
				)
			);
		} else {
			$classes .= ' wd-grid-f-stretch';
		}

		if ( '' !== $atts['space_between'] ) {
			$style_attrs .= '--wd-gap-lg:' . $atts['space_between'] . 'px;';
		}
		if ( '' !== $atts['space_between_tablet'] ) {
			$style_attrs .= '--wd-gap-md:' . $atts['space_between_tablet'] . 'px;';
		}
		if ( '' !== $atts['space_between_mobile'] ) {
			$style_attrs .= '--wd-gap-sm:' . $atts['space_between_mobile'] . 'px;';
		}

		ob_start();

		woodmart_enqueue_inline_style( 'pricing-table' );
		?>
			<div class="pricing-tables-wrapper wd-wpb<?php echo esc_attr( $wrapper_class ); ?>">
				<div class="pricing-tables<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $style_attrs ); ?>">
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

if ( ! function_exists( 'woodmart_shortcode_pricing_plan' ) ) {
	function woodmart_shortcode_pricing_plan( $atts, $content ) {
		global $wpdb, $post;

		$output = $class = $bg_style = '';
		extract(
			shortcode_atts(
				array(
					'name'          => '',
					'price_value'   => '',
					'price_suffix'  => 'per month',
					'currency'      => '',
					'features_list' => '',
					'label'         => '',
					'label_color'   => 'red',
					'link'          => '',
					'button_label'  => '',
					'button_type'   => 'custom',
					'id'            => '',
					'style'         => 'default',
					'best_option'   => '',
					'with_bg_image' => '',
					'bg_image'      => '',
					'css_animation' => 'none',
					'el_class'      => '',
				),
				$atts
			)
		);

		$class .= ' ' . $el_class;
		$class .= woodmart_get_css_animation( $css_animation );

		if ( ! empty( $label ) ) {
			$class .= ' price-with-label label-color-' . $label_color;
		}

		if ( $best_option == 'yes' ) {
			$class .= ' price-highlighted';
		}

		$class .= ' price-style-' . $style;

		if ( $with_bg_image == 'yes' && $bg_image ) {
			$class   .= ' with-bg-image';
			$image    = woodmart_otf_get_image_url( $bg_image, 'full' );
			$bg_style = 'background-image:url(' . esc_url( $image ) . ')';
		}

		$features_list = str_replace( '<br />', PHP_EOL, $features_list );
		$features_list = str_replace( PHP_EOL . PHP_EOL, PHP_EOL, $features_list );

		$features = explode( PHP_EOL, $features_list );

		$product = false;

		if ( $button_type == 'product' && ! empty( $id ) && function_exists( 'wc_setup_product_data' ) ) {
			$product_data = get_post( $id );
			$product      = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ) ) ? wc_setup_product_data( $product_data ) : false;
		}

		ob_start();
		?>
			<div class="wd-price-table wd-col<?php echo esc_attr( $class ); ?>" >
				<div class="wd-plan">
					<div class="wd-plan-name">
						<span class="wd-plan-title title"><?php echo wp_kses( $name, woodmart_get_allowed_html() ); ?></span>
					</div>
				</div>
				<div class="wd-plan-inner">
					<?php if ( ! empty( $label ) ) : ?>
						<div class="wd-plan-label price-label"><span><?php echo wp_kses( $label, woodmart_get_allowed_html() ); ?></span></div>
					<?php endif ?>
					<div class="wd-plan-price" style="<?php echo esc_attr( $bg_style ); ?>">
						<?php if ( $currency ) : ?>
							<span class="wd-price-currency">
								<?php echo wp_kses( $currency, woodmart_get_allowed_html() ); ?>
							</span>
						<?php endif ?>

						<?php if ( $price_value != '' ) : ?>
							<span class="wd-price-value">
								<?php echo wp_kses( $price_value, woodmart_get_allowed_html() ); ?>
							</span>
						<?php endif ?>

						<?php if ( $price_suffix ) : ?>
							<span class="wd-price-suffix">
								<?php echo wp_kses( $price_suffix, woodmart_get_allowed_html() ); ?>
							</span>
						<?php endif ?>
					</div>
					<?php if ( ! empty( $features[0] ) ) : ?>
						<div class="wd-plan-features">
							<?php foreach ( $features as $value ) : ?>
								<div class="wd-plan-feature">
									<?php echo wp_kses( $value, woodmart_get_allowed_html() ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif ?>
					<div class="wd-plan-footer">
						<?php if ( $button_type == 'product' && $product ) : ?>
							<?php
							if ( 'nothing' !== woodmart_get_opt( 'add_to_cart_action' ) ) {
								woodmart_enqueue_js_script( 'action-after-add-to-cart' );
							}

							if ( 'popup' === woodmart_get_opt( 'add_to_cart_action' ) ) {
								woodmart_enqueue_js_library( 'magnific' );
								woodmart_enqueue_inline_style( 'add-to-cart-popup' );
								woodmart_enqueue_inline_style( 'mfp-popup' );
							}
							woocommerce_template_loop_add_to_cart();
							?>
						<?php else : ?>
							<?php if ( $button_label ) : ?>
								<a <?php echo woodmart_get_link_attributes( $link ); ?> class="button price-plan-btn">
									<?php echo wp_kses( $button_label, woodmart_get_allowed_html() ); ?>
								</a>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		if ( $button_type == 'product' && function_exists( 'wc_setup_product_data' ) ) {
			// Restore Product global in case this is shown inside a product post
			wc_setup_product_data( $post );
		}

		return $output;
	}
}
