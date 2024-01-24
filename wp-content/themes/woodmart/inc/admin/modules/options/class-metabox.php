<?php
/**
 * Create metabox object with fields.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options;

use Elementor\Plugin;
use XTS\Admin\Modules\Options;
use XTS\Modules\Styles_Storage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Metabox class to store all fields for particular metaboxes created.
 */
class Metabox {

	/**
	 * Metabox ID.
	 *
	 * @var int
	 */
	private $_id;

	/**
	 * Metabox title.
	 *
	 * @var string
	 */
	private $_title;

	/**
	 * Taxonomies that we add this metabox to.
	 *
	 * @var array
	 */
	private $_taxonomies;

	/**
	 * Post type array where this metabox will be displayed.
	 *
	 * @var array
	 */
	private $_post_types;

	/**
	 * Fields array for this metabox. Array of Field objects.
	 *
	 * @var array
	 */
	private $_fields = array();

	/**
	 * Metaboxes may have sections as well.
	 *
	 * @var array
	 */
	private $_sections = array();

	/**
	 * Basic arguments array.
	 *
	 * @var array
	 */
	private $_args;

	/**
	 * Can be post or term.
	 *
	 * @var array
	 */
	private $_object;

	/**
	 * Array of field type and controls mapping.
	 *
	 * @var array
	 */
	private $_controls_classes = array(
		'select'            => 'XTS\Admin\Modules\Options\Controls\Select',
		'text_input'        => 'XTS\Admin\Modules\Options\Controls\Text_Input',
		'switcher'          => 'XTS\Admin\Modules\Options\Controls\Switcher',
		'color'             => 'XTS\Admin\Modules\Options\Controls\Color',
		'checkbox'          => 'XTS\Admin\Modules\Options\Controls\Checkbox',
		'buttons'           => 'XTS\Admin\Modules\Options\Controls\Buttons',
		'upload'            => 'XTS\Admin\Modules\Options\Controls\Upload',
		'upload_list'       => 'XTS\Admin\Modules\Options\Controls\Upload_List',
		'background'        => 'XTS\Admin\Modules\Options\Controls\Background',
		'textarea'          => 'XTS\Admin\Modules\Options\Controls\Textarea',
		'typography'        => 'XTS\Admin\Modules\Options\Controls\Typography',
		'custom_fonts'      => 'XTS\Admin\Modules\Options\Controls\Custom_Fonts',
		'range'             => 'XTS\Admin\Modules\Options\Controls\Range',
		'responsive_range'  => 'XTS\Admin\Modules\Options\Controls\Responsive_Range',
		'editor'            => 'XTS\Admin\Modules\Options\Controls\Editor',
		'import'            => 'XTS\Admin\Modules\Options\Controls\Import',
		'notice'            => 'XTS\Admin\Modules\Options\Controls\Notice',
		'select_with_table' => 'XTS\Admin\Modules\Options\Controls\Select_With_Table',
		'dimensions'        => 'XTS\Admin\Modules\Options\Controls\Dimensions',
		'group'             => 'XTS\Admin\Modules\Options\Controls\Group',
	);

	/**
	 * Create an object from args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Basic arguments for the object.
	 */
	public function __construct( $args ) {
		$this->_id         = $args['id'];
		$this->_title      = $args['title'];
		$this->_post_types = $args['post_types'];
		$this->_taxonomies = $args['taxonomies'];
		$this->_object     = $args['object'];
		$this->_args       = $args;
	}

	/**
	 * Get the metabox ID.
	 *
	 * @since 1.0.0
	 *
	 * @return int Metabox id field.
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Getter for the metabox title.
	 *
	 * @since 1.0.0
	 *
	 * @return string The metabox title.
	 */
	public function get_title() {
		return $this->_title;
	}

	/**
	 * Getter for the metaboxes taxonomies.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomies array for this metabox.
	 */
	public function get_taxonomies() {
		return $this->_taxonomies;
	}

	/**
	 * Getter for the metabox object.
	 *
	 * @since 1.0.0
	 *
	 * @return string The metabox object.
	 */
	public function get_object() {
		return $this->_object;
	}

	/**
	 * Getter for the metaboxes post types array.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post types array for this metabox.
	 */
	public function get_post_types() {
		return $this->_post_types;
	}

	/**
	 * Adds the Field object to this metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Field arguments.
	 */
	public function add_field( $args ) {

		$control_classname = $this->_controls_classes[ $args['type'] ];

		$control = new $control_classname( $args, false, 'metabox', $this->get_object() );

		$this->_fields[] = $control;

		// Override theme setting option based on the meta value for this post and field.
		if ( isset( $args['option_override'] ) ) {
			Options::register_meta_override( $args['option_override'] );
		}
	}

	/**
	 * Static method to add a section to the array.
	 *
	 * @since 1.0.0
	 *
	 * @param array $section Arguments array for new section.
	 */
	public function add_section( $section ) {
		$this->_sections[ $section['id'] ] = $section;
	}
	/**
	 * Static method to get all fields objects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Field objects array.
	 */
	public function get_fields() {
		$fields = $this->_fields;

		usort(
			$fields,
			function ( $item1, $item2 ) {

				if ( ! isset( $item1->args['priority'] ) ) {
					return 1;
				}

				if ( ! isset( $item2->args['priority'] ) ) {
					return -1;
				}

				return $item1->args['priority'] - $item2->args['priority'];
			}
		);

		return $fields;

	}

	/**
	 * Output fields CSS code based on its controls and values.
	 *
	 * @since 1.0.0
	 */
	public function fields_css_output( $post = '' ) {
		if ( ! $post ) {
			$post = get_post();
		}

		$object_id  = '';
		$output_css = '';
		$fields_css = array(
			'desktop' => array(
				':root' => array(),
			),
			'tablet'  => array(
				':root' => array(),
			),
			'mobile'  => array(
				':root' => array(),
			),
		);

		if ( is_a( $post, 'WP_Post' ) ) {
			$object_id = $post->ID;
		} elseif ( is_a( $post, 'WP_Term' ) ) {
			$object_id = $post->term_id;
		}

		foreach ( $this->get_fields() as $field ) {
			$generate_field_css = true;

			if ( ! empty( $field->args['requires'] ) ) {
				foreach ( $field->args['requires'] as $require ) {
					$value = get_metadata( $this->get_object(), $object_id, $require['key'], true );

					if ( 'equals' === $require['compare'] && ( ( is_array( $require['value'] ) && ! in_array( $value, $require['value'], true ) ) || ( ! is_array( $require['value'] ) && $value !== $require['value'] ) ) ) {
						$generate_field_css = false;
					} elseif ( 'not_equals' === $require['compare'] && ( ( is_array( $require['value'] ) && in_array( $value, $require['value'], true ) ) || ( ! is_array( $require['value'] ) && $value === $require['value'] ) ) ) {
						$generate_field_css = false;
					}
				}
			}

			if ( ! $generate_field_css ) {
				continue;
			}

			$field->set_post( $post );

			$field_css = $field->css_output();

			if ( $field_css && is_array( $field_css ) ) {
				$fields_css = array_merge_recursive( $fields_css, $field_css );
			}
		}

		foreach ( $fields_css as $device => $device_css ) {
			if ( $device_css ) {
				$css = '';

				foreach ( $device_css as $selector => $raw_css ) {
					$prefix = in_array( $device, array( 'tablet', 'mobile' ), true ) ? "\t" : '';

					if ( $raw_css ) {
						$raw_css = implode( "\t", array_filter( (array) $raw_css ) );

						if ( trim( $raw_css ) ) {
							$css .= $prefix . $selector . " {\n\t" . $prefix . $raw_css . $prefix . "}\n";
						}
					}
				}

				if ( ! $css ) {
					continue;
				}

				$output_css .= $this->get_heading_css_attribute( $css, $device );
			}
		}

		return $output_css;
	}

	/**
	 * Print css heading.
	 *
	 * @param string $css CSS.
	 * @param string $device Device.
	 *
	 * @return string
	 */
	private function get_heading_css_attribute( $css, $device = '' ) {
		if ( 'tablet' === $device ) {
			return "\n@media (max-width: 1024px) {\n$css}\n";
		}

		if ( 'mobile' === $device ) {
			if ( 'elementor' === woodmart_get_current_page_builder() && woodmart_is_elementor_installed() ) {
				$breakpoints = array(
					'mobile' => array(
						'value' => 767,
					),
				);

				if ( Plugin::$instance->experiments->is_feature_active( 'additional_custom_breakpoints' ) && Plugin::$instance->breakpoints->has_custom_breakpoints() ) {
					$breakpoints = wp_parse_args( Plugin::$instance->breakpoints->get_breakpoints_config(), $breakpoints );
				}

				$size = $breakpoints['mobile']['value'];
			} elseif ( 'wpb' === woodmart_get_current_page_builder() ) {
				$size = 767;
			} else {
				$size = 768.98;
			}

			return "\n@media (max-width: " . $size . "px) {\n$css}\n";
		}

		return $css;
	}


	/**
	 * Static method to get all sections.
	 *
	 * @since 1.0.0
	 *
	 * @return array Section array.
	 */
	public function get_sections() {
		global $current_screen;

		$sections = $this->_sections;

		usort(
			$sections,
			function ( $item1, $item2 ) {

				if ( ! isset( $item1['priority'] ) ) {
					return 1;
				}

				if ( ! isset( $item2['priority'] ) ) {
					return -1;
				}

				return $item1['priority'] - $item2['priority'];
			}
		);

		$sections_assoc = array();

		foreach ( $sections as $key => $section ) {
			if ( isset( $section['post_types'] ) && ! in_array( $current_screen->post_type, $section['post_types'], true ) ) {
				continue;
			}

			$sections_assoc[ $section['id'] ] = $section;
		}

		return $sections_assoc;
	}

	/**
	 * Load all field objects and add them to the sections set.
	 *
	 * @since 1.0.0
	 */
	private function load_fields() {
		foreach ( $this->get_fields() as $key => $field ) {
			$this->_sections[ $field->args['section'] ]['fields'][] = $field;
		}
	}

	/**
	 * Generate a unique nonce for each registered meta_box
	 *
	 * @since  2.0.0
	 * @return string unique nonce string.
	 */
	public function nonce() {
		return sanitize_html_class( 'wd-metabox-nonce_' . basename( __FILE__ ) );
	}

	/**
	 * Render this metabox and all its fields.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $object Post or Term object to render with its meta values.
	 */
	public function render( $object ) {
		$this->load_fields();

		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-helpers', WOODMART_SCRIPTS . '/scripts/global/helpers.min.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-tabs', WOODMART_SCRIPTS . '/scripts/elements/tabs.js', array(), WOODMART_VERSION, true );

		?>
		<script>
			var woodmart_settings = {
				product_gallery    : {
					thumbs_slider: {
						position: true
					}
				},
				lazy_loading_offset: 0
			};
		</script>
		<div class="xts-box xts-options xts-metaboxes xts-theme-style">
			<?php wp_nonce_field( $this->nonce(), $this->nonce(), false, true ); ?>
			<div class="xts-box-content">
				<div class="xts-row xts-sp-20">
					<?php if ( count( $this->get_sections() ) > 1 ) : ?>
						<div class="xts-col-12 xts-col-xl-2">
							<ul class="xts-nav xts-nav-vertical">
								<?php $this->display_sections_tree(); ?>
							</ul>
						</div>
					<?php endif; ?>
					<div class="xts-col">
						<?php $this->display_sections( $object ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Display sections navigation tree.
	 *
	 * @since 1.0.0
	 */
	private function display_sections_tree() {
		foreach ( $this->get_sections() as $key => $section ) {
			if ( isset( $section['parent'] ) ) {
				continue;
			}

			$subsections = array_filter(
				$this->get_sections(),
				function( $el ) use ( $section ) {
					return isset( $el['parent'] ) && $el['parent'] === $section['id'];
				}
			);

			if ( ! isset( $section['icon'] ) ) {
				ar( $section );
			}
			?>
				<li class="<?php echo ( $key === $this->get_last_tab() ) ? 'xts-active-nav' : ''; ?>">
					<a class="<?php echo esc_html( $section['icon'] ); ?>" href="" data-id="<?php echo esc_attr( $key ); ?>"  data-id="<?php echo esc_attr( $key ); ?>">
						<span>
							<?php echo $section['name']; // phpcs:ignore ?>
						</span>
					</a>

					<?php if ( is_array( $subsections ) && count( $subsections ) > 0 ) : ?>
						<ul class="xts-sub-menu">
							<?php foreach ( $subsections as $key => $subsection ) : ?>
								<li class="xts-sub-menu-item">
									<a href="" data-id="<?php echo esc_attr( $key ); ?>">
										<?php echo $subsection['name']; // phpcs:ignore ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php
		}
	}

	/**
	 * Get last visited tab by visitor.
	 *
	 * @since 1.0.0
	 */
	private function get_last_tab() {
		reset( $this->_sections );

		$first_tab = key( $this->_sections );

		return $first_tab;
	}

	/**
	 * Loop through all the sections and render all the fields.
	 *
	 * @since 1.0.0
	 *
	 * @param object $object Object.
	 */
	private function display_sections( $object ) {
		foreach ( $this->_sections as $key => $section ) {
			?>
			<div class="xts-section <?php echo ( $this->get_last_tab() !== $key ) ? 'xts-hidden' : 'xts-active-section'; ?>" data-id="<?php echo esc_attr( $key ); ?>">
				<div class="xts-section-title">
					<?php if ( ! empty( $section['icon'] ) ) : ?>
						<div class="xts-title-icon <?php echo esc_html( $section['icon'] ); ?>"></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $section['name'] ); ?></h3>
				</div>
				<div class="xts-fields">
					<?php

					$tabs = array();
					foreach ( $section['fields'] as $field ) {
						if ( isset( $field->args['t_tab'] ) ) {
							$tabs[ $field->args['t_tab']['id'] ][ $field->args['t_tab']['tab'] ] = array(
								'icon'  => isset( $field->args['t_tab']['icon'] ) ? $field->args['t_tab']['icon'] : '',
								'title' => $field->args['t_tab']['tab'],
							);
						}
					}

					$printed_tabs  = false;
					$printed_tab   = false;
					$printed_group = false;

					if ( isset( $section['fields'] ) ) {
						foreach ( $section['fields'] as $field ) {
							if ( $printed_tab && ( ! isset( $field->args['t_tab'] ) || $printed_tab !== $field->args['t_tab']['tab'] ) ) {
								echo '</div>';
								$printed_tab = false;
							}

							if ( $printed_tabs && ( ! isset( $field->args['t_tab'] ) || $printed_tabs !== $field->args['t_tab']['id'] ) ) {
								echo '</div>';
								echo '</div>';
								$printed_tabs = false;
							}

							if ( $printed_group && ( ! isset( $field->args['group'] ) || $printed_group !== $field->args['group'] ) ) {
								echo '</div>';
								$printed_group = false;
							}

							if ( isset( $field->args['group'] ) && $printed_group !== $field->args['group'] ) {
								$printed_group = $field->args['group'];
								echo '<div class="xts-group-title"><span>' . esc_html( $printed_group ) . '</span></div>';
								echo '<div class="xts-fields-group xts-group">';
							}

							if ( isset( $field->args['t_tab'] ) && $printed_tabs !== $field->args['t_tab']['id'] ) {
								$attrs = '';

								if ( isset( $field->args['t_tab']['requires'] ) ) {
									$data = '';
									foreach ( $field->args['t_tab']['requires'] as $dependency ) {
										if ( is_array( $dependency['value'] ) ) {
											$dependency['value'] = implode( ',', $dependency['value'] );
										}
										$data .= $dependency['key'] . ':' . $dependency['compare'] . ':' . $dependency['value'] . ';';
									}

									$attrs .= 'data-dependency="' . esc_attr( $data ) . '"';
								}

								echo '<div class="wd-tabs xts-tabs wd-style-' . $field->args['t_tab']['style'] . '" ' . $attrs . '>';

								echo '<div class="xts-tabs-header">';
								if ( isset( $field->args['t_tab']['title'] ) ) {
									echo '<h3>' . $field->args['t_tab']['title'] . '</h3>';
								}
								echo '<div class="wd-nav-wrapper wd-nav-tabs-wrapper xts-nav-wrapper xts-nav-tabs-wrapper">';
								echo '<ul class="wd-nav wd-nav-tabs xts-nav xts-nav-tabs">';
								foreach ( $tabs[ $field->args['t_tab']['id'] ] as $tab ) {
									$classes = '';

									if ( ! empty( $tab['icon'] ) ) {
										$classes .= ' ' . $tab['icon'];
									}
									echo '<li><a href="#" class="wd-nav-link xts-nav-link' . $classes . '" title="' . $tab['title'] . '"><span class="nav-link-text wd-tabs-title xts-tabs-title">' . $tab['title'] . '</span></a></li>'; // phpcs:ignore
								}
								echo '</ul>';
								echo '</div>';
								echo '</div>';

								echo '<div class="wd-tab-content-wrapper xts-tab-content-wrapper xts-group">';

								$printed_tabs = $field->args['t_tab']['id'];
							}

							if ( isset( $field->args['t_tab'] ) && $printed_tab !== $field->args['t_tab']['tab'] ) {
								echo '<div class="wd-tab-content xts-tab-content">';

								$printed_tab = $field->args['t_tab']['tab'];
							}

							$field->render( $object );
						}

						if ( $printed_tab ) {
							echo '</div>';
							$printed_tab = false;
						}

						if ( $printed_tabs ) {
							echo '</div>';
							echo '</div>';
							$printed_tabs = false;
						}

						if ( $printed_group ) {
							echo '</div>';
							$printed_group = false;
						}
					}
					?>
				</div>
			</div>
			<?php
		}

	}

	/**
	 * Save all fields to the metadata database table for posts.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post id.
	 * @return bool
	 */
	public function save_posts_fields( $post_id ) {
		if ( ! isset( $_POST[ $this->nonce() ] ) || ! wp_verify_nonce( $_POST[ $this->nonce() ], $this->nonce() ) ) {
			return;
		}

		foreach ( $this->_fields as $key => $field ) {
			if ( 'checkbox' === $field->args['type'] && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_metadata(
					'post',
					$post_id,
					$field->get_input_name()
				);

				continue;
			}

			if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
				continue;
			}

			$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore

			do_action( 'woodmart_metabox_before_update_metadata', $post_id, $field->get_input_name(), $value );

			update_metadata(
				'post',
				$post_id,
				$field->get_input_name(),
				$value
			);
		}
	}

	/**
	 * Save all fields to the metadata database table for terms.
	 *
	 * @since 1.0.0
	 *
	 * @param int $term_id Term id.
	 */
	public function save_terms_fields( $term_id ) {
		foreach ( $this->_fields as $key => $field ) {
			if ( 'checkbox' === $field->args['type'] && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_metadata(
					'term',
					$term_id,
					$field->get_input_name()
				);
			} elseif ( 'group' === $field->args['type'] && ! empty( $field->inner_fields ) ) {
				foreach ( $field->inner_fields as $inner_field ) {
					if ( ! array_key_exists( $inner_field->get_input_name(), $_POST ) ) { // phpcs:ignore
						delete_metadata( 'term', $term_id, $inner_field->get_input_name() );
					} else {
						$this->save_terms_field( $inner_field, $term_id );
					}
				}
			} else {
				$this->save_terms_field( $field, $term_id );
			}
		}

		$storage = new Styles_Storage( 'term-' . $term_id, 'term', $term_id );
		$storage->delete_file();
		$storage->reset_data();
	}

	/**
	 * Save field to the metadata database table for terms.
	 *
	 * @since 1.0.0
	 *
	 * @param object $field Field object.
	 * @param int    $term_id Term id.
	 */
	private function save_terms_field( $field, $term_id ) {
		if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
			return;
		}

		$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore

		update_metadata(
			'term',
			$term_id,
			$field->get_input_name(),
			$value
		);
	}

	/**
	 * Save all fields to the metadata database table for terms.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $comment_id Comment id.
	 */
	public function save_comments_fields( $comment_id ) {
		foreach ( $this->_fields as $key => $field ) {
			if ( ( 'checkbox' === $field->args['type'] || 'select' === $field->args['type'] ) && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_comment_meta(
					$comment_id,
					$field->get_input_name()
				);

				continue;
			}

			if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
				continue;
			}

			$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore

			update_comment_meta(
				$comment_id,
				$field->get_input_name(),
				$value
			);
		}
	}

	/**
	 * Get css in metaboxes controls.
	 *
	 * @param integer $id Term or post ID.
	 * @param string  $type Type post.
	 * @return array|string|string[]
	 */
	public function build_fields_css( $id, $type ) {
		if ( 'term' === $type ) {
			$object = get_term( $id );
		} else {
			$object = get_post( $id );
		}

		$terms_css = $this->fields_css_output( $object );

		if ( $terms_css ) {
			if ( ! empty( $this->_args['css_selector'] ) ) {
				$selector_css = str_replace( '{{ID}}', $id, $this->_args['css_selector'] );

				$terms_css = str_replace( '{{WRAPPER}}', $selector_css, $terms_css );
			}
		}

		return $terms_css;
	}
}
