<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* 3D view - images in 360 slider
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_3d_view' ) ) {
	function woodmart_shortcode_3d_view( $atts, $content ) {
		$click = $output = $class = '';
		extract( shortcode_atts( array(
			'images' => '',
			'img_size' => 'full',
			'title' => '',
			'style' => '',
			'el_class' => '',
		), $atts ) );

		$id = rand( 100, 999 );

		$images = explode( ',', $images );

		$class .= ' ' . $el_class;

		$frames_count = count( $images );

		if ( $frames_count < 2 ) return;

		ob_start();

		woodmart_enqueue_js_library( 'threesixty' );
		woodmart_enqueue_js_script( 'view3d-element' );
		woodmart_enqueue_inline_style( '360degree' );

		$args = array(
			'frames_count' => count( $images ),
			'images'       => array(),
			'width'        => '',
			'height'       => '',
		);

		foreach ( $images as $img_id ) {
			$img = wp_get_attachment_image_src( $img_id, $img_size );

			$args['width']    = isset( $img[1] ) ? $img[1] : '';
			$args['height']   = isset( $img[2] ) ? $img[2] : '';
			$args['images'][] = isset( $img[0] ) ? $img[0] : '';
		}

		?>
			<div class="wd-threed-view<?php echo esc_attr( $class ); ?> threed-id-<?php echo esc_attr( $id ); ?>" data-args='<?php echo wp_json_encode( $args ); ?>'>
				<?php if ( ! empty( $title ) ): ?>
					<h3 class="threed-title"><span><?php echo wp_kses( $title, woodmart_get_allowed_html() ); ?></span></h3>
				<?php endif ?>
				<ul class="threed-view-images"></ul>
			    <div class="spinner">
			        <span>0%</span>
			    </div>
			</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
