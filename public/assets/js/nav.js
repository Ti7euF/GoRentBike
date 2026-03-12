const toggle = document.querySelector('.menu-toggle');
const mobileMenu = document.querySelector('.mobile-menu');

toggle.addEventListener('click', () => {
	mobileMenu.classList.toggle('activo');
});

mobileMenu.querySelectorAll('a').forEach(link => {
	link.addEventListener('click', () => {
		mobileMenu.classList.remove('activo');
	});
});

document.addEventListener('click', (e) => {
	if (mobileMenu.classList.contains('activo') && !mobileMenu.contains(e.target) && !toggle.contains(e.target)) {
		mobileMenu.classList.remove('activo');
	}
});