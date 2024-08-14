document.addEventListener('DOMContentLoaded', function() {
	var accordionToggle = document.querySelector('.accordion-toggle');

	if (accordionToggle) {
		accordionToggle.addEventListener('click', function() {
			var tabBar = document.querySelector('.tab-bar');
			var isOpen = tabBar.classList.toggle('open');

			accordionToggle.setAttribute('aria-expanded', isOpen);

			var arrowDown = document.querySelector('.arrow-down');
			var arrowUp = document.querySelector('.arrow-up');
			if (isOpen) {
				arrowDown.style.display = 'none';
				arrowUp.style.display = 'block';
			} else {
				arrowDown.style.display = 'block';
				arrowUp.style.display = 'none';
			}
		});
	} else {
		console.log("Element with class 'accordion-toggle' not found");
	}
});
