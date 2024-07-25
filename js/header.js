document.addEventListener('DOMContentLoaded', function() {
	// var url = 'https://danvillehardwood.com/photo_album/';
	var url = 'http://localhost/Danville-Hardwood/photo_album/';
	if (window.location.href.indexOf(url) === 0) {
		var elementMain = document.querySelector('main#main.clearfix');
		var elementTitleBar = document.querySelector('.fusion-page-title-bar');
		if (elementMain && elementTitleBar) {
			elementMain.classList.add('photo_album');
			elementTitleBar.classList.add('photo_album');
		}
	}
});
