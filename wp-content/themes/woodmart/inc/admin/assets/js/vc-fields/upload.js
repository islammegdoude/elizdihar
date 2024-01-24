(function($) {
	var $panel = $('#vc_ui-panel-edit-element');

	$panel.on('vcPanel.shown', function() {
		$panel.on('click', '.xts-upload-btn', function(e) {
			e.preventDefault();

			var $uploadButton = $(this);
			var $removeButton = $uploadButton.siblings('.xts-remove-upload-btn');
			var $input = $uploadButton.siblings('.xts-upload-input-id');
			var settings = $input.data('settings');
			var $preview = $uploadButton.parents('.xts-upload-btns').siblings('.xts-upload-preview');
			var type = 'all';
			var id = $uploadButton.data('id');

			if ( 'undefined' !== typeof settings.attachment_type ) {
				type = settings.attachment_type;
			}

			if ( 'undefined' !== typeof wp.media.frames.wd_upload && 'undefined' !== typeof wp.media.frames.wd_upload[id] ) {
				wp.media.frames.wd_upload[id].open();

				return;
			}

			wp.media.frames.wd_upload = {
				[id] : wp.media({
					multiple: false, // for multiple image selection set
					library: {
						type: 'all' !== type ? type : ''
					}
				})
			};

			wp.media.frames.wd_upload[id].on('open', function () {
				var selection = wp.media.frames.wd_upload[id].state().get('selection');
				var imageID = $input.val();

				if ( ! imageID ) {
					return;
				}

				var attachment = wp.media.attachment(imageID);
				attachment.fetch();
				selection.add( attachment ? [ attachment ] : [] );
			});

			wp.media.frames.wd_upload[id].on('select', function() { // it also has "open" and "close" events
				var attachment = wp.media.frames.wd_upload[id].state().get('selection').first().toJSON();
				$input.val(attachment.id).trigger('change');
				$removeButton.addClass('xts-active');
				$preview.text(attachment.filename)
			}).open();
		});

		$panel.on('click', '.xts-remove-upload-btn', function(e) {
			e.preventDefault();

			var $removeButton = $(this);
			var $uploadButton = $removeButton.siblings('..xts-upload-btn');
			var buttonId = $uploadButton.data('id');
			var $input = $removeButton.siblings('.xts-upload-input-id');

			if ( 'undefined' !== typeof wp.media.frames.wd_upload && 'undefined' !== typeof wp.media.frames.wd_upload[buttonId] ) {
				var selection = wp.media.frames.wd_upload[buttonId].state().get('selection');

				selection.add([]);
			}

			$input.val('');
			$removeButton.parents('.xts-upload-btns').siblings('.xts-upload-preview').text('');
			$removeButton.removeClass('xts-active');
		});
	});
})(jQuery);