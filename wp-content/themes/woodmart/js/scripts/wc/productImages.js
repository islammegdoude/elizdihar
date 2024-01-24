/* global woodmart_settings */
(function($) {
	woodmartThemeModule.productImages = function() {
		var currentImage,
		    $productGallery   = $('.woocommerce-product-gallery'),
		    $mainImages       = $('.woocommerce-product-gallery__wrapper'),
		    PhotoSwipeTrigger = '.wd-show-product-gallery-wrap > a';

		if ($productGallery.hasClass('image-action-popup')) {
			PhotoSwipeTrigger += ', .woocommerce-product-gallery__image > a';
		}

		$productGallery.on('click', '.woocommerce-product-gallery__image > a', function(e) {
			e.preventDefault();
		});

		$productGallery.on('click', PhotoSwipeTrigger, function(e) {
			e.preventDefault();

			var $this = $(this);

			currentImage = $this.attr('href');

			var items = getProductItems();

			woodmartThemeModule.callPhotoSwipe(getCurrentGalleryIndex(e), items);
		});

		var getCurrentGalleryIndex = function(e) {
			var index = 0;
			var $currentTarget = $(e.currentTarget);

			if ( $currentTarget.parents('.wd-carousel-item').length ) {
				index = $currentTarget.parents('.wd-carousel-item').index();
			} else if ( $currentTarget.hasClass( 'woodmart-show-product-gallery' ) ) {
				var wrapperGallery = $currentTarget.parents('.woocommerce-product-gallery');

				if ( wrapperGallery.hasClass('thumbs-position-left') || wrapperGallery.hasClass('thumbs-position-bottom') || wrapperGallery.hasClass('thumbs-position-without') ) {
					index = $currentTarget.parents('.wd-gallery-images').find('.wd-carousel-item.wd-active').index();
				}
			}

			return index;
		};

		var getProductItems = function() {
			var items = [];

			$mainImages.find('figure a img').each(function() {
				var $this = $(this);
				var src     = $this.attr('data-large_image'),
				    width   = $this.attr('data-large_image_width'),
				    height  = $this.attr('data-large_image_height'),
				    caption = $this.data('caption');

				if ( $this.parents('.wd-carousel-item.wd-with-video').length ) {
					var videoContent = $this.parents('.wd-with-video')[0].outerHTML;

					if ( -1 !== videoContent.indexOf('wd-inited') ) {
						videoContent = videoContent.replace('wd-inited', 'wd-loaded').replace('wd-video-playing', '');
					}

					items.push({
						html       : videoContent,
						mainElement: $this.parents('.wd-with-video'),
					});
				} else {
					items.push({
						src  : src,
						w    : width,
						h    : height,
						title: (woodmart_settings.product_images_captions === 'yes') ? caption : false
					});
				}
			});

			return items;
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.productImages();
	});
})(jQuery);
