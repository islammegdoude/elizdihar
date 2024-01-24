<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Menu price element
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_menu_price' ) ) {
	function woodmart_shortcode_menu_price( $atts, $content ) {
		$click = $output = $class = '';
		extract(
			shortcode_atts(
				array(
					'img_id'          => '',
					'img_size'        => 'full',
					'title'           => '',
					'description'     => '',
					'price'           => '',
					'link'            => '',
					'css_animation'   => 'none',
					'el_class'        => '',
					'woodmart_css_id' => '',
					'css'             => '',
				),
				$atts
			)
		);

		$link_attributes = woodmart_get_link_attributes( $link );

		if ( $link_attributes ) {
			$class .= ' wd-with-link';
		}

		$class .= ' ' . $el_class;
		$class .= woodmart_get_css_animation( $css_animation );
		$class .= woodmart_get_old_classes( ' woodmart-menu-price' );

		if ( ! empty( $woodmart_css_id ) ) {
			$class .= ' wd-rs-' . $woodmart_css_id;
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		ob_start();

		woodmart_enqueue_inline_style( 'menu-price' );
		?>
			<div class="wd-menu-price wd-wpb <?php echo esc_attr( $class ); ?>">
				<?php if ( $img_id ) : ?>
					<div class="menu-price-image">
						<?php
							echo woodmart_otf_get_image_html( $img_id, $img_size );
						?>
					</div>
				<?php endif ?>
				<div class="menu-price-desc-wrapp">
					<div class="menu-price-heading">
						<?php if ( ! empty( $title ) ) : ?>
							<h3 class="menu-price-title wd-entities-title"><span><?php echo wp_kses( $title, woodmart_get_allowed_html() ); ?></span></h3>
						<?php endif ?>
						<div class="menu-price-price price"><?php echo wp_kses( $price, woodmart_get_allowed_html() ); ?></div>
					</div>
					<?php if ( $description ) : ?>
						<div class="menu-price-details"><?php echo do_shortcode( $description ); ?></div>
					<?php endif ?>
				</div>

				<?php if ( $link_attributes ) : ?>
					<a class="wd-menu-price-link wd-fill" aria-label="<?php esc_html_e( 'Menu price link', 'woodmart' ); ?>" <?php echo wp_kses( $link_attributes, true ); ?>></a>
				<?php endif; ?>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
