<?php
/**
 * Admin setting page template.
 *
 * @var array $args Arguments for render template.
 * @var array $current_args Arguments from databased.
 * @var string $max_priority Max saved priority.
 * @package Woodmart
 */

use XTS\Modules\Dynamic_Discounts\Admin;

$discount_rules              = ! empty( $current_args['discount_rules'] ) ? $current_args['discount_rules'] : $args['discount_rules'];
$discount_condition          = ! empty( $current_args['discount_condition'] ) ? $current_args['discount_condition'] : $args['discount_condition'];
$selected_discount_condition = array();
?>

<div class="xts-box xts-options xts-metaboxes xts-theme-style">
	<?php wp_nonce_field( 'save_wd_woo_discounts', 'xts_woo_discounts_meta_boxes_nonce' ); ?>

	<div class="xts-box-content">
		<div class="xts-row xts-sp-20">
			<div class="xts-col">
				<div class="xts-section xts-active-section" data-id="general">
					<div class="xts-fields">
						<div class="xts-field xts-settings-field xts-_woodmart_rule_type-field <?php echo count( $args['_woodmart_rule_type'] ) <= 1 ? 'xts-hidden' : ''; ?>">
							<div class="xts-option-title">
								<label for="_woodmart_rule_type">
									<?php echo esc_html__( 'Rule type', 'woodmart' ); ?>
								</label>
							</div>
							<div class="xts-option-control">
								<select id="_woodmart_rule_type" class="xts-select" name="_woodmart_rule_type" aria-label="<?php esc_attr_e( 'Rule type', 'woodmart' ); ?>">
									<?php foreach ( $args['_woodmart_rule_type'] as $key => $label ) : ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['_woodmart_rule_type'] ) ? selected( $current_args['_woodmart_rule_type'], $key ) : ''; ?>>
											<?php echo esc_html( $label ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="xts-field xts-settings-field xts-woodmart_discount_priority-field xts-col-6">
							<div class="xts-option-title">
								<label for="woodmart_discount_priority">
									<?php echo esc_html__( 'Priority', 'woodmart' ); ?>
								</label>
							</div>
							<div class="xts-option-control">
								<input type="number" name="woodmart_discount_priority" id="woodmart_discount_priority" class="xts-col-6" min="1" placeholder="<?php esc_attr_e( 'Priority', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount priority', 'woodmart' ); ?>" value="<?php echo ! empty( $current_args['woodmart_discount_priority'] ) ? esc_attr( $current_args['woodmart_discount_priority'] ) : esc_attr( (int) $max_priority + 1 ); ?>">
							</div>
							<p class="xts-field-description">
								<?php esc_html_e( 'Set priority for current discount rules. This will be useful if several rules apply to one product.', 'woodmart' ); ?>
							</p>
						</div>

						<div class="xts-field xts-settings-field xts-discount_quantities-field xts-col-6 <?php echo count( $args['discount_quantities'] ) <= 1 ? 'xts-hidden' : ''; ?>">
							<div class="xts-option-title">
								<label for="discount_quantities">
									<?php echo esc_html__( 'Quantities', 'woodmart' ); ?>
								</label>
							</div>
							<div class="xts-option-control">
								<select id="discount_quantities" class="xts-select" name="discount_quantities" aria-label="<?php esc_attr_e( 'Quantities', 'woodmart' ); ?>">
									<?php foreach ( $args['discount_quantities'] as $key => $label ) : ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['discount_quantities'] ) ? selected( $current_args['discount_quantities'], $key ) : ''; ?>>
											<?php echo esc_html( $label ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<p class="xts-field-description">
								<?php esc_html_e( 'Choose "Individual variation" to have variations of a variable product count as an individual product.', 'woodmart' ); ?>
							</p>
						</div>

						<div class="xts-group-title">
							<span>
								<?php echo esc_html__( 'Discount rules', 'woodmart' ); ?>
							</span>
						</div>
						<div class="xts-fields-group xts-group">

							<div class="xts-field xts-settings-field xts-select_with_table-control xts-_woodmart_discount_rules-field" data-dependency="_woodmart_rule_type:equals:bulk;">
								<div class="xts-option-control">
									<div class="xts-item-template xts-hidden">
										<div class="xts-table-controls xts-discount">
											<div class="xts-discount-from">
												<input type="number" name="discount_rules[{{index}}][_woodmart_discount_rules_from]" id="_woodmart_discount_rules_from_{{index}}" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'From', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules from', 'woodmart' ); ?>" disabled>
											</div>
											<div class="xts-discount-to">
												<input type="number" name="discount_rules[{{index}}][_woodmart_discount_rules_to]" id="_woodmart_discount_rules_to_{{index}}" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'To', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules to', 'woodmart' ); ?>" disabled>
											</div>
											<div class="xts-discount-type">
												<select id="_woodmart_discount_type_{{index}}" class="xts-select" name="discount_rules[{{index}}][_woodmart_discount_type]" aria-label="<?php esc_attr_e( 'Discount type', 'woodmart' ); ?>" disabled>
													<?php foreach ( $args['discount_rules'][0]['_woodmart_discount_type'] as $key => $label ) : ?>
														<option value="<?php echo esc_attr( $key ); ?>">
															<?php echo esc_html( $label ); ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="xts-discount-amount-value">
												<div class="xts-option-control">
													<input type="number" name="discount_rules[{{index}}][_woodmart_discount_amount_value]" id="_woodmart_discount_amount_value_{{index}}" class="xts-col-6" min="0" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount amount value', 'woodmart' ); ?>" disabled>
												</div>
											</div>
											<div class="xts-discount-percentage-value xts-hidden">
												<div class="xts-option-control">
													<input type="number" name="discount_rules[{{index}}][_woodmart_discount_percentage_value]" id="_woodmart_discount_percentage_value_{{index}}" class="xts-col-6" min="0" max="100" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount percentage value', 'woodmart' ); ?>" disabled>
												</div>
											</div>
											<div class="xts-discount-close">
												<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
											</div>
										</div>
									</div>
									<div class="xts-controls-wrapper">
										<div class="xts-table-controls xts-discount title">
											<div class="xts-discount-from">
												<label><?php echo esc_html__( 'From', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-to">
												<label><?php echo esc_html__( 'To', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-type">
												<label><?php echo esc_html__( 'Type', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-value">
												<label><?php echo esc_html__( 'Value', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-remove"></div>
										</div>
										<?php foreach ( $discount_rules as $id => $rule_args ) : //phpcs:ignore. ?>
											<div class="xts-table-controls xts-discount">
												<div class="xts-discount-from">
													<input type="number" name="discount_rules[<?php echo esc_attr( $id ); ?>][_woodmart_discount_rules_from]" id="_woodmart_discount_rules_from_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'From', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules from', 'woodmart' ); ?>" value="<?php echo isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_rules_from'] ) ? esc_attr( $current_args['discount_rules'][ $id ]['_woodmart_discount_rules_from'] ) : ''; ?>">
												</div>
												<div class="xts-discount-to">
													<input type="number" name="discount_rules[<?php echo esc_attr( $id ); ?>][_woodmart_discount_rules_to]" id="_woodmart_discount_rules_to_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'To', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules to', 'woodmart' ); ?>" value="<?php echo isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_rules_to'] ) ? esc_attr( $current_args['discount_rules'][ $id ]['_woodmart_discount_rules_to'] ) : ''; ?>">
												</div>
												<div class="xts-discount-type">
													<select id="_woodmart_discount_type_<?php echo esc_attr( $id ); ?>" class="xts-select" name="discount_rules[<?php echo esc_attr( $id ); ?>][_woodmart_discount_type]" aria-label="<?php esc_attr_e( 'Discount type', 'woodmart' ); ?>">
														<?php foreach ( $args['discount_rules'][0]['_woodmart_discount_type'] as $key => $label ) : ?>
															<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_type'] ) ? selected( $current_args['discount_rules'][ $id ]['_woodmart_discount_type'], $key, false ) : ''; ?>>
																<?php echo esc_html( $label ); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="xts-discount-amount-value <?php echo isset( $current_args['discount_rules'][ $id ] ) && isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_type'] ) && 'amount' === $current_args['discount_rules'][ $id ]['_woodmart_discount_type'] || ! isset( $current_args['discount_rules'][ $id ] ) ? '' : 'xts-hidden'; ?>">
													<div class="xts-option-control">
														<input type="number" name="discount_rules[<?php echo esc_attr( $id ); ?>][_woodmart_discount_amount_value]" id="_woodmart_discount_amount_value_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount amount value', 'woodmart' ); ?>" value="<?php echo isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_amount_value'] ) ? esc_attr( $current_args['discount_rules'][ $id ]['_woodmart_discount_amount_value'] ) : ''; ?>">
													</div>
												</div>
												<div class="xts-discount-percentage-value <?php echo isset( $current_args['discount_rules'][ $id ] ) && isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_type'] ) && 'percentage' === $current_args['discount_rules'][ $id ]['_woodmart_discount_type'] ? '' : 'xts-hidden'; ?>">
													<div class="xts-option-control">
														<input type="number" name="discount_rules[<?php echo esc_attr( $id ); ?>][_woodmart_discount_percentage_value]" id="_woodmart_discount_percentage_value_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" max="100" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount percentage value', 'woodmart' ); ?>" value="<?php echo isset( $current_args['discount_rules'][ $id ]['_woodmart_discount_percentage_value'] ) ? esc_attr( $current_args['discount_rules'][ $id ]['_woodmart_discount_percentage_value'] ) : ''; ?>">
													</div>
												</div>
												<div class="xts-discount-close">
													<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<a href="#" class="xts-add-row xts-inline-btn xts-color-primary xts-i-add">
										<?php esc_html_e( 'Add new rule', 'woodmart' ); ?>
									</a>
								</div>
							</div>
						</div>

						<div class="xts-group-title">
							<span>
								<?php echo esc_html__( 'Discount condition', 'woodmart' ); ?>
							</span>
						</div>
						<div class="xts-fields-group xts-group">
							<div class="xts-field xts-settings-field xts-select_with_table-control xts-_woodmart_discount_condition-field">
								<div class="xts-option-control">
									<div class="xts-item-template xts-hidden">
										<div class="xts-table-controls xts-discount">
											<div class="xts-discount-comparison-condition">
												<select class="xts-discount-comparison-condition" name="discount_condition[{{index}}][comparison]" aria-label="<?php esc_attr_e( 'Comparison condition', 'woodmart' ); ?>" disabled>
													<?php foreach ( $args['discount_condition'][0]['comparison'] as $key => $label ) : ?>
														<option value="<?php echo esc_attr( $key ); ?>">
															<?php echo esc_html( $label ); ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="xts-discount-condition-type">
												<select class="xts-discount-condition-type" name="discount_condition[{{index}}][type]" aria-label="<?php esc_attr_e( 'Condition type', 'woodmart' ); ?>" disabled>
													<?php foreach ( $args['discount_condition'][0]['type'] as $key => $label ) : ?>
														<option value="<?php echo esc_attr( $key ); ?>">
															<?php echo esc_html( $label ); ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="xts-discount-condition-query xts-hidden">
												<select class="xts-discount-condition-query" name="discount_condition[{{index}}][query]" placeholder="<?php esc_attr_e( 'Start typing...', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Condition query', 'woodmart' ); ?>" disabled></select>
											</div>
											<div class="xts-discount-product-type-condition-query xts-hidden">
												<select class="xts-discount-product-type-condition-query" name="discount_condition[{{index}}][product-type-query]" aria-label="<?php esc_attr_e( 'Product type condition query', 'woodmart' ); ?>" disabled>
													<?php foreach ( $args['discount_condition'][0]['product-type-query'] as $key => $label ) : ?>
														<option value="<?php echo esc_attr( $key ); ?>">
															<?php echo esc_html( $label ); ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>

											<div class="xts-discount-close">
												<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
											</div>
										</div>
									</div>

									<div class="xts-controls-wrapper">
										<div class="xts-table-controls xts-discount title">
											<div class="xts-discount-comparison-condition">
												<label><?php esc_html_e( 'Comparison condition', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-condition-type">
												<label><?php esc_html_e( 'Condition type', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-condition-query <?php echo empty( $selected_discount_condition ) ? 'xts-hidden' : ''; ?>">
												<label><?php esc_html_e( 'Condition query', 'woodmart' ); ?></label>
											</div>
											<div class="xts-discount-remove"></div>
										</div>
				                        <?php foreach ( $discount_condition as $id => $condition_args ) : //phpcs:ignore. ?>
											<?php
											if ( ! empty( $current_args['discount_condition'][ $id ]['query'] ) && ! empty( $current_args['discount_condition'][ $id ]['type'] ) ) {
												$selected_discount_condition = Admin::get_instance()->get_saved_conditions_query( $current_args['discount_condition'][ $id ]['query'], $current_args['discount_condition'][ $id ]['type'] );
											}
											?>

											<div class="xts-table-controls xts-discount">
												<div class="xts-discount-comparison-condition">
													<select class="xts-discount-comparison-condition" name="discount_condition[<?php echo esc_attr( $id ); ?>][comparison]" aria-label="<?php esc_attr_e( 'Comparison condition', 'woodmart' ); ?>">
														<?php foreach ( $args['discount_condition'][0]['comparison'] as $key => $label ) : ?>
															<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['discount_condition'][ $id ]['comparison'] ) ? selected( $current_args['discount_condition'][ $id ]['comparison'], $key, false ) : ''; ?>>
																<?php echo esc_html( $label ); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="xts-discount-condition-type">
													<select class="xts-discount-condition-type" name="discount_condition[<?php echo esc_attr( $id ); ?>][type]" aria-label="<?php esc_attr_e( 'Condition type', 'woodmart' ); ?>">
														<?php foreach ( $args['discount_condition'][0]['type'] as $key => $label ) : ?>
															<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['discount_condition'][ $id ]['type'] ) ? selected( $current_args['discount_condition'][ $id ]['type'], $key, false ) : ''; ?>>
																<?php echo esc_html( $label ); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="xts-discount-condition-query <?php echo empty( $selected_discount_condition ) ? 'xts-hidden' : ''; ?>">
													<select class="xts-discount-condition-query" name="discount_condition[<?php echo esc_attr( $id ); ?>][query]" placeholder="<?php echo esc_attr__( 'Start typing...', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Condition query', 'woodmart' ); ?>">
														<?php if ( ! empty( $selected_discount_condition ) ) : ?>
															<option value="<?php echo esc_attr( $selected_discount_condition['id'] ); ?>" selected>
																<?php echo esc_html( $selected_discount_condition['text'] ); ?>
															</option>
														<?php endif; ?>
													</select>
												</div>
												<div class="xts-discount-product-type-condition-query <?php echo isset( $current_args['discount_condition'][ $id ] ) && ( 'product_type' !== $current_args['discount_condition'][ $id ]['type'] || ! isset( $current_args['discount_condition'][ $id ]['product-type-query'] ) ) || ! isset( $current_args['discount_condition'][ $id ] ) ? 'xts-hidden' : ''; ?>">
													<select class="xts-discount-product-type-condition-query" name="discount_condition[<?php echo esc_attr( $id ); ?>][product-type-query]" aria-label="<?php esc_attr_e( 'Product type condition query', 'woodmart' ); ?>">
														<?php foreach ( $args['discount_condition'][0]['product-type-query'] as $key => $label ) : ?>
															<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $current_args['discount_condition'][ $id ]['product-type-query'] ) ? selected( $current_args['discount_condition'][ $id ]['product-type-query'], $key, false ) : ''; ?>>
																<?php echo esc_html( $label ); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>

												<div class="xts-discount-close">
													<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<a href="#" class="xts-add-row xts-inline-btn xts-color-primary xts-i-add">
										<?php esc_html_e( 'Add new condition', 'woodmart' ); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
