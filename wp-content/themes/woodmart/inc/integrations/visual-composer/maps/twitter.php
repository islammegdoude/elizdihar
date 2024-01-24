<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Twitter element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_twitter' ) ) {
	function woodmart_get_vc_map_twitter() {
		return array(
			'name' => esc_html__( 'X (Twitter)', 'woodmart' ),
			'base' => 'woodmart_twitter',
			'category' => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Shows posts from any X account', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/twitter.svg',
			'params' => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),
				/**
				 * Widget settings
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Widget settings', 'woodmart' ),
					'param_name' => 'widget_divider',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'X Name (without @ symbol)', 'woodmart' ),
					'param_name' => 'name',
					'value' => 'x',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of posts', 'woodmart' ),
					'param_name' => 'num_tweets',
					'value' => 5,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Size of Avatar', 'woodmart' ),
					'param_name' => 'avatar_size',
					'hint' => esc_html__( 'Default: 48px', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'woodmart_switch',
					'heading' => esc_html__( 'Show your avatar image', 'woodmart' ),
					'param_name' => 'show_avatar',
					'true_state' => 1,
					'false_state' => 0,
					'default' => 0,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'woodmart_switch',
					'heading' => esc_html__( 'Exclude Replies', 'woodmart' ),
					'param_name' => 'exclude_replies',
					'true_state' => 1,
					'false_state' => 0,
					'default' => 0,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Access settings
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Access settings', 'woodmart' ),
					'param_name' => 'access_divider',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Key', 'woodmart' ),
					'param_name' => 'consumer_key',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Secret', 'woodmart' ),
					'param_name' => 'consumer_secret',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token', 'woodmart' ),
					'param_name' => 'access_token',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token Secret', 'woodmart' ),
					'param_name' => 'accesstoken_secret',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Extra
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),
			)
		);
	}
}
