/* global woodmart_settings */
woodmartThemeModule.$document.on('wdSwiperCarouselInited', function () {
	woodmartThemeModule.sliderDistortion();
});

woodmartThemeModule.sliderDistortion = function() {
	if ('undefined' === typeof ShaderX || woodmartThemeModule.$body.hasClass('single-woodmart_slide') || ! document.querySelector('.wd-slider.wd-anim-distortion .wd-carousel.wd-initialized')) {
		return;
	}

	document.querySelectorAll('.wd-slider.wd-anim-distortion').forEach( function ($slider) {
		var $slides = $slider.querySelectorAll('.wd-carousel .wd-slide');
		var imgSrc  = getImageSrc( $slides[0] );
		var imgSrc2 = getImageSrc( $slides[1] );

		if ($slider.classList.contains('webgl-inited') || !imgSrc || !imgSrc2) {
			return;
		}

		$slider.classList.add('webgl-inited');

		var shaderX = new ShaderX({
			container     : $slider.querySelector('.wd-carousel'),
			sizeContainer : $slider,
			vertexShader  : woodmartThemeModule.shaders.matrixVertex,
			fragmentShader: woodmartThemeModule.shaders[woodmart_settings.slider_distortion_effect] ? woodmartThemeModule.shaders[woodmart_settings.slider_distortion_effect] : woodmartThemeModule.shaders.sliderWithWave,
			width         : $slider.offsetWidth,
			height        : $slider.offsetHeight,
			distImage     : woodmart_settings.slider_distortion_effect === 'sliderPattern' ? woodmart_settings.theme_url + '/images/dist11.jpg' : false
		});

		shaderX.loadImage(imgSrc, 0, function() {
			$slider.classList.add('wd-canvas-loaded');
		});
		shaderX.loadImage(imgSrc, 1);
		shaderX.loadImage(imgSrc2, 0, undefined, true);

		$slider.querySelector('.wd-carousel').addEventListener('wdSlideChange', function (e) {
			var activeSlide = e.target.swiper.visibleSlides[0];

			imgSrc = getImageSrc( activeSlide );

			if (!imgSrc) {
				return;
			}

			shaderX.replaceImage(imgSrc);

			if (activeSlide.nextElementSibling) {
				imgSrc2 = getImageSrc( activeSlide.nextElementSibling);

				if ( imgSrc2 ) {
					shaderX.loadImage(imgSrc2, 0, undefined, true);
				}
			}
		});
	});

	function getImageSrc( slide ) {
		var imageSrc = slide.dataset.imageUrl;

		if ( woodmartThemeModule.$window.width() <= 1024 && slide.dataset.imageUrlMd ) {
			imageSrc = slide.dataset.imageUrlMd;
		}

		if ( woodmartThemeModule.$window.width() <= 767 && slide.dataset.imageUrlSm ) {
			imageSrc = slide.dataset.imageUrlSm;
		}

		return imageSrc;
	}
};

window.addEventListener('load',function() {
	woodmartThemeModule.sliderDistortion();
});
