/* global xts_settings */
(function($) {
	woodmartThemeModule.$document.on('wdLoadDropdownsSuccess', function() {
		woodmartThemeModule.videoElementPopup();
	});

	woodmartThemeModule.wdElementorAddAction('frontend/element_ready/wd_video.default', function() {
		woodmartThemeModule.videoElementPopup();
	});

	woodmartThemeModule.videoElementPopup = function() {
		if ('undefined' === typeof ($.fn.magnificPopup)) {
			return;
		}

		$.magnificPopup.close();

		$('.wd-el-video-btn:not(.wd-el-video-hosted), .wd-el-video-btn-overlay.wd-el-video-lightbox:not(.wd-el-video-hosted), .wd-el-video.wd-action-button:not(.wd-video-hosted) a, .wd-el-video.wd-action-action_button:not(.wd-video-hosted) a').magnificPopup({
			tClose         : woodmart_settings.close,
			tLoading       : woodmart_settings.loading,
			removalDelay   : 500,
			type           : 'iframe',
			preloader      : false,
			iframe         : {
				markup  : '<div class="wd-popup mfp-with-anim wd-video-popup"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" allowfullscreen frameborder="0"></iframe></div>',
				patterns: {
					youtube: {
						index: 'youtube.com/',
						id   : 'v=',
						src  : '//www.youtube.com/embed/%id%?rel=0&autoplay=1&mute=1'
					},
					vimeo  : {
						index: 'vimeo.com/',
						id   : '/',
						src  : '//player.vimeo.com/video/%id%?transparent=0&autoplay=1&muted=1'
					}
				}
			},
			callbacks      : {
				beforeOpen: function() {
					this.st.mainClass = 'mfp-move-horizontal';
				}
			}
		});

		$('.wd-el-video-btn-overlay.wd-el-video-lightbox.wd-el-video-hosted,.wd-el-video-btn.wd-el-video-hosted, .wd-el-video.wd-action-button.wd-video-hosted a, .wd-el-video.wd-action-action_button.wd-video-hosted a').magnificPopup({
			type        : 'inline',
			tClose      : woodmart_settings.close,
			tLoading    : woodmart_settings.loading,
			removalDelay: 500,
			preloader   : false,
			callbacks   : {
				beforeOpen  : function() {
					this.st.mainClass = 'mfp-move-horizontal';
				},
				elementParse: function(item) {
					var $video = $(item.src).find('video');

					if ( ! $video.attr('src') ) {
						$video.attr('src', $video.data('lazy-load'));
					}

					$video[0].play();
				},
				open        : function() {
					woodmartThemeModule.$document.trigger('wood-images-loaded');
					woodmartThemeModule.$window.resize();
				},
				close       : function(e) {
					var magnificPopup = $.magnificPopup.instance;
					var $video = $(magnificPopup.st.el[0]).parents('.wd-el-video').find('video');
					$video[0].pause();
				}
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.videoElementPopup();
	});
})(jQuery);