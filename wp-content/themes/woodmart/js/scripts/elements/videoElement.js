/* global xts_settings */
(function($) {
	woodmartThemeModule.$document.on('wdLoadDropdownsSuccess', function() {
		woodmartThemeModule.videoElementClick();
	});

	woodmartThemeModule.wdElementorAddAction('frontend/element_ready/wd_video.default', function() {
		woodmartThemeModule.videoElementClick();
	});

	woodmartThemeModule.videoElementClick = function() {
		$('.wd-el-video-btn-overlay:not(.wd-el-video-lightbox):not(.wd-el-video-hosted)').on('click', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $video = $this.parents('.wd-el-video').find('iframe');
			var videoScr = $video.data('lazy-load');
			var videoNewSrc = videoScr + '&autoplay=1&rel=0&mute=1';

			if (videoScr.indexOf('vimeo.com') + 1) {
				videoNewSrc = videoScr.replace('#t=', '') + '&autoplay=1';
			}

			$video.attr('src', videoNewSrc);
			$this.parents('.wd-el-video').addClass('wd-playing');
		});

		$('.wd-el-video-btn-overlay.wd-el-video-hosted:not(.wd-el-video-lightbox)').on('click', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $video = $this.parents('.wd-el-video').find('video');
			var videoScr = $video.data('lazy-load');

			$video.attr('src', videoScr);
			$video[0].play();
			$this.parents('.wd-el-video').addClass('wd-playing');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.videoElementClick();
	});
})(jQuery);