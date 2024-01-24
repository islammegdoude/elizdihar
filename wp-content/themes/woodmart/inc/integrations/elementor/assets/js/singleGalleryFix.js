addEventListener('elementor/device-mode/change', function() {
	const editor = elementor.getPanelView().getCurrentPageView();

	if ( editor ) {
		var elementView = editor.getOption('editedElementView');

		if ( elementView && 'undefined' !== typeof elementView.model.attributes && 'wd_single_product_gallery' === elementView.model.attributes.widgetType ) {
			elementView.model.renderRemoteServer();
		}
	}
});