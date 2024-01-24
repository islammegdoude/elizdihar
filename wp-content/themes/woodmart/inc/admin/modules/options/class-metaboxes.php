<?php
/**
 * Create metaboxex object. Container for metabox objects.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options;

use XTS\Modules\Styles_Storage;
use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Store all metaboxes as a static data.
 */
class Metaboxes extends Singleton {

	/**
	 * Default arguments for the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public static $box_defaults = array(
		'id'           => '',
		'title'        => 'Post metabox',
		'object'       => 'post',
		'taxonomies'   => array(),
		'post_types'   => array( 'post' ),
		'css_selector' => '',
	);

	/**
	 * Static array of Metabox objects.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private static $_metaboxes = array();

	/**
	 * Register hooks for metaboxes and save function.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'init', array( $this, 'include_files' ) );

		add_action( 'add_meta_boxes', array( $this, 'register_metaboxes' ), 1 );
		add_action( 'save_post', array( $this, 'save_post' ) );

		add_action( 'init', array( $this, 'term_hooks' ), 100 );

		add_action( 'created_term', array( $this, 'save_term' ), 10, 3 );
		add_action( 'edited_terms', array( $this, 'save_term' ), 10, 2 );
		add_action( 'pre_delete_term', array( $this, 'delete_term' ), 10, 2 );

		// Comment.
		add_action( 'edit_comment', array( $this, 'save_comment' ), 10, 3 );
		add_action( 'add_meta_boxes_comment', array( $this, 'register_comment_metaboxes' ) );
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$settings_files = array(
			'pages',
			'products',
			'slider',
		);

		foreach ( $settings_files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/metaboxes/' . $file . '.php' );
		}
	}

	/**
	 * Static method to add metabox with arguments.
	 *
	 * @param array $args Arguments for Metabox class to create a new object.
	 *
	 * @return Metabox
	 *@since 1.0.0
	 *
	 */
	public static function add_metabox( $args ) {
		$args = wp_parse_args( $args, self::$box_defaults );

		$metabox = new Metabox( $args );

		self::$_metaboxes[ $args['id'] ] = $metabox;

		return $metabox;
	}

	/**
	 * Get metabox class by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $id Metabox ID.
	 * @return bool|mixed
	 */
	public static function get_metabox( $id ) {
		return isset( self::$_metaboxes[ $id ] ) ? self::$_metaboxes[ $id ] : false;
	}

	/**
	 * Register metabox callback.
	 *
	 * @since 1.0.0
	 */
	public function register_metaboxes() {
		$posts_metaboxes = self::get_posts_metaboxes();
		if ( empty( $posts_metaboxes ) ) {
			return;
		}

		foreach ( $posts_metaboxes as $key => $metabox ) {
			add_meta_box(
				$metabox->get_id(),
				$metabox->get_title(),
				array( $metabox, 'render' ),
				$metabox->get_post_types()
			);
		}
	}

	/**
	 * Register comment metabox callback.
	 *
	 * @since 1.0.0
	 */
	public function register_comment_metaboxes() {
		$metaboxes = self::get_comments_metaboxes();

		if ( empty( $metaboxes ) ) {
			return;
		}

		foreach ( $metaboxes as $key => $metabox ) {
			add_meta_box(
				$metabox->get_id(),
				$metabox->get_title(),
				array( $metabox, 'render' ),
				'comment',
				'normal'
			);
		}
	}

	/**
	 * Register metabox callback.
	 *
	 * @since 1.0.0
	 */
	public function term_hooks() {
		$terms_metaboxes = self::get_terms_metaboxes();
		if ( empty( $terms_metaboxes ) ) {
			return;
		}
		foreach ( $terms_metaboxes as $key => $metabox ) {
			foreach ( $metabox->get_taxonomies() as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields', array( $metabox, 'render' ), 10, 2 );
				add_action( $taxonomy . '_edit_form', array( $metabox, 'render' ), 8, 2 );
			}
		}
	}

	/**
	 * Callback for metabox fields save hook.
	 *
	 * @since 1.0.0
	 *
	 * @param  int $post_id ID of the post to save.
	 */
	public function save_post( $post_id ) {
		$posts_metaboxes = self::get_posts_metaboxes();
		foreach ( $posts_metaboxes as $key => $metabox ) {
			$metabox->save_posts_fields( $post_id );
		}
	}

	/**
	 * Callback for term create and update.
	 *
	 * @since 1.0.0
	 *
	 * @param  int    $term_id  Term ID.
	 * @param  int    $tt_id    Term Taxonomy ID.
	 * @param  string $taxonomy Taxonomy.
	 * @return void
	 */
	public function save_term( $term_id, $tt_id, $taxonomy = '' ) {
		$terms_metaboxes = self::get_terms_metaboxes();
		foreach ( $terms_metaboxes as $key => $metabox ) {
			$metabox->save_terms_fields( $term_id );
		}
	}

	/**
	 * Callback for comment create and update.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $comment_id The comment ID.
	 * @param array $data       Comment data.
	 *
	 * @return void
	 */
	public function save_comment( $comment_id, $data ) {
		$metaboxes = self::get_comments_metaboxes();
		foreach ( $metaboxes as $key => $metabox ) {
			$metabox->save_comments_fields( $comment_id );
		}
	}

	/**
	 * Callback for term delete.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $term     Term ID.
	 * @param string $taxonomy Taxonomy slug.
	 * @return void
	 */
	public function delete_term( $term, $taxonomy ) {
		$storage = new Styles_Storage( 'term-' . $term, 'term', $term );

		$storage->delete_file();
		$storage->reset_data();
	}

	/**
	 * Get metaboxes for posts.
	 *
	 * @since 1.0.0
	 */
	public static function get_posts_metaboxes() {
		return array_filter(
			self::$_metaboxes,
			function( $box ) {
				return $box->get_object() === 'post';
			}
		);
	}

	/**
	 * Get metaboxes for taxonomy.
	 *
	 * @since 1.0.0
	 */
	public static function get_terms_metaboxes() {
		return array_filter(
			self::$_metaboxes,
			function( $box ) {
				return $box->get_object() === 'term';
			}
		);
	}

	/**
	 * Get metaboxes for comments.
	 *
	 * @since 1.0.0
	 */
	public static function get_comments_metaboxes() {
		return array_filter(
			self::$_metaboxes,
			function( $box ) {
				$object = $box->get_object();
				return is_array( $object ) && isset( $object[0] ) && 'comment' === $object[0];
			}
		);
	}

	/**
	 * Get metaboxes for comments.
	 *
	 * @since 1.0.0
	 */
	public static function get_metabox_css( $id, $metabox_id ) {
		if ( empty( self::$_metaboxes[ $metabox_id ] ) ) {
			return '';
		}

		return self::$_metaboxes[ $metabox_id ]->build_fields_css( $id, self::$_metaboxes[ $metabox_id ]->get_object() );
	}
}

Metaboxes::get_instance();
