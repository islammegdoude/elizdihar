<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Shortcode function to display posts as a slider or as a grid
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_generate_posts_slider' ) ) {
	function woodmart_generate_posts_slider( $atts, $query = false, $products = false ) {
		$posts_query     = $el_class = $args = $my_query = $speed = '';
		$slides_per_view = $wrap = $scroll_per_page = $title_out = '';
		$autoplay        = $hide_pagination_control = $hide_prev_next_buttons = $output = $owl_atts = '';
		$posts           = array();

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'el_class'                     => '',
					'wrapper_classes'              => '',
					'posts_query'                  => '',
					'highlighted_products'         => 0,
					'product_quantity'             => 0,
					'products_bordered_grid'       => 0,
					'products_bordered_grid_style' => 'outside',
					'products_with_background'     => 0,
					'products_shadow'              => woodmart_get_opt( 'products_shadow' ),
					'products_color_scheme'        => 'default',
					'product_hover'                => woodmart_get_opt( 'products_hover' ),
					'spacing'                      => '',
					'spacing_tablet'               => '',
					'spacing_mobile'               => '',
					'blog_design'                  => 'default',
					'blog_carousel_design'         => 'masonry',
					'img_size'                     => 'large',
					'img_size_custom'              => '',
					'title'                        => '',
					'element_title'                => '',
					'scroll_carousel_init'         => 'no',
					'lazy_loading'                 => 'no',
					'elementor'                    => false,
					'carousel_classes'             => '',
					'ajax_recently_viewed'         => '',
					'layout'                       => '',
					'items_per_page'               => 12,
					'woodmart_css_id'              => '',
					'grid_gallery'                 => '',
					'grid_gallery_control'         => '',
					'grid_gallery_enable_arrows'   => '',
					'parts_title'                  => true,
					'parts_meta'                   => true,
					'parts_text'                   => true,
					'parts_btn'                    => true,
					'css'                          => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		if ( empty( $product_hover ) || $product_hover == 'inherit' ) {
			$product_hover = woodmart_get_opt( 'products_hover' );
		}

		woodmart_set_loop_prop( 'product_hover', $product_hover );
		woodmart_set_loop_prop( 'img_size', $img_size );
		woodmart_set_loop_prop( 'products_color_scheme', $products_color_scheme );

		if ( ! empty( $grid_gallery ) ) {
			woodmart_set_loop_prop( 'grid_gallery', $grid_gallery );

			if ( ! empty( $grid_gallery_enable_arrows ) ) {
				woodmart_set_loop_prop( 'grid_gallery_enable_arrows', $grid_gallery_enable_arrows );
			}

			if ( ! empty( $grid_gallery_control ) ) {
				woodmart_set_loop_prop( 'grid_gallery_control', $grid_gallery_control );
			}
		}

		if ( $blog_design == 'carousel' ) {
			woodmart_set_loop_prop( 'blog_layout', 'carousel' );
			woodmart_set_loop_prop( 'blog_design', $blog_carousel_design );
		}

		if ( ! $query && ! $products && function_exists( 'vc_build_loop_query' ) ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query );
		}

		if ( ! $elementor ) {
			ob_start();
		}

		$carousel_id       = 'carousel-' . wp_rand( 100, 999 );
		$carousel_classes .= ' wd-carousel';
		$carousel_classes .= ' wd-grid';

		if ( $highlighted_products ) {
			$wrapper_classes .= ' wd-highlighted-products' . woodmart_get_old_classes( ' woodmart-highlighted-products' );

			woodmart_enqueue_inline_style( 'highlighted-product' );
		}

		$wrapper_classes .= ( $element_title ) ? ' with-title' : '';

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( isset( $query->query['post_type'] ) ) {
			$post_type = $query->query['post_type'];
		} elseif ( $products ) {
			$post_type = 'product';
		} else {
			$post_type = 'post';
		}

		if ( is_array( $post_type ) ) {
			$post_type = $post_type[0];
		}

		$carousel_atts = '';

		if ( $woodmart_css_id ) {
			$wrapper_classes .= ' wd-rs-' . $woodmart_css_id;
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

		if ( ! empty( $carousel_arrows_position ) ) {
			$nav_classes = ' wd-pos-' . $carousel_arrows_position;
		} elseif ( $highlighted_products ) {
			if ( $element_title ) {
				$nav_classes = ' wd-pos-together';
			} else {
				$nav_classes = ' wd-pos-sep';
			}
		} else {
			$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
		}

		if ( $highlighted_products ) {
			$nav_classes .= ' wd-custom-style';
		}

		if ( ! $highlighted_products && 'disable' !== $arrows_hover_style ) {
			$nav_classes .= ' wd-hover-' . $arrows_hover_style;
		}

		if ( $post_type == 'post' ) {
			$wrapper_classes .= ' wd-posts wd-blog-element';

			woodmart_set_loop_prop( 'parts_title', $parts_title );
			woodmart_set_loop_prop( 'parts_meta', $parts_meta );
			woodmart_set_loop_prop( 'parts_text', $parts_text );
			woodmart_set_loop_prop( 'parts_btn', $parts_btn );
		}

		if ( $post_type == 'product' ) {
			$wrapper_classes .= ' wd-products-element wd-products products';

			if ( 'yes' === $ajax_recently_viewed ) {
				$carousel_atts .= ' data-atts=\'' . wp_json_encode( $parsed_atts ) . '\' ';

				if ( $query && ! $query->have_posts() && $elementor ) {
					$wrapper_classes .= ' wd-hide';
				}
			}

			if ( 'no' !== woodmart_loop_prop( 'grid_gallery' ) && woodmart_loop_prop( 'grid_gallery' ) ) {
				$carousel_atts .= ' data-grid-gallery=\'' . wp_json_encode(
					array(
						'grid_gallery'               => woodmart_loop_prop( 'grid_gallery' ),
						'grid_gallery_control'       => woodmart_loop_prop( 'grid_gallery_control' ),
						'grid_gallery_enable_arrows' => woodmart_loop_prop( 'grid_gallery_enable_arrows' ),
					)
				) . '\' ';
			}

			if ( 'default' !== $products_color_scheme && ( $products_bordered_grid || 'enable' === $products_bordered_grid ) && 'disable' !== $products_bordered_grid && 'outside' === $products_bordered_grid_style ) {
				$wrapper_classes .= ' wd-bordered-' . woodmart_loop_prop( 'products_color_scheme' );
			}

			if ( $products_with_background ) {
				woodmart_enqueue_inline_style( 'woo-opt-products-bg' );

				$wrapper_classes .= ' wd-products-with-bg';
			}

			if ( $products_shadow ) {
				woodmart_enqueue_inline_style( 'woo-opt-products-shadow' );

				$wrapper_classes .= ' wd-products-with-shadow';
			}

			if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $product_hover, array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button', 'buttons-on-hover' ) ) ) {
				woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
				if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
					$wrapper_classes .= ' wd-stretch-cont-lg';
				}
				if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
					$wrapper_classes .= ' wd-stretch-cont-md';
				}
				if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
					$wrapper_classes .= ' wd-stretch-cont-sm';
				}
			}

			if ( woodmart_loop_prop( 'product_quantity' ) ) {
				$wrapper_classes .= ' wd-quantity-enabled';
			}

			if ( $products_bordered_grid && ! $highlighted_products ) {
				woodmart_enqueue_inline_style( 'bordered-product' );

				if ( 'outside' === $products_bordered_grid_style ) {
					$wrapper_classes .= ' products-bordered-grid';
				} elseif ( 'inside' === $products_bordered_grid_style ) {
					$wrapper_classes .= ' products-bordered-grid-ins';
				}
			}

			if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $product_hover, array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button', 'buttons-on-hover' ) ) ) {
				woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
				if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
					$carousel_classes .= ' wd-stretch-cont-lg';
				}
				if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
					$carousel_classes .= ' wd-stretch-cont-md';
				}
				if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
					$carousel_classes .= ' wd-stretch-cont-sm';
				}
			}
		}

		if ( $post_type == 'portfolio' ) {
			$wrapper_classes .= ' wd-projects wd-portfolio-element';
		}

		if ( $scroll_carousel_init == 'yes' ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$carousel_classes .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
		}

		if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
			$wrapper_classes .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
		}

		if ( $el_class ) {
			$carousel_classes .= ' ' . $el_class;
		}

		$parsed_atts['carousel_id'] = $carousel_id;
		$parsed_atts['post_type']   = $post_type;

		$carousel_atts .= woodmart_get_carousel_attributes( $parsed_atts );

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );

		if ( ( $query && $query->have_posts() ) || $products || 'yes' === $ajax_recently_viewed ) {
			?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="wd-carousel-container<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php if ( $title || $element_title ) : ?>
					<h4 class="wd-el-title title slider-title element-title">
						<span>
							<?php echo esc_html( $title ? $title : $element_title ); ?>
						</span>
					</h4>
				<?php endif; ?>

				<div class="wd-carousel-inner">
					<div class="<?php echo esc_attr( $carousel_classes ); ?>" <?php echo wp_kses( $carousel_atts, true ); ?>>
						<div class="wd-carousel-wrap">
							<?php
							if ( $products ) {
								foreach ( $products as $product ) {
									woodmart_carousel_query_item( false, $product );
								}
							} else {
								while ( $query->have_posts() ) {
									woodmart_carousel_query_item( $query );
								}
							}
							?>
						</div>
					</div>

					<?php if ( 'yes' !== $hide_prev_next_buttons ) : ?>
						<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
					<?php endif; ?>
				</div>

				<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
				<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
			</div><!-- end #<?php echo esc_html( $carousel_id ); ?> -->
			<?php
		}
		wp_reset_postdata();

		woodmart_reset_loop();

		if ( function_exists( 'wc_reset_loop' ) ) {
			wc_reset_loop();
		}

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		if ( ! $elementor ) {
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}
}

if ( ! function_exists( 'woodmart_carousel_query_item' ) ) {
	function woodmart_carousel_query_item( $query = false, $product = false ) {
		global $post;
		if ( $query ) {
			$query->the_post(); // Get post from query
		} elseif ( $product ) {
			$post_object = get_post( $product->get_id() );
			$post        = $post_object;
			setup_postdata( $post );
		}

		if ( get_option( 'woocommerce_hide_out_of_stock_items' ) === 'yes' && ! $product && is_object( $post ) ) {
			$product = wc_get_product( $post->ID );

			// Duplicate condition from content-product.php to remove the SLIDE wrapper.
			if ( $product && method_exists( $product, 'is_visible' ) && ! $product->is_visible() ) {
				return;
			}
		}

		?>
		<div class="wd-carousel-item">
			<?php if ( get_post_type() == 'product' || get_post_type() == 'product_variation' && woodmart_woocommerce_installed() ) : ?>
				<?php woodmart_set_loop_prop( 'is_slider', true ); ?>
				<?php wc_get_template_part( 'content-product' ); ?>
			<?php elseif ( get_post_type() == 'portfolio' ) : ?>
				<?php get_template_part( 'content', 'portfolio-slider' ); ?>
			<?php else : ?>
				<?php
				$blog_design = woodmart_loop_prop( 'blog_design' );
				$blog_template = woodmart_is_blog_design_new( $blog_design ) ? $blog_design : 'slider';
				?>
				<?php get_template_part( 'content', $blog_template ); ?>
			<?php endif ?>
		
		</div>
		<?php
	}
}
