/* global woodmart_settings */
woodmartThemeModule.$document.on('wdReplaceMainGallery', function() {
	woodmartThemeModule.productImagesGallery( true );
});

[
	'frontend/element_ready/wd_single_product_gallery.default'
].forEach( function (value) {
	woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
		woodmartThemeModule.productImagesGallery();

		$wrapper.find('.woocommerce-product-gallery').css('opacity', '1');
	});
});

woodmartThemeModule.productImagesGallery = function( replaceGallery = false) {
	document.querySelectorAll('.woocommerce-product-gallery').forEach( function (galleryWrapper) {
		var galleryContainer = galleryWrapper.querySelector('.wd-carousel-container');
		var gallery = galleryWrapper.querySelector('.woocommerce-product-gallery__wrapper:not(.quick-view-gallery)');
		var thumbnails = galleryWrapper.querySelector('.wd-gallery-thumb .wd-carousel');
		var galleryStyle = window.getComputedStyle(gallery);

		var galleryDesktop = galleryStyle.getPropertyValue('--wd-col-lg') ? galleryStyle.getPropertyValue('--wd-col-lg') : galleryStyle.getPropertyValue('--wd-col');
		var galleryTablet = galleryStyle.getPropertyValue('--wd-col-md') ? galleryStyle.getPropertyValue('--wd-col-md') : galleryStyle.getPropertyValue('--wd-col');
		var galleryMobile = galleryStyle.getPropertyValue('--wd-col-sm') ? galleryStyle.getPropertyValue('--wd-col-sm') : galleryStyle.getPropertyValue('--wd-col');

		var mainCarouselArg = {
			slidesPerView         : galleryDesktop,
			loop                  : woodmart_settings.product_slider_autoplay,
			centeredSlides        : 'yes' === gallery.dataset.center_mode,
			autoHeight            : woodmart_settings.product_slider_auto_height === 'yes',
			grabCursor            : true,
			a11y                  : {
				enabled: false
			},
			breakpoints           : {
				1025: {
					slidesPerView: galleryDesktop,
					initialSlide : 'yes' === gallery.dataset.center_mode && galleryDesktop ? 1 : 0
				},
				768.98: {
					slidesPerView: galleryTablet,
					initialSlide : 'yes' === gallery.dataset.center_mode && galleryTablet ? 1 : 0
				},
				0: {
					slidesPerView: galleryMobile,
					initialSlide : 'yes' === gallery.dataset.center_mode && galleryMobile ? 1 : 0
				}
			},
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
				slideChange: function() {
					gallery.dispatchEvent(new CustomEvent('wdSlideChange', { activeIndex: this.activeIndex}));

					woodmartThemeModule.$document.trigger('wood-images-loaded');
				}
			}
		};

		if ( gallery.parentElement.querySelector('.wd-btn-arrow.wd-next') ) {
			mainCarouselArg.navigation = {
				nextEl       : gallery.parentElement.querySelector('.wd-btn-arrow.wd-next'),
				prevEl       : gallery.parentElement.querySelector('.wd-btn-arrow.wd-prev'),
				disabledClass: 'wd-disabled',
				lockClass    : 'wd-lock',
				hiddenClass  : 'wd-hide'
			};
		}

		if (woodmart_settings.product_slider_autoplay) {
			mainCarouselArg.autoplay = {
				delay: 3000,
				pauseOnMouseEnter: true
			};
		}

		if (galleryWrapper.querySelector('.wd-nav-pagin')) {
			mainCarouselArg.pagination = {
				el                     : galleryWrapper.querySelector('.wd-nav-pagin'),
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

					if (galleryWrapper.querySelector('.wd-nav-pagin-wrap').classList.contains('wd-style-number-2')) {
						innerContent = index + 1;

						if ( 9 >= innerContent ) {
							innerContent = '0' + innerContent;
						}
					}

					return '<li class="' + className + '"><span>' + innerContent + '</span></li>';
				}
			};
		}

		if ( thumbnails ) {
			var thumbnailsWrapper = galleryWrapper.querySelector('.wd-gallery-thumb');
			var thumbnailsDirection = galleryWrapper.classList.contains('thumbs-position-left') && ( woodmartThemeModule.$body.width() > 1024 || ! galleryWrapper.classList.contains('wd-thumbs-wrap') ) ? 'vertical' : 'horizontal';

			if (thumbnails.children.length) {
				if ( replaceGallery ) {
					createThumbnails();
				}

				if ( 'vertical' === thumbnailsDirection && ! window.getComputedStyle(galleryWrapper).getPropertyValue('--wd-thumbs-height') ) {
					galleryWrapper.style.setProperty('--wd-thumbs-height', thumbnailsWrapper.offsetHeight + 'px');
				}

				var thumbnailsStyle = window.getComputedStyle(thumbnails);

				var thumbnDesktop = thumbnailsStyle.getPropertyValue('--wd-col-lg') ? thumbnailsStyle.getPropertyValue('--wd-col-lg') : 2;
				var thumbnTablet = thumbnailsStyle.getPropertyValue('--wd-col-md') ? thumbnailsStyle.getPropertyValue('--wd-col-md') : 2;
				var thumbnMobile = thumbnailsStyle.getPropertyValue('--wd-col-sm') ? thumbnailsStyle.getPropertyValue('--wd-col-sm') : 2;

				mainCarouselArg.thumbs = {
					swiper: {
						el                    : thumbnails,
						slidesPerView         : thumbnDesktop,
						direction             : thumbnailsDirection,
						autoHeight            : 'horizontal' === thumbnailsDirection && woodmart_settings.product_slider_auto_height === 'yes',
						id                    : 'wd-carousel-thumbnails',
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
						grabCursor            : true,
						a11y                  : {
							enabled: false
						},
						breakpoints           : {
							1025 : {
								slidesPerView: thumbnDesktop
							},
							768.98 : {
								slidesPerView: thumbnTablet
							},
							0   : {
								slidesPerView: thumbnMobile
							}
						},
						navigation            : {
							nextEl       : thumbnails.nextElementSibling.querySelector('.wd-btn-arrow.wd-next'),
							prevEl       : thumbnails.nextElementSibling.querySelector('.wd-btn-arrow.wd-prev'),
							disabledClass: 'wd-disabled',
							lockClass    : 'wd-lock',
							hiddenClass  : 'wd-hide'
						},
						on               : {
							slideChange: function() {
								woodmartThemeModule.$document.trigger('wood-images-loaded');
							}
						}
					},
					slideThumbActiveClass : 'wd-thumb-active',
					thumbsContainerClass  : 'wd-thumbs'
				};
			}
		}

		if (
			galleryWrapper.classList.contains('thumbs-position-without')
			|| galleryWrapper.classList.contains('thumbs-position-bottom')
			|| galleryWrapper.classList.contains('thumbs-position-left')
			|| (
				(
					( ! galleryContainer.classList.contains('wd-off-md') && woodmartThemeModule.$window.width() <= 1024 && woodmartThemeModule.$window.width() > 768 )
					|| ( ! galleryContainer.classList.contains('wd-off-sm') && woodmartThemeModule.$window.width() <= 768 )
				)
				&& (
					galleryWrapper.classList.contains('thumbs-grid-bottom_combined')
					|| galleryWrapper.classList.contains('thumbs-grid-bottom_combined_2')
					|| galleryWrapper.classList.contains('thumbs-grid-bottom_combined_3')
					|| galleryWrapper.classList.contains('thumbs-grid-bottom_column')
					|| galleryWrapper.classList.contains('thumbs-grid-bottom_grid')
				)
			)
		) {
			if ('yes' === woodmart_settings.product_slider_auto_height) {
				imagesLoaded(galleryWrapper, function() {
						initGallery();
					});
			} else {
				initGallery();
			}
		}

		function initGallery() {
			if ('undefined' === typeof wdSwiper) {
				return;
			}

			if (thumbnails && 'undefined' !== typeof thumbnails.swiper) {
				thumbnails.swiper.destroy( true, false );
			}
			if ('undefined' !== typeof gallery.swiper) {
				gallery.swiper.destroy( true, false );
			}

			gallery.classList.add('wd-carousel');

			woodmartThemeModule.$document.trigger('wood-images-loaded');

			new wdSwiper(gallery, mainCarouselArg);
		}

		function createThumbnails() {
			var html = '';

			gallery.querySelectorAll('.woocommerce-product-gallery__image').forEach( function (imageWrapper, index) {
				var imageSrc = imageWrapper.dataset.thumb;
				var image           = imageWrapper.querySelector('a img');
				var alt             = image.getAttribute('alt');
				var title           = image.getAttribute('title');
				var classes  = '';

				if (!title && imageWrapper.querySelector('a picture')) {
					title = imageWrapper.querySelector('a picture').getAttribute('title');
				}

				if (imageWrapper.querySelector('.wd-product-video')) {
					classes += ' wd-with-video';
				}

				html += '<div class="wd-carousel-item' + classes + '">';
				html += '<img src="' + imageSrc + '"';

				if (alt) {
					html += ' alt="' + alt + '"';
				}
				if (title) {
					html += ' title="' + title + '"';
				}
				if (0 === index) {
					var imageOriginalSrc   = image.getAttribute('data-o_src');

					if ( imageOriginalSrc ) {
						html += ' data-o_src="' + imageOriginalSrc + '"';
					}
					//srcset
				}

				html += '/>';

				html += '</div>';
			});

			thumbnails.firstElementChild.innerHTML = html;
		}
	});
}

woodmartThemeModule.$window.on('elementor/frontend/init', function() {
	if (!elementorFrontend.isEditMode()) {
		return;
	}

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.productImagesGallery();
	}, 300));
});

window.addEventListener('load',function() {
	woodmartThemeModule.productImagesGallery();
});
