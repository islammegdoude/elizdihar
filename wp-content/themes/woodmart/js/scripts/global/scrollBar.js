var observer = new MutationObserver(() => {
	if ( window.innerWidth > document.getElementsByTagName( 'html' )[0].offsetWidth ) {
		document.getElementsByTagName( 'html' )[0].className += ' wd-scrollbar';
		observer.disconnect();
	}
});

window.addEventListener('load',function() {
	observer.disconnect();
});

observer.observe(document.getElementsByTagName( 'html' )[0], {childList : true,  subtree: true});
