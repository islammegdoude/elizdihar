<?php
/**
 * Import menu.
 *
 * @package Woodmart
 */

namespace XTS\Admin\Modules\Import;

use WP_Query;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import menu.
 */
class Menu {
	/**
	 * Version name.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 *
	 * @param string $version Version name.
	 */
	public function __construct( $version ) {
		$this->version = $version;

		$this->set_home_page();
		$this->add_default_pages_to_menu();
	}

	/**
	 * Add default pages to menu.
	 */
	public function add_default_pages_to_menu() {
		$query      = new WP_Query(
			array(
				'post_type'              => 'cms_block',
				'title'                  => 'Menu home',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);
		$home_block = ! empty( $query->post ) ? $query->post : null;
		$home_meta  = array();

		if ( ! is_null( $home_block ) ) {
			$home_meta = array(
				'block'  => $home_block->ID,
				'design' => 'full-width',
			);
		}

		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'main', $home_meta );
		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'mobile', $home_meta );
		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'left', $home_meta );
	}

	/**
	 * Set home page.
	 */
	public function set_home_page() {
		$home_page_title = 'Home ' . $this->version;
		$query           = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => $home_page_title,
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);
		$home_page       = ! empty( $query->post ) ? $query->post : null;

		if ( ! is_null( $home_page ) ) {
			update_option( 'page_on_front', $home_page->ID );
			update_option( 'show_on_front', 'page' );
		}
	}

	/**
	 * Add menu item by title.
	 *
	 * @param string $title    Param.
	 * @param false  $position Param.
	 * @param string $menu     Param.
	 * @param array  $meta     Param.
	 *
	 * @return int|string
	 */
	public function add_menu_item_by_title( $title, $position = false, $menu = 'main', $meta = array() ) {
		$query = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => $title,
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);
		$page  = ! empty( $query->post ) ? $query->post : null;

		if ( is_null( $page ) ) {
			return '';
		}

		if ( strstr( $title, 'Home' ) ) {
			$title = 'Home';
		}

		$this->insert_menu_item( $title, $position, $page->ID, $menu, $meta );

		return $page->ID;
	}

	/**
	 * Insert menu item.
	 *
	 * @param string $page_title Param.
	 * @param false  $position   Param.
	 * @param false  $page_id    Param.
	 * @param string $menu       Param.
	 * @param array  $meta       Param.
	 */
	private function insert_menu_item( $page_title, $position = false, $page_id = false, $menu = 'main', $meta = array() ) {
		$menu_id = $this->get_menu_id( $menu );

		$all_items = wp_get_nav_menu_items( $menu_id );

		if ( ! is_array( $all_items ) ) {
			return;
		}

		foreach ( $all_items as $item ) {
			if ( $item->title === $page_title ) {
				wp_delete_post( $item->ID, true );
			}
		}

		$args = array(
			'menu-item-title'  => $page_title,
			'menu-item-object' => 'page',
			'menu-item-type'   => 'post_type',
			'menu-item-status' => 'publish',
		);

		if ( $position ) {
			$args['menu-item-position'] = $position;
		}

		if ( $page_id ) {
			$args['menu-item-object-id'] = $page_id;
		}

		$menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $args );

		if ( ! empty( $meta ) ) {
			foreach ( $meta as $key => $value ) {
				if ( 'content' === $key ) {
					wp_update_post(
						array(
							'ID'           => $menu_item_id,
							'post_content' => $value,
						)
					);
				} else {
					add_post_meta( $menu_item_id, '_menu_item_' . $key, $value );
				}
			}
		}
	}

	/**
	 * Get menu id.
	 *
	 * @param string $menu Menu key.
	 *
	 * @return mixed
	 */
	private function get_menu_id( $menu ) {
		$main_menu   = get_term_by( 'name', 'Main navigation', 'nav_menu' );
		$mobile_menu = get_term_by( 'name', 'Mobile navigation', 'nav_menu' );
		$left_menu   = get_term_by( 'name', 'Main menu left', 'nav_menu' );

		$menu_ids = array(
			'main'   => is_object( $main_menu ) ? $main_menu->term_id : '',
			'mobile' => is_object( $mobile_menu ) ? $mobile_menu->term_id : '',
			'left'   => is_object( $left_menu ) ? $left_menu->term_id : '',
		);

		return $menu_ids[ $menu ];
	}
}
