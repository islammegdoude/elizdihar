/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_products_tabs.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productsTabs();
		});
	});

	woodmartThemeModule.productsTabs = function() {
		var process = false;

		$('.wd-products-tabs').each(function() {
			var $this  = $(this);
			var $inner = $this.find('.wd-tab-content-wrapper');
			var cache  = [];
			var $cloneContent = $inner.find('.wd-products-element').clone().removeClass('wd-active wd-in');

			cache[0] = {
				html: $cloneContent.prop('outerHTML')
			};

			$this.find('.products-tabs-title li').on('click', function(e) {
				e.preventDefault();

				var $this = $(this),
				    atts  = $this.data('atts'),
				    index = $this.index();

				if (process || $this.hasClass('wd-active')) {
					return;
				}
				process = true;

				$inner.find('.wd-products-element').removeClass('wd-in');

				setTimeout(function() {
					$inner.find('.wd-products-element').addClass('wd-active');
				}, 100);

				loadTab(atts, index, $inner, $this, cache, function(data) {
					if (data.html) {
						woodmartThemeModule.removeDuplicatedStylesFromHTML(data.html, function(html) {
							$inner.find('.wd-products-element').replaceWith(html);

							$inner.find('.wd-products-element').addClass('wd-active');

							setTimeout(function() {
								$inner.find('.wd-products-element').addClass('wd-in');

								woodmartThemeModule.$document.trigger('wdProductsTabsLoaded');
								woodmartThemeModule.$document.trigger('wood-images-loaded');
							}, 200);

							$this.removeClass('loading');
						});
					}
				});
			});

			setTimeout(function() {
				$this.addClass( 'wd-inited' );
			}, 200);
		});

		var loadTab = function(atts, index, holder, btn, cache, callback) {
			var $loader = holder.find('> .wd-sticky-loader');
			btn.parent().find('.wd-active').removeClass('wd-active');
			btn.addClass('wd-active');

			if (cache[index]) {
				setTimeout(function() {
					process = false;
					callback(cache[index]);
				}, 300);
				return;
			}

			$loader.addClass('wd-loading');
			btn.addClass('loading');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					atts  : atts,
					action: 'woodmart_get_products_tab_shortcode'
				},
				dataType: 'json',
				method  : 'POST',
				success : function(data) {
					process = false;
					cache[index] = data;
					callback(data);
				},
				error   : function() {
					console.log('ajax error');
				},
				complete: function() {
					process = false;
					$loader.removeClass('wd-loading');
				}
			});
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.productsTabs();
	});
})(jQuery);
