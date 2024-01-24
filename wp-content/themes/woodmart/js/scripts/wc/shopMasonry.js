/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdShopPageInit wdRecentlyViewedProductLoaded', function () {
		woodmartThemeModule.shopMasonry();
	});

	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default',
		'frontend/element_ready/wd_products_brands.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.shopMasonry();
		});
	});

	woodmartThemeModule.shopMasonry = function() {
		if (typeof ($.fn.isotope) == 'undefined' || typeof ($.fn.packery) == 'undefined' || typeof ($.fn.imagesLoaded) == 'undefined') {
			return;
		}

		var $container = $('.wd-products.grid-masonry');
		$container.imagesLoaded(function() {
			$container.isotope({
				isOriginLeft: !woodmartThemeModule.$body.hasClass('rtl'),
				itemSelector: '.product-category.product, .wd-product, .wd-products > .element-title',
				masonry: {
					columnWidth: '.product-category.product, .wd-product'
				}
			});
		});

		woodmartThemeModule.$window.on('resize', function() {
			initMasonry();
		});

		initMasonry();

		function initMasonry() {
			var $catsContainer = $('.wd-cats-element .wd-masonry');
			$catsContainer.imagesLoaded(function() {
				$catsContainer.packery({
					resizable   : false,
					isOriginLeft: !woodmartThemeModule.$body.hasClass('rtl'),
					packery     : {
						gutter     : 0,
						columnWidth: '.product-category.product'
					},
					itemSelector: '.product-category.product'
				});
			});
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.shopMasonry();
	});
})(jQuery);
