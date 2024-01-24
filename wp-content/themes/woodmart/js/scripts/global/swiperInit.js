woodmartThemeModule.$document.on('wdInstagramAjaxSuccess wdLoadDropdownsSuccess wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdShopPageInit wdRecentlyViewedProductLoaded wdQuickViewOpen300', function() {
	woodmartThemeModule.swiperInit();
});

[
	'frontend/element_ready/wd_products.default',
	'frontend/element_ready/wd_products_tabs.default',
	'frontend/element_ready/wd_product_categories.default',
	'frontend/element_ready/wd_products_brands.default',
	'frontend/element_ready/wd_blog.default',
	'frontend/element_ready/wd_portfolio.default',
	'frontend/element_ready/wd_images_gallery.default',
	'frontend/element_ready/wd_product_categories.default',
	'frontend/element_ready/wd_banner_carousel.default',
	'frontend/element_ready/wd_infobox_carousel.default',
	'frontend/element_ready/wd_instagram.default',
	'frontend/element_ready/wd_testimonials.default',
	'frontend/element_ready/wd_nested_carousel.default'
].forEach( function (value) {
	woodmartThemeModule.wdElementorAddAction(value, function() {
		woodmartThemeModule.swiperInit();
	});
});

woodmartThemeModule.swiperInit = function() {
	if ('undefined' === typeof wdSwiper) {
		return;
	}

	document.querySelectorAll('.wd-carousel:not(.scroll-init)').forEach( function (carousel) {
		carouselInit(carousel);
	});

	if ('undefined' !== typeof window.Waypoint) {
		document.querySelectorAll('.wd-carousel.scroll-init').forEach( function (carousel) {
			new Waypoint({
				element: carousel,
				handler: function() {
					if (carousel.classList.contains('wd-initialized')) {
						this.destroy();
					}

					carouselInit(this.element);
				},
				offset: '100%'
			});
		});
	}

	function carouselInit(carousel, thumbs = false) {
		if (carousel.closest('.woocommerce-product-gallery') && ! carousel.classList.contains('quick-view-gallery') || ( ! thumbs && 'undefined' !== typeof carousel.dataset.sync_child_id && document.querySelector('.wd-carousel[data-sync_parent_id=' + carousel.dataset.sync_child_id + ']') ) ) {
			return;
		}

		var carouselWrapper = carousel.closest('.wd-carousel-container');
		var carouselStyle = window.getComputedStyle(carousel);

		if (woodmartThemeModule.windowWidth <= 1024 && carouselWrapper.classList.contains('wd-carousel-dis-mb') || carousel.classList.contains('wd-initialized') ) {
			return;
		}

		var mainSlidesPerView = carouselStyle.getPropertyValue('--wd-col');
		var breakpointsSettings = woodmart_settings.carousel_breakpoints;
		var breakpoints = {};
		var carouselItemsLength = carousel.querySelectorAll('.wd-carousel-item').length;

		Object.entries(breakpointsSettings).forEach(( [size, key] ) => {
			var slidesPerView = carouselStyle.getPropertyValue('--wd-col-' + key );
			var enableScrollPerGroup = 'undefined' !== typeof carousel.dataset.scroll_per_page && 'yes' === carousel.dataset.scroll_per_page;

			if ( ! slidesPerView ) {
				slidesPerView = mainSlidesPerView;
			}

			if ( slidesPerView ) {
				breakpoints[ size ] = {
					slidesPerView : slidesPerView ? slidesPerView : 1
				};

				if ( 'yes' === carousel.dataset.wrap && parseInt(slidesPerView, 10 ) * 2 > carouselItemsLength || 'yes' === carousel.dataset.center_mode) {
					enableScrollPerGroup = false;
				}

				if ( enableScrollPerGroup && slidesPerView ) {
					breakpoints[ size ]['slidesPerGroup'] = parseInt(slidesPerView);
				}

				// if ( 'yes' === carousel.dataset.wrap && 'yes' === carousel.dataset.center_mode ) {
				// 	// breakpoints[ size ]['loopAdditionalSlides'] = parseInt(parseInt( slidesPerView, 10 ) / 2, 10 );
				// 	breakpoints[ size ]['loopAdditionalSlides'] = 1;
				// }
			}
		});

		var config = {
			slidesPerView         : mainSlidesPerView,
			loop                  : 'yes' === carousel.dataset.wrap && ('yes' !== carousel.dataset.center_mode || parseInt( mainSlidesPerView, 10) + 1 < carouselItemsLength ),
			loopAddBlankSlides    : false,
			centeredSlides        : 'yes' === carousel.dataset.center_mode,
			autoHeight            : 'yes' === carousel.dataset.autoheight,
			grabCursor            : true,
			a11y                  : {
				enabled: false
			},
			breakpoints           : breakpoints,
			watchSlidesProgress   : true,
			slideClass            : 'wd-carousel-item',
			slideActiveClass      : 'wd-active',
			slideVisibleClass     : 'wd-slide-visible',
			slideNextClass        : 'wd-slide-next',
			slidePrevClass        : 'wd-slide-prev',
			slideFullyVisibleClass: 'wd-full-visible',
			slideBlankClass       : 'wd-slide-blank',
			lazyPreloaderClass    : 'wd-lazy-preloader',
			containerModifierClass: 'wd-',
			wrapperClass          : 'wd-carousel-wrap',
			on                    : {
				init: function() {
					setTimeout(function() {
						woodmartThemeModule.$document.trigger('wdSwiperCarouselInited');
					}, 100);
				}
			}
		};

		if ('undefined' !== typeof carousel.dataset.effect) {
			var effect = carousel.dataset.effect;

			if ('distortion' === effect) {
				effect = 'fade';
			}

			config.effect = effect;

			if ('parallax' === effect) {
				config.parallax = {
					enabled: true
				};

				carousel.querySelectorAll('.wd-slide-bg').forEach( function (slideBg) {
					slideBg.setAttribute('data-swiper-parallax', '50%');
				});
			}
		}

		if ('undefined' !== typeof carousel.dataset.sliding_speed && carousel.dataset.sliding_speed) {
			config.speed = carousel.dataset.sliding_speed;
		}

		var pagination = Array.prototype.filter.call(
			carouselWrapper.children,
			(element) => element.classList.contains('wd-nav-pagin-wrap'),
		).shift();

		if (pagination) {
			config.pagination = {
				el                     : pagination.querySelector('.wd-nav-pagin'),
				dynamicBullets         : pagination.classList.contains('wd-dynamic'),
				type                   : 'bullets',
				clickable              : true,
				bulletClass            : 'wd-nav-pagin-item',
				bulletActiveClass      : 'wd-active',
				modifierClass          : 'wd-type-',
				lockClass              : 'wd-lock',
				currentClass           : 'wd-current',
				totalClass             : 'wd-total',
				hiddenClass            : 'wd-hidden',
				clickableClass         : 'wd-clickable',
				horizontalClass        : 'wd-horizontal',
				verticalClass          : 'wd-vertical',
				paginationDisabledClass: 'wd-disabled',
				renderBullet           : function(index, className) {
					var innerContent = '';

					if (pagination.classList.contains('wd-style-number-2')) {
						innerContent = index + 1;

						if ( 9 >= innerContent ) {
							innerContent = '0' + innerContent;
						}
					}

					return '<li class="' + className + '"><span>' + innerContent + '</span></li>';
				}
			};
		}

		var navigationWrapper = Array.prototype.filter.call(
			carouselWrapper.querySelector('.wd-carousel-inner').children,
			(element) => element.classList.contains('wd-nav-arrows'),
		).shift();

		if (navigationWrapper) {
			config.navigation = {
				nextEl       : navigationWrapper.querySelector('.wd-btn-arrow.wd-next'),
				prevEl       : navigationWrapper.querySelector('.wd-btn-arrow.wd-prev'),
				disabledClass: 'wd-disabled',
				lockClass    : 'wd-lock',
				hiddenClass  : 'wd-hide'
			};
		}

		var scrollbar = Array.prototype.filter.call(
			carouselWrapper.children,
			(element) => element.classList.contains('wd-nav-scroll'),
		).shift();

		if (scrollbar) {
			config.scrollbar = {
				el                    : scrollbar,
				lockClass             : 'wd-lock',
				dragClass             : 'wd-nav-scroll-drag',
				scrollbarDisabledClass: 'wd-disabled',
				horizontalClass       : 'wd-horizontal',
				verticalClass         : 'wd-vertical',
				draggable             : true
			};

			config.on.scrollbarDragStart = function () {
				scrollbar.classList.add('wd-grabbing');
			};
			config.on.scrollbarDragEnd = function () {
				scrollbar.classList.remove('wd-grabbing');
			};
		}

		if ('undefined' !== typeof carousel.dataset.autoplay && 'yes' === carousel.dataset.autoplay) {
			config.autoplay = {
				delay: carousel.dataset.speed ? carousel.dataset.speed : 5000,
				pauseOnMouseEnter: true
			};
		}

		if ('undefined' !== typeof carousel.dataset.sync_parent_id) {
			var childCarousel = document.querySelector('.wd-carousel[data-sync_child_id=' + carousel.dataset.sync_parent_id + ']');

			if ( childCarousel ) {
				config.thumbs = {
					swiper               : carouselInit(childCarousel, true),
					slideThumbActiveClass: 'wd-thumb-active',
					thumbsContainerClass : 'wd-thumbs'
				};
			}
		}

		carousel.querySelectorAll('link').forEach(function (link) {
			var linkClone = link.cloneNode(false);

			carouselWrapper.append(linkClone);

			linkClone.addEventListener('load', function() {
				setTimeout(function () {
					link.remove();
				}, 500);
			}, false);
		});

		const swiper = new wdSwiper(carousel, config);

		if (carouselWrapper && carouselWrapper.classList.contains('wd-slider')) {
			swiper.on('realIndexChange', function (swiper) {
				setTimeout(function () {
					carousel.dispatchEvent(new CustomEvent('wdSlideChange', {
						detail: {activeIndex: swiper.realIndex}
					}));
				},100);
			});
		}

		window.addEventListener('popstate', function() {
			document.querySelectorAll('.wd-carousel.wd-initialized').forEach( function (carousel) {
				if ('undefined' === typeof carousel.swiper) {
					carousel.classList.remove('wd-initialized');

					carouselInit(carousel);
				}
			});
		});

		return swiper;
	}
};

window.addEventListener('load',function() {
	woodmartThemeModule.swiperInit();
});
