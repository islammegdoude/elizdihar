/* global woodmartConfig */
/* global woodmart_patch_notice */

(function($) {
	'use strict';

	$(document).on('click', '.xts-patch-apply', function (e) {
		e.preventDefault();

		var $this = $(this);
		var patchesMap = $this.data('patches-map');
		var fileMap = [];

		for(var i = 0; i < patchesMap.length; i++) {
			fileMap[i] = 'woodmart/' + patchesMap[i];
		}

		var confirmation = confirm( `${woodmart_patch_notice.single_patch_confirm} \r\r\n` + fileMap.join('\r\n') );

		if ( ! confirmation ) {
			return;
		}

		addLoading();
		cleanNotice();

		sendAjax($this.data('id'), function(response) {
            if ( 'undefined' !== typeof response.message ) {
                printNotice(response.status, response.message);
            }

            if ( 'undefined' !== typeof response.status && 'success' === response.status ) {
                $this.parents('.xts-patch-item').addClass('xts-applied');
                updatePatcherCounter();
            }

            removeLoading();
        });
	});

	$(document).on('click', '.xts-patch-apply-all', function (e) {
		e.preventDefault();

		var $applyAllBtn = $(this);
        var $patches     = $('.xts-patch-item:not(.xts-table-row-heading):not(.xts-applied)').get();

		cleanNotice();

		if ( 0 === $patches.length ) {
			printNotice('success', woodmart_patch_notice.all_patches_applied);
			return;
		}

		if ( ! confirm(woodmart_patch_notice.all_patches_confirm) ) {
			return;
		}

		$applyAllBtn.parent().addClass('xts-loading');
        addLoading();
        recursiveApply($patches);
	});

    function recursiveApply($patches){
        var $applyAllBtn = $('.xts-patch-apply-all');

        if ( 0 === $patches.length ) {
            $applyAllBtn.parent().addClass('xts-applied');
            $applyAllBtn.parent().removeClass('xts-loading');
            removeLoading();

            return;
        }

        var $patch = $($patches.pop());
        var id     = $patch.find('.xts-patch-apply').data('id');

        sendAjax(id , function(response) {
            if ( 'undefined' !== typeof response.message && 'error' === response.status ) {
				$applyAllBtn.parent().removeClass('xts-loading');
                printNotice(response.status, response.message);
            }

			if ( 0 === $patches.length ) {
				printNotice('success', woodmart_patch_notice.all_patches_applied);
			}

            if ( 'undefined' !== typeof response.status && 'success' === response.status ) {
                $patch.addClass('xts-applied');
				updatePatcherCounter();

                recursiveApply($patches);
            } else {
                removeLoading();
            }
        });
    }

	function sendAjax(id, cb) {
		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			data   : {
				action   : 'woodmart_patch_action',
				security : woodmartConfig.patcher_nonce,
				id,
			},
			timeout: 1000000,
			error  : function() {
				printNotice('error', woodmart_patch_notice.ajax_error);
			},
			success: cb
		});
	}

	// Helpers.
	function printNotice(type, message) {
		$('.xts-notices-wrapper').append(`
			<div class="xts-notice xts-${type}">
				${message}
			</div>
		`);

		setTimeout(function(){
			$('.xts-notice').addClass('xts-hidden');
		}, 7000);
	}

	function cleanNotice() {
		$('.xts-notices-wrapper').text('');
	}

	function addLoading() {
		$('.xts-box-content').addClass('xts-loading');
		$('.xts-patch-apply-all').addClass('xts-disabled');
	}

	function removeLoading() {
		$('.xts-box-content').removeClass('xts-loading');
		$('.xts-patch-apply-all').removeClass('xts-disabled');
	}

	function updatePatcherCounter() {
		var $counters = document.querySelectorAll('.xts-patcher-counter');

		$counters.forEach( $counter => {
			if ( null === $counter) {
				return;
			}

			var $count = parseInt($counter.querySelector('.patcher-count').innerText);

			if ( 1 === $count ) {
				$counter.classList.add('xts-hidden');
			} else {
				$counter.querySelector('.patcher-count').innerText = --$count;
			}
		});
	}

})(jQuery);