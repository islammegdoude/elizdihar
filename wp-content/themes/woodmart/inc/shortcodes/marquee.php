<?php
/**
 * Marquee shortcode.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_marquee' ) ) {
	/**
	 * Render marquee shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Inner content (shortcode).
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_marquee( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'woodmart_css_id'  => '',
				'icon_fontawesome' => 'far fa-bell',
				'icon_openiconic'  => 'vc-oi vc-oi-dial',
				'icon_typicons'    => 'typcn typcn-adjust-brightness',
				'icon_entypo'      => 'entypo-icon entypo-icon-note',
				'icon_linecons'    => 'vc_li vc_li-heart',
				'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
				'icon_material'    => 'vc-material vc-material-cake',
				'icon_library'     => 'fontawesome',
				'speed'            => '5',
				'direction'        => 'normal',
				'paused_on_hover'  => 'no',
				'icon_type'        => 'without',
				'image'            => '',
				'img_size'         => '25x25',
				'marquee_contents' => '',
				'css'              => '',
			),
			$atts
		);

		if ( 'icon' === $atts['icon_type'] && function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
			vc_icon_element_fonts_enqueue( $atts['icon_library'] );
		}

		$id              = 'wd-' . $atts['woodmart_css_id'];
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );
		$marquee_classes = 'yes' === $atts['paused_on_hover'] ? ' wd-with-pause' : '';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		$icon_output = '';
		$icon_class  = 'wd-marquee-icon wd-icon ';
		$icon_class .= $atts[ 'icon_' . $atts['icon_library'] ];

		if ( 'without' !== $atts['icon_type'] ) {
			$icon_output = '<span class="' . esc_attr( $icon_class ) . '"></span>';
		}

		if ( 'image' === $atts['icon_type'] && ! empty( $atts['image'] ) ) {
			if ( woodmart_is_svg( wp_get_attachment_image_url( $atts['image'] ) ) ) {
				$icon_output = woodmart_get_svg_html(
					$atts['image'],
					$atts['img_size']
				);
			} else {
				$icon_output = woodmart_otf_get_image_html( $atts['image'], $atts['img_size'] );
			}
		}

		$shortcode_html   = '';
		$marquee_contents = vc_param_group_parse_atts( $atts['marquee_contents'] );

		foreach ( $marquee_contents as $item ) {
			$item_icon_output = $icon_output;

			if ( isset( $item['link'] ) ) {
				$link_attrs = woodmart_get_link_attributes( $item['link'] );
			}

			if ( ! isset( $item['image_size'] ) ) {
				$item['image_size'] = $atts['img_size'];
			}

			if ( isset( $item['icon_type'] ) && 'image' === $item['icon_type'] && ! empty( $item['image_id'] ) ) {
				if ( woodmart_is_svg( wp_get_attachment_image_url( $item['image_id'] ) ) ) {
					$item_icon_output = woodmart_get_svg_html(
						$item['image_id'],
						$item['image_size']
					);
				} else {
					$item_icon_output = woodmart_otf_get_image_html( $item['image_id'], $item['image_size'] );
				}
			}

			ob_start();
			?>
			<span>
				<?php echo ! empty( $item_icon_output ) ? $item_icon_output : $icon_output; // phpcs:ignore.?>

				<?php if ( ! empty( $item['text'] ) ) : ?>
					<?php echo do_shortcode( shortcode_unautop( $item['text'] ) ); ?>
				<?php endif; ?>

				<?php if ( isset( $item['link'] ) ) : ?>
					<a class="wd-fill" <?php echo $link_attrs; // phpcs:ignore. ?> aria-label="<?php esc_attr_e( 'Marquee item link', 'woodmart' ); ?>"></a>
				<?php endif; ?>
			</span>
			<?php
			$shortcode_html .= ob_get_clean();
		}

		ob_start();

		woodmart_enqueue_inline_style( 'marquee' );

		?>
			<div id="<?php echo esc_attr( $id ); ?>" class="wd-marquee-wrapp <?php echo esc_attr( $wrapper_classes ); ?>">
				<div class="wd-marquee<?php echo esc_attr( $marquee_classes ); ?>">
					<div class="wd-marquee-content">
						<?php echo $shortcode_html; // phpcs:ignore. ?>
					</div>
					<div class="wd-marquee-content">
						<?php echo $shortcode_html; // phpcs:ignore. ?>
					</div>
				</div>
			</div>
		<?php

		return ob_get_clean();
	}
}
