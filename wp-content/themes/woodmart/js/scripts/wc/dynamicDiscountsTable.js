(function ($) {
	$.each([
		'frontend/element_ready/wd_dynamic_discounts_table.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.renderDynamicDiscountsTable();
		});
	});

    woodmartThemeModule.renderDynamicDiscountsTable = function () {
        let $variation_forms = $('.variations_form');
        let $dynamicDiscountsTable = $('.wd-dynamic-discounts');
        let default_price_table = $dynamicDiscountsTable.html();

        function reInitPricingTableRowsClick() {
            $('.wd-dynamic-discounts tbody tr').each(function () {
                let $row = $(this);

                let min = $row.data('min');

                $row.off('click').on('click', function() {
                    let $quantityInput = $('.quantity input.qty[name="quantity"]');

                    $quantityInput.val(min).trigger('change');
                });
            });
        }

        function addActiveClassToTable( $pricing_table, currentQuantityValue ) {
            $pricing_table.find('tbody tr').each(function () {
                let $row = $(this);
                let min  = $row.data('min');
                let max  = $row.data('max');

                if ( ( ! max && min <= currentQuantityValue ) || ( min <= currentQuantityValue && currentQuantityValue <= max ) ) {
                    $row.addClass('wd-active');
                } else {
                    $row.removeClass('wd-active');
                }
            });
        }

        $variation_forms.each(function () {
            let $variation_form = $(this);

            $variation_form
                .on('found_variation', function (event, variation) {
                    $.ajax({
                        url     : woodmart_settings.ajaxurl,
                        data    : {
                            action : 'woodmart_update_discount_dynamic_discounts_table',
                            variation_id: variation.variation_id,
                        },
						beforeSend: function () {
							$dynamicDiscountsTable.find('.wd-loader-overlay').addClass('wd-loading');
						},
                        success : ( data ) => {
                            $dynamicDiscountsTable.html( data );
                            reInitPricingTableRowsClick();

                            addActiveClassToTable( $('.wd-dynamic-discounts'), $(this).find('[name="quantity"]').val() );
							$dynamicDiscountsTable.find('.wd-loader-overlay').removeClass('wd-loading');
                        },
                        dataType: 'json',
                        method  : 'GET'
                    });
                })
                .on('click', '.reset_variations', function () {
                    $dynamicDiscountsTable.html(default_price_table);
                    reInitPricingTableRowsClick();

                    addActiveClassToTable( $('.wd-dynamic-discounts'), $(this).closest('form').find('.quantity input.qty[name="quantity"]').val() );
                });
        });

        reInitPricingTableRowsClick();

        $('.quantity input.qty[name="quantity"]').off('change').on('change', function() {
            addActiveClassToTable( $dynamicDiscountsTable, $(this).val() );
        });
    }

    $(document).ready(() => {
        woodmartThemeModule.renderDynamicDiscountsTable();
    });
})(jQuery);
