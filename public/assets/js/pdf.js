document.addEventListener("DOMContentLoaded", () => {

    const form = document.querySelector('form[data-export-pdf="true"]');
    if (!form) {
        return;
    }

    form.addEventListener('submit', function () {
        const table = document.querySelector('table');
        const headerTitle = document.querySelector('header.titulo h2');

        form.querySelector('input[name="html"]').value =
            table ? table.outerHTML : '';

        form.querySelector('input[name="title"]').value =
            headerTitle ? headerTitle.textContent.trim() : 'Exportación';
    });
});
