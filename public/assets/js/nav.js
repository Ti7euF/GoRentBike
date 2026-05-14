/**
 * Script de barra de navegación
 *
 */
//Menu hamburguesa en móvil
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


//Menú desplegable para el usuario
const userMenu = document.querySelector('.user-menu');

if (userMenu) {
    userMenu.addEventListener('click', () => {
    userMenu.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target)) {
        userMenu.classList.remove('active');
    }
    });
}

document.querySelectorAll('[name="logout"]').forEach(el => {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('form-logout').submit();
    });
});


//Cambiar el tema light/dark
function toggleTheme() {
    const html = document.documentElement;
    const isLight = html.classList.contains('light');

    if (isLight) {
        html.classList.remove('light');
        localStorage.setItem('theme', 'dark');
    } else {
        html.classList.add('light');
        localStorage.setItem('theme', 'light');
    }
}
