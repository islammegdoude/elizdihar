var woodmartThemeModule = {};
/* global woodmart_settings */

(function($) {
	woodmartThemeModule.supports_html5_storage = false;

	try {
		woodmartThemeModule.supports_html5_storage = ('sessionStorage' in window && window.sessionStorage !== null);
		window.sessionStorage.setItem('wd', 'test');
		window.sessionStorage.removeItem('wd');
	}
	catch (err) {
		woodmartThemeModule.supports_html5_storage = false;
	}

	woodmartThemeModule.$window = $(window);

	woodmartThemeModule.$document = $(document);

	woodmartThemeModule.$body = $('body');

	woodmartThemeModule.windowWidth = woodmartThemeModule.$window.width();

	woodmartThemeModule.removeURLParameter = function(url, parameter) {
		var urlParts = url.split('?');

		if (urlParts.length >= 2) {
			var prefix = encodeURIComponent(parameter) + '=';
			var pars = urlParts[1].split(/[&;]/g);

			for (var i = pars.length; i-- > 0;) {
				if (pars[i].lastIndexOf(prefix, 0) !== -1) {
					pars.splice(i, 1);
				}
			}

			return urlParts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
		}

		return url;
	};

	woodmartThemeModule.removeDuplicatedStylesFromHTML = function(html, callback) {
		var $data = $('<div class="temp-wrapper"></div>').append(html);
		var $links = $data.find('link');
		var counter = 0;
		var timeout = false;

		if (0 === $links.length) {
			callback(html);
			return;
		}

		setTimeout(function() {
			if (counter <= $links.length && !timeout) {
				callback($($data.html()));
				timeout = true;
			}
		}, 500);

		$links.each(function() {
			if ( 'undefined' !== typeof $(this).attr('id') && $(this).attr('id').indexOf('theme_settings_') !== -1) {
				$('head').find('link[id*="theme_settings_"]:not([id*="theme_settings_default"])').remove();
			}
		});

		$links.each(function() {
			var $link = $(this);
			var id = $link.attr('id');
			var href = $link.attr('href');

			if ( 'undefined' === typeof id ) {
				return;
			}

			var isThemeSettings = id.indexOf('theme_settings_') !== -1;
			var isThemeSettingsDefault = id.indexOf('theme_settings_default') !== -1;

			$link.remove();

			if ('undefined' === typeof woodmart_page_css[id] && ! isThemeSettingsDefault) {
				$('head').append($link.on('load', function() {
					counter++;

					if (!isThemeSettings) {
						woodmart_page_css[id] = href;
					}

					if (counter >= $links.length && !timeout) {
						callback($($data.html()));
						timeout = true;
					}
				}));
			} else {
				counter++;

				if (counter >= $links.length && !timeout) {
					callback($($data.html()));
					timeout = true;
				}
			}
		});
	};

	woodmartThemeModule.debounce = function(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this;
			var args = arguments;
			var later = function() {
				timeout = null;

				if (!immediate) {
					func.apply(context, args);
				}
			};
			var callNow = immediate && !timeout;

			clearTimeout(timeout);
			timeout = setTimeout(later, wait);

			if (callNow) {
				func.apply(context, args);
			}
		};
	};

	woodmartThemeModule.wdElementorAddAction = function(name, callback) {
		woodmartThemeModule.$window.on('elementor/frontend/init', function() {
			if (!elementorFrontend.isEditMode()) {
				return;
			}

			elementorFrontend.hooks.addAction(name, callback);
		});
	};

	woodmartThemeModule.wdElementorAddAction('frontend/element_ready/global', function($wrapper) {
		if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
			$wrapper.attr('style', '');
		}
		$wrapper.removeClass('wd-animated');
		$wrapper.data('wd-waypoint', '');
		$wrapper.removeClass('wd-anim-ready');
		woodmartThemeModule.$document.trigger('wdElementorGlobalReady');
	});

	$.each([
		'frontend/element_ready/column',
		'frontend/element_ready/container'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
			if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
				$wrapper.attr('style', '');
			}
			$wrapper.removeClass('wd-animated');
			$wrapper.data('wd-waypoint', '');
			$wrapper.removeClass('wd-anim-ready');

			setTimeout(function() {
				woodmartThemeModule.$document.trigger('wdElementorColumnReady');
			}, 100);
		});
	});

	woodmartThemeModule.setupMainCarouselArg = function() {
		woodmartThemeModule.$mainCarouselWrapper = $('.woocommerce-product-gallery');
		var items = 1;

		if ( woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered') || woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-carousel_two_columns') ) {
			items = 2;
		}

		woodmartThemeModule.mainCarouselArg = {
			slidesPerView  : items,
			loop           : woodmart_settings.product_slider_autoplay,
			centeredSlides : woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered'),
			initialSlide   : woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered') ? woodmart_settings.centered_gallery_start : 0,
			autoHeight     : woodmart_settings.product_slider_auto_height === 'yes',
			grabCursor            : true,
			a11y                  : {
				enabled: false
			},
			slideClass            : 'wd-carousel-item',
			slideActiveClass      : 'wd-active',
			slideVisibleClass     : 'wd-slide-visible',
			slideNextClass        : 'wd-next',
			slidePrevClass        : 'wd-prev',
			containerModifierClass: 'wd-',
			wrapperClass          : 'wd-carousel-wrap',
			on                    : {
				slideChange: function() {
					document.querySelector('.woocommerce-product-gallery__wrapper.wd-carousel').dispatchEvent(new CustomEvent('wdSlideChange', { activeIndex: this.activeIndex}));

					woodmartThemeModule.$document.trigger('wood-images-loaded');
				}
			}
		};

		if ( document.querySelector('.woocommerce-product-gallery__wrapper.wd-carousel') && document.querySelector('.woocommerce-product-gallery__wrapper.wd-carousel').parentElement.querySelector('.wd-btn-arrow.wd-next') ) {
			woodmartThemeModule.mainCarouselArg.navigation = {
				nextEl       : document.querySelector('.woocommerce-product-gallery__wrapper.wd-carousel').parentElement.querySelector('.wd-btn-arrow.wd-next'),
				prevEl       : document.querySelector('.woocommerce-product-gallery__wrapper.wd-carousel').parentElement.querySelector('.wd-btn-arrow.wd-prev'),
				disabledClass: 'wd-disabled',
				lockClass    : 'wd-lock',
				hiddenClass  : 'wd-hide'
			};
		}


		if (woodmart_settings.product_slider_autoplay) {
			woodmartThemeModule.mainCarouselArg.autoplay = {
				delay: 3000,
				pauseOnMouseEnter: true
			};
		}

		if (woodmartThemeModule.$mainCarouselWrapper.find('.wd-nav-pagin-wrap').length) {
			woodmartThemeModule.mainCarouselArg.pagination = {
				el                     : document.querySelector('.woocommerce-product-gallery .wd-nav-pagin'),
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

					if (woodmartThemeModule.$mainCarouselWrapper.find('.wd-nav-pagin-wrap').hasClass('wd-style-number-2')) {
						innerContent = index + 1;

						if ( 9 >= innerContent ) {
							innerContent = '0' + innerContent;
						}
					}

					return '<li class="' + className + '"><span>' + innerContent + '</span></li>';
				}
			};
		}
	}

	woodmartThemeModule.shopLoadMoreBtn = '.wd-products-load-more.load-on-scroll';

	woodmartThemeModule.$window.on('elementor/frontend/init', function() {
		if (!elementorFrontend.isEditMode()) {
			return;
		}

		if ('enabled' === woodmart_settings.elementor_no_gap) {
			$.each([
				'frontend/element_ready/section',
				'frontend/element_ready/container'
			], function(index, value) {
				woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
					if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
						$wrapper.attr('style', '');
					}

					$wrapper.removeClass('wd-animated');
					$wrapper.data('wd-waypoint', '');
					$wrapper.removeClass('wd-anim-ready');
					woodmartThemeModule.$document.trigger('wdElementorSectionReady');
				});

				elementorFrontend.hooks.addAction(value, function($wrapper) {
					var cid = $wrapper.data('model-cid');

					if (typeof elementorFrontend.config.elements.data[cid] !== 'undefined') {
						var size = '';

						if ('undefined' !== typeof elementorFrontend.config.elements.data[cid].attributes.elType) {
							if ('container' === elementorFrontend.config.elements.data[cid].attributes.elType) {
								if ( 'boxed' === elementorFrontend.config.elements.data[cid].attributes.content_width ) {
									size = elementorFrontend.config.elements.data[cid].attributes.boxed_width.size;
								} else {
									size = true;
								}
							} else if ('section' === elementorFrontend.config.elements.data[cid].attributes.elType) {
								size = elementorFrontend.config.elements.data[cid].attributes.content_width.size;
							}
						}

						if (!size) {
							$wrapper.addClass('wd-negative-gap');
						}
					}
				});
			});

			elementor.channels.editor.on('change:section change:container', function(view) {
				var changed = view.elementSettingsModel.changed;
				if (typeof changed.content_width !== 'undefined' || typeof changed.boxed_width !== 'undefined') {
					var size = [];

					if ('container' === view.elementSettingsModel.attributes.elType ) {
						if ( typeof changed.boxed_width !== 'undefined' ) {
							size = changed.boxed_width.size;
						}
					} else if (typeof changed.content_width !== 'undefined') {
						size = changed.content_width.size;
					}

					var sectionId = view._parent.model.id;
					var $section = $('.elementor-element-' + sectionId);

					if (size) {
						$section.removeClass('wd-negative-gap');
					} else {
						$section.addClass('wd-negative-gap');
					}
				}
			});
		}
	});

	woodmartThemeModule.$window.on('load', function() {
		$('.wd-preloader').delay(parseInt(woodmart_settings.preloader_delay)).addClass('preloader-hide');
		$('.wd-preloader-style').remove();
		setTimeout(function() {
			$('.wd-preloader').remove();
		}, 200);
	});

	woodmartThemeModule.googleMapsCallback = function () {
		return '';
	};
})(jQuery);

woodmartThemeModule.slideUp = function ( target, duration = 400 ) {
	target.style.transitionProperty = 'height, margin, padding';
	target.style.transitionDuration = duration + 'ms';
	target.style.boxSizing = 'border-box';
	target.style.height = target.offsetHeight + 'px';
	target.offsetHeight;
	target.style.overflow = 'hidden';
	target.style.height = 0;
	target.style.paddingTop = 0;
	target.style.paddingBottom = 0;
	target.style.marginTop = 0;
	target.style.marginBottom = 0;

	window.setTimeout( () => {
		target.style.display = 'none';
		target.style.removeProperty('height');
		target.style.removeProperty('padding-top');
		target.style.removeProperty('padding-bottom');
		target.style.removeProperty('margin-top');
		target.style.removeProperty('margin-bottom');
		target.style.removeProperty('overflow');
		target.style.removeProperty('transition-duration');
		target.style.removeProperty('transition-property');
	}, duration);
}

woodmartThemeModule.slideDown = function ( target, duration = 400 ) {
	target.style.removeProperty('display');
	let display = window.getComputedStyle(target).display;

	if ('none' === display) {
		display = 'block';
	}

	target.style.display = display;
	let height = target.offsetHeight;
	target.style.overflow = 'hidden';
	target.style.height = 0;
	target.style.paddingTop = 0;
	target.style.paddingBottom = 0;
	target.style.marginTop = 0;
	target.style.marginBottom = 0;
	target.offsetHeight;
	target.style.boxSizing = 'border-box';
	target.style.transitionProperty = "height, margin, padding";
	target.style.transitionDuration = duration + 'ms';
	target.style.height = height + 'px';
	target.style.removeProperty('padding-top');
	target.style.removeProperty('padding-bottom');
	target.style.removeProperty('margin-top');
	target.style.removeProperty('margin-bottom');

	window.setTimeout( () => {
		target.style.removeProperty('height');
		target.style.removeProperty('overflow');
		target.style.removeProperty('transition-duration');
		target.style.removeProperty('transition-property');
	}, duration);
}

woodmartThemeModule.slideToggle = function (target, duration = 400) {
	if (window.getComputedStyle(target).display === 'none') {
		return woodmartThemeModule.slideDown(target, duration);
	} else {
		return woodmartThemeModule.slideUp(target, duration);
	}
}

window.addEventListener('load',function() {
	var events = [
		'keydown',
		'scroll',
		'mouseover',
		'touchmove',
		'touchstart',
		'mousedown',
		'mousemove'
	];

	var triggerListener = function(e) {
		window.dispatchEvent(new CustomEvent('wdEventStarted'));
		removeListener();
	};

	var removeListener = function() {
		events.forEach(function(eventName) {
			window.removeEventListener(eventName, triggerListener);
		});
	};

	var addListener = function(eventName) {
		window.addEventListener(eventName, triggerListener);
	};

	events.forEach(function(eventName) {
		addListener(eventName);
	});
});