/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdUpdateWishlist wdRecentlyViewedProductLoaded wdShopPageInit', function() {
		woodmartThemeModule.productsLoadMore();
	});

	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default',
		'frontend/element_ready/wd_archive_products.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productsLoadMore();
		});
	});

	woodmartThemeModule.productsLoadMore = function() {
		var process = false,
		    intervalID;

		$('.wd-products-element').each(function() {
			var $this = $(this),
			    cache = [],
			    inner = $this.find('.wd-products'),
			    btnWrap = $this.find('.wd-ajax-arrows');

			if ( btnWrap.hasClass('wd-pos-sep') ) {
				var btnLeft = btnWrap.find('.wd-btn-arrow.wd-prev'),
					scrollTop,
					holderTop,
					holderBottom,
					holderHeight,
					btnsHeight,
					offset;

				woodmartThemeModule.$window.on('scroll', function() {
					buttonsPos();
				});

				setTimeout(function() {
					buttonsPos();
				}, 500);

				function buttonsPos() {
					offset = woodmartThemeModule.$window.height() / 2;
					scrollTop = woodmartThemeModule.$window.scrollTop();
					holderTop = $this.offset().top - offset;
					btnsHeight = btnLeft.outerHeight();
					holderHeight = $this.height() - btnsHeight;
					holderBottom = holderTop + holderHeight;

					if (scrollTop < holderTop || scrollTop > holderBottom) {
						btnWrap.removeClass('wd-shown');
					} else {
						btnWrap.addClass('wd-shown');
					}
				}
			}

			if (!inner.hasClass('pagination-arrows')) {
				return;
			}

			cache[parseInt(inner.data('paged'))] = {
				items : inner.html(),
				status: 'have-posts'
			};

			$this.find('.wd-ajax-arrows .wd-btn-arrow.wd-prev, .wd-ajax-arrows .wd-btn-arrow.wd-next').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);

				if (process || $this.hasClass('wd-disabled')) {
					return;
				}

				process = true;

				clearInterval(intervalID);

				var holder   = $this.parent().prev(),
				    next     = $this.parent().find('.wd-btn-arrow.wd-next'),
				    prev     = $this.parent().find('.wd-btn-arrow.wd-prev'),
				    atts     = holder.data('atts'),
				    action   = 'woodmart_get_products_shortcode',
				    ajaxurl  = woodmart_settings.ajaxurl,
				    dataType = 'json',
				    method   = 'POST',
				    paged    = holder.attr('data-paged');

				paged++;

				if ($this.hasClass('wd-prev')) {
					if (paged < 2) {
						return;
					}

					paged = paged - 2;
				}

				loadProducts('arrows', atts, ajaxurl, action, dataType, method, paged, holder, $this, cache, function(data) {
					var isBorderedGrid = holder.hasClass('products-bordered-grid') || holder.hasClass('products-bordered-grid-ins');

					holder.siblings('.wd-sticky-loader').removeClass('wd-loading');

					if (!isBorderedGrid) {
						holder.addClass('wd-animated-products');
					}

					if (data.items.length) {
						holder.html(data.items).attr('data-paged', paged);
						holder.imagesLoaded().progress(function() {
							holder.parent().trigger('recalc');
						});

						woodmartThemeModule.$document.trigger('wood-images-loaded');
						woodmartThemeModule.$document.trigger('wdArrowsLoadProducts');
					}

					if (woodmartThemeModule.$window.width() < 768) {
						$('html, body').stop().animate({
							scrollTop: holder.offset().top - 150
						}, 400);
					}

					if (!isBorderedGrid) {
						var iter = 0;

						intervalID = setInterval(function() {
							holder.find('.wd-product').eq(iter).addClass('wd-animated');
							iter++;
						}, 100);
					}

					if (paged > 1) {
						prev.removeClass('wd-disabled');
					} else {
						prev.addClass('wd-disabled');
					}

					if (data.status === 'no-more-posts') {
						next.addClass('wd-disabled');
					} else {
						next.removeClass('wd-disabled');
					}
				});
			});
		});

		woodmartThemeModule.clickOnScrollButton(woodmartThemeModule.shopLoadMoreBtn, false, woodmart_settings.infinit_scroll_offset);

		woodmartThemeModule.$document.off('click', '.wd-products-load-more').on('click', '.wd-products-load-more', function(e) {
			e.preventDefault();

			if (process) {
				return;
			}

			process = true;

			var $this    = $(this),
			    holder   = $this.parents('.wd-products-element').find('.wd-products'),
			    source   = holder.data('source'),
			    action   = 'woodmart_get_products_' + source,
			    ajaxurl  = woodmart_settings.ajaxurl,
			    dataType = 'json',
			    method   = 'POST',
			    atts     = holder.data('atts'),
			    paged    = holder.data('paged');

			paged++;

			if (source === 'main_loop') {
				ajaxurl = $(this).attr('href');
				method = 'GET';
			}

			loadProducts('load-more', atts, ajaxurl, action, dataType, method, paged, holder, $this, [], function(data) {
				if (data.items.length) {
					if (holder.hasClass('grid-masonry')) {
						isotopeAppend(holder, data.items);
					} else {
						holder.append(data.items);
					}

					if (data.status !== 'no-more-posts') {
						holder.imagesLoaded().progress(function() {
							woodmartThemeModule.clickOnScrollButton(woodmartThemeModule.shopLoadMoreBtn, true, woodmart_settings.infinit_scroll_offset);
						});
					}

					woodmartThemeModule.$document.trigger('wood-images-loaded');
					woodmartThemeModule.$document.trigger('wdLoadMoreLoadProducts');

					holder.data('paged', paged);
				}

				if (source === 'main_loop') {
					$this.attr('href', data.nextPage);

					if (data.status === 'no-more-posts') {
						$this.hide().remove();
					}
				}

				if (data.status === 'no-more-posts') {
					$this.hide();
				}
			});
		});

		var loadProducts = function(btnType, atts, ajaxurl, action, dataType, method, paged, holder, btn, cache, callback) {
			var data = {
				atts    : atts,
				paged   : paged,
				action  : action,
				woo_ajax: 1
			};

			if (method === 'GET') {
				ajaxurl = woodmartThemeModule.removeURLParameter(ajaxurl, 'loop');
				ajaxurl = woodmartThemeModule.removeURLParameter(ajaxurl, 'woo_ajax');
			}

			if (cache[paged]) {
				holder.addClass('wd-loading');

				setTimeout(function() {
					callback(cache[paged]);
					holder.removeClass('wd-loading');
					process = false;
				}, 300);

				return;
			}

			if (btnType === 'arrows') {
				holder.addClass('wd-loading').parent().addClass('wd-loading');

				holder.siblings('.wd-sticky-loader').addClass('wd-loading');
			}

			btn.addClass('loading');

			if (action === 'woodmart_get_products_main_loop') {
				var loop = holder.find('.product').last().data('loop');
				data = {
					loop    : loop,
					woo_ajax: 1,
					atts    : atts,
				};
			}

			$.ajax({
				url     : ajaxurl,
				data    : data,
				dataType: dataType,
				method  : method,
				success : function(data) {
					woodmartThemeModule.removeDuplicatedStylesFromHTML(data.items, function(html) {
						var $resultCount = $('.woocommerce-result-count');
						data.items       = html;
						cache[paged]     = data;
						callback(data);

						if ('yes' === woodmart_settings.load_more_button_page_url_opt && 'no' !== woodmart_settings.load_more_button_page_url && data.currentPage){
							window.history.pushState('', '', data.currentPage + window.location.search);
							$('.woocommerce-breadcrumb').replaceWith(data.breadcrumbs);
						}

						if ( $resultCount.length > 0 && data.hasOwnProperty('resultCount') ) {
							$resultCount.replaceWith(data.resultCount);
						}
					});
				},
				error   : function() {
					console.log('ajax error');
				},
				complete: function() {
					if (btnType === 'arrows') {
						holder.removeClass('wd-loading').parent().removeClass('wd-loading');
					}

					btn.removeClass('loading');
					process = false;
				}
			});
		};

		var isotopeAppend = function(el, items) {
			var $items = $(items);
			el.append($items).isotope('appended', $items);
			el.imagesLoaded().progress(function() {
				el.isotope('layout');
			});
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.productsLoadMore();
	});
})(jQuery);
