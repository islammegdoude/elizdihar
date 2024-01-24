<?php

namespace XTS\Modules;

use Walker_Nav_Menu;

class Mega_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Design.
	 *
	 * @var string
	 */
	private $color_scheme;

	/**
	 * Design.
	 *
	 * @var string
	 */
	private $design = 'default';

	/**
	 * ID.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Header elements settings.
	 *
	 * @var array
	 */
	private $whb_settings;

	/**
	 * WOODMART_Mega_Menu_Walker constructor.
	 */
	public function __construct() {
		$this->color_scheme = whb_get_dropdowns_color();
		$this->whb_settings = whb_get_settings();
	}

	public function get_drilldown_back_button( $tag = 'div' ) {
		if ( ! isset( $this->whb_settings['burger']['menu_layout'] ) || 'drilldown' !== $this->whb_settings['burger']['menu_layout'] ) {
			return '';
		}

		ob_start();
		?>
		<<?php echo $tag; ?> class="wd-drilldown-back">
		<span class="wd-nav-opener"></span>
		<a href="#">
			<?php esc_html_e( 'Back', 'woodmart' ); ?>
		</a>
		</<?php echo $tag; ?>>
		<?php
		return ob_get_clean();
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param mixed  $args   An array of arguments. @see wp_nav_menu().
	 *
	 * @see   Walker::start_lvl()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent        = str_repeat( "\t", $depth );
		$is_nav_mobile = strstr( $args->menu_class, 'wd-nav-mobile' );
		$is_nav_fs     = strstr( $args->menu_class, 'wd-nav-fs' );
		$classes       = '';
		$style         = get_post_meta( $this->id, '_menu_item_style_' . $this->design, true );
		$scroll = get_post_meta( $this->id, '_menu_item_scroll', true );

		if ( 0 === $depth && ! $is_nav_mobile ) {
			if ( 'default' !== $this->color_scheme ) {
				$classes .= ' color-scheme-' . $this->color_scheme;
			}

			$classes .= ' wd-design-' . $this->design;

			if ( ! $is_nav_fs ) {
				$classes .= ' wd-dropdown-menu wd-dropdown';
			} else {
				$classes .= ' wd-dropdown-fs-menu';
			}

			if ( $style ) {
				$classes .= ' wd-style-' . $style;
			}

			if ( 'full-height' === $this->design || 'yes' === $scroll ) {
				$classes .= ' wd-scroll';
			}

			$classes .= woodmart_get_old_classes( ' sub-menu-dropdown' );

			$output .= $indent . '<div class="' . trim( $classes ) . '">';

			if ( 'full-height' === $this->design ) {
				$output .= $indent . '<div class="wd-scroll-content">';
				$output .= $indent . '<div class="wd-dropdown-inner">';
			}

			$output .= $indent . '<div class="container">';

			if ( 'aside' === $this->design ) {
				$output .= $indent . '<div class="wd-sub-menu-wrapp">';
			}
		}

		if ( 0 === $depth ) {
			if ( ( 'full-width' === $this->design || 'sized' === $this->design || 'full-height' === $this->design ) && ! $is_nav_mobile ) {
				$sub_menu_class  = 'wd-sub-menu row';
				$sub_menu_class .= woodmart_get_old_classes( ' sub-menu' );
			} else {
				$sub_menu_class  = 'wd-sub-menu';
				$sub_menu_class .= woodmart_get_old_classes( ' sub-menu' );
			}
		} else {
			if ( 'default' === $this->design && ! $is_nav_mobile && ! $is_nav_fs ) {
				$sub_menu_class = 'sub-sub-menu wd-dropdown';
			} elseif ( 'default' === $this->design && $is_nav_fs ) {
				$sub_menu_class = 'sub-sub-menu wd-dropdown-fs-menu';
			} else {
				$sub_menu_class = 'sub-sub-menu';
			}
		}

		if ( ! $is_nav_mobile && 0 === $depth ) {
			$sub_menu_class .= ' color-scheme-' . $this->color_scheme;
		} elseif ( ! $is_nav_mobile && 1 === $depth && 'aside' === $this->design ) {
			$output .= $indent . '<div class="wd-dropdown-menu wd-dropdown wd-wp-menu">';
		}

		$output .= "\n$indent<ul class=\"$sub_menu_class\">\n";

		if ( $is_nav_mobile ) {
			$output .= $this->get_drilldown_back_button( 'li' );
		}

		if ( 'light' === $this->color_scheme || 'dark' === $this->color_scheme ) {
			$this->color_scheme = whb_get_dropdowns_color();
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param mixed  $args   An array of arguments. @see wp_nav_menu().
	 *
	 * @see   Walker::end_lvl()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$is_nav_mobile = strstr( $args->menu_class, 'wd-nav-mobile' );
		$indent        = str_repeat( "\t", $depth );
		$output       .= "$indent</ul>\n";

		if ( ! $is_nav_mobile && 1 === $depth && 'aside' === $this->design ) {
			$output .= "$indent</div>\n";
		}

		if ( 0 === $depth && ! $is_nav_mobile ) {
			if ( 'aside' === $this->design ) {
				$output .= "$indent</div>\n";
			} elseif ( 'full-height' === $this->design ) {
				$output .= $indent . '</div>';
				$output .= $indent . '</div>';
			}

			$output .= "$indent</div>\n";
			$output .= "$indent</div>\n";
		}
	}

	/**
	 * Start the element output.
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param mixed  $args   An array of arguments. @see wp_nav_menu().
	 * @param int    $id     Current item ID.
	 *
	 * @see   Walker::start_el()
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$this->id      = $item->ID;
		$indent        = $depth ? str_repeat( "\t", $depth ) : '';
		$classes       = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]     = 'menu-item-' . $item->ID;
		$classes[]     = 'item-level-' . $depth;
		$label_out     = '';
		$design        = get_post_meta( $item->ID, '_menu_item_design', true );
		$width         = get_post_meta( $item->ID, '_menu_item_width', true );
		$height        = get_post_meta( $item->ID, '_menu_item_height', true );
		$padding       = get_post_meta( $item->ID, '_menu_item_padding', true );
		$scroll        = get_post_meta( $item->ID, '_menu_item_scroll', true );
		$icon          = get_post_meta( $item->ID, '_menu_item_icon', true );
		$event         = get_post_meta( $item->ID, '_menu_item_event', true );
		$label         = get_post_meta( $item->ID, '_menu_item_label', true );
		$label_text    = get_post_meta( $item->ID, '_menu_item_label-text', true );
		$block         = get_post_meta( $item->ID, '_menu_item_block', true );
		$dropdown_ajax = get_post_meta( $item->ID, '_menu_item_dropdown-ajax', true );
		$opanchor      = get_post_meta( $item->ID, '_menu_item_opanchor', true );
		$color_scheme  = get_post_meta( $item->ID, '_menu_item_colorscheme', true );
		$image_type    = get_post_meta( $item->ID, '_menu_item_image-type', true );

		$is_nav_mobile = false;
		if ( is_object( $args ) && property_exists( $args, 'menu_class' ) ) {
			$is_nav_mobile = strstr( $args->menu_class, 'wd-nav-mobile' );
			$is_nav_fs     = strstr( $args->menu_class, 'wd-nav-fs' );
		}

		if ( 'light' === $color_scheme ) {
			$this->color_scheme = 'light';
		} elseif ( 'dark' === $color_scheme ) {
			$this->color_scheme = 'dark';
		}

		if ( 0 === $depth && $design ) {
			$this->design = $design;
		}

		if ( ! $design ) {
			$design = 'default';
		}

		if ( ! $this->design ) {
			$this->design = 'default';
		}

		if ( 'aside' === $design ) {
			woodmart_enqueue_inline_style( 'dropdown-aside' );
		}

		if ( 'full-height' === $design ) {
			woodmart_enqueue_inline_style( 'dropdown-full-height' );
		}

		if ( 'full-height' === $design || 'yes' === $scroll && ( 'full-width' === $design || 'sized' === $design ) ) {
			woodmart_enqueue_inline_style( 'header-mod-content-calc' );
		}

		if ( ! is_object( $args ) ) {
			return;
		}

		if ( 0 === $depth && ! $is_nav_mobile ) {
			$classes[] = woodmart_get_old_classes( 'menu-item-design-' . $design );
			if ( 'sized' === $design || 'full-width' === $design || 'aside' === $design || 'full-height' === $design ) {
				$classes[] = 'menu-mega-dropdown';
			} else {
				$classes[] = 'menu-simple-dropdown';
			}
		}

		$event = empty( $event ) ? 'hover' : $event;

		if ( ! $is_nav_fs && ! $is_nav_mobile ) {
			$classes[] = 'wd-event-' . $event;
		}

		if ( ( 'full-width' === $this->design || 'sized' === $this->design || 'full-height' === $this->design ) && 1 === $depth && ! $is_nav_mobile ) {
			$classes[] .= 'col-auto';
		}

		if ( $block && $is_nav_mobile ) {
			$classes[] = 'menu-item-has-block';
		}

		if ( 'enable' === $opanchor ) {
			woodmart_enqueue_js_library( 'waypoints' );
			woodmart_enqueue_js_script( 'one-page-menu' );
			$classes[] = 'onepage-link';
			$key       = array_search( 'current-menu-item', $classes );
			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}
		}

		if ( ! empty( $label ) ) {
			woodmart_enqueue_inline_style( 'mod-nav-menu-label' );

			$classes[] = 'item-with-label';
			$classes[] = 'item-label-' . $label;
			$label_out = '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
		}

		woodmart_enqueue_js_script( 'menu-offsets' );
		woodmart_enqueue_js_script( 'menu-setup' );

		if ( ! empty( $block ) && ! $args->walker->has_children ) {
			$classes[] = 'menu-item-has-children';
		}

		if ( 'yes' === $dropdown_ajax ) {
			woodmart_enqueue_js_script( 'menu-dropdowns-ajax' );
			$classes[] = 'dropdown-load-ajax';
		}

		if ( $height && ( 'sized' === $design || 'aside' === $design || 'full-width' === $design ) ) {
			$classes[] = 'dropdown-with-height';
		}

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$styles = '';

		if ( ( 'aside' === $design || 'sized' === $design || 'full-height' === $design || 'full-width' === $design ) && ! $is_nav_mobile && ( $height || $width ) ) {
			if ( $height ) {
				$styles .= '--wd-dropdown-height: ' . $height . 'px;';
			}
			if ( $width ) {
				$styles .= '--wd-dropdown-width: ' . $width . 'px;';
			}
		}

		if ( 'default' !== $design && ! $is_nav_mobile && ( '0' === strval( $padding ) || ! empty( $padding ) ) ) {
			$styles .= '--wd-dropdown-padding: ' . $padding . 'px;';
		}

		if ( 0 === $depth && ! $is_nav_mobile && 'image' !== $image_type ) {
			if ( has_post_thumbnail( $item->ID ) ) {
				$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );

				if ( ! empty( $post_thumbnail ) && isset( $post_thumbnail[0] ) ) {
					$styles .= '--wd-dropdown-bg-img: url(' . $post_thumbnail[0] . ');';
				}
			}
		}

		if ( $styles ) {
			$styles = 'style="' . $styles . '"';
		}

		$output .= $indent . '<li' . $id . $class_names . ' ' . $styles . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $atts   {
		 *                       The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type string  $title  Title attribute.
		 * @type string  $target Target attribute.
		 * @type string  $rel    The rel attribute.
		 * @type string  $href   The href attribute.
		 * }
		 *
		 * @param object $item   The current menu item.
		 * @param array  $args   An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 */
		$atts          = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$atts['class'] = 'woodmart-nav-link';

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$image_output = '';

		if ( 'product_cat' === $item->object || ( 'image' === $image_type && has_post_thumbnail( $item->ID ) ) ) {
			if ( 'image' === $image_type && has_post_thumbnail( $item->ID ) ) {
				$icon_data = array(
					'id'  => get_post_thumbnail_id( $item->ID ),
					'url' => get_the_post_thumbnail_url( $item->ID ),
				);
			} else {
				$icon_data = get_term_meta( $item->object_id, 'category_icon_alt', true );
			}

			$icon_attrs = apply_filters( 'woodmart_megamenu_icon_attrs', false );

			if ( $icon_data ) {
				if ( is_array( $icon_data ) && $icon_data['id'] ) {
					if ( woodmart_is_svg( $icon_data['url'] ) ) {
						$image_output .= woodmart_get_svg_html( $icon_data['id'], apply_filters( 'woodmart_mega_menu_icon_size_svg', '18x18' ), array( 'class' => 'wd-nav-img' ) );
					} else {
						$image_output .= wp_get_attachment_image( $icon_data['id'], apply_filters( 'woodmart_mega_menu_icon_size', 'thumbnail' ), false, array( 'class' => 'wd-nav-img' ) );
					}
				} else {
					if ( isset( $icon_data['url'] ) ) {
						$icon_data = $icon_data['url'];
					}

					if ( $icon_data ) {
						$image_output .= '<img src="' . esc_url( $icon_data ) . '" alt="' . esc_attr( $item->title ) . '" ' . $icon_attrs . ' class="wd-nav-img' . woodmart_get_old_classes( ' category-icon' ) . '" />';
					}
				}
			}
		}

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		if ( $icon ) {
			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				wp_enqueue_style( 'vc_font_awesome_5' );
				wp_enqueue_style( 'vc_font_awesome_5_shims' );
			} else {
				wp_enqueue_style( 'elementor-icons-fa-solid' );
				wp_enqueue_style( 'elementor-icons-fa-brands' );
				wp_enqueue_style( 'elementor-icons-fa-regular' );
			}
			$item_output .= '<span class="wd-nav-icon fa fa-' . $icon . '"></span>';
		}

		$item_output .= $image_output;

		/** This filter is documented in wp-includes/post-template.php */
		if ( 0 === $depth ) {
			$item_output .= '<span class="nav-link-text">' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
		} else {
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		}

		$item_output .= $label_out;
		$item_output .= '</a>';
		$item_output .= $args->after;

		if ( ! $is_nav_mobile ) {
			if ( $block && ! $args->walker->has_children ) {
				$classes = '';

				if ( ! $is_nav_fs ) {
					$classes .= ' wd-dropdown-menu wd-dropdown';
				} else {
					$classes .= ' wd-dropdown-fs-menu';
				}

				$classes .= ' wd-design-' . $design;
				$classes .= ' color-scheme-' . $this->color_scheme;
				$classes .= woodmart_get_old_classes( ' sub-menu-dropdown' );

				if ( 'full-height' === $this->design || 'yes' === $scroll ) {
					$classes .= ' wd-scroll';
				}

				$item_output .= "\n$indent<div class=\"" . trim( $classes ) . "\">\n";

				if ( 'full-height' === $design || 'yes' === $scroll ) {
					$item_output .= "\n$indent<div class=\"wd-scroll-content\">\n";
					$item_output .= "\n$indent<div class=\"wd-dropdown-inner\">\n";
				}

				$item_output .= "\n$indent<div class=\"container\">\n";
				if ( 'yes' === $dropdown_ajax ) {
					$item_output .= '<div class="dropdown-html-placeholder wd-fill" data-id="' . $block . '"></div>';
				} else {
					$item_output .= woodmart_html_block_shortcode( array( 'id' => $block ) );
				}
				$item_output .= "\n$indent</div>\n";

				if ( 'full-height' === $design || 'yes' === $scroll ) {
					$item_output .= "\n$indent</div>\n";
					$item_output .= "\n$indent</div>\n";
				}

				$item_output .= "\n$indent</div>\n";

				if ( 'light' === $this->color_scheme || 'dark' === $this->color_scheme ) {
					$this->color_scheme = whb_get_dropdowns_color();
				}
			}
		} elseif ( strstr( $args->menu_class, 'wd-html-block-on' ) && $block && ! $args->walker->has_children ) {
			$item_output .= '<div class="wd-sub-menu">';
			$item_output .= $this->get_drilldown_back_button();
			$item_output .= '<div class="wd-mob-nav-html-block">';
			if ( 'yes' === $dropdown_ajax ) {
				$item_output .= '<div class="dropdown-html-placeholder wd-fill" data-id="' . $block . '"></div>';
			} else {
				$item_output .= woodmart_html_block_shortcode( array( 'id' => $block ) );
			}
			$item_output .= '</div>';
			$item_output .= '</div>';
		}

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
