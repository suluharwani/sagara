(function () {
    'use strict';

    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.getAttribute('data-target'));
            if (!input) return;

            var isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';
            button.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
            button.setAttribute('aria-label', isVisible ? 'Tampilkan password' : 'Sembunyikan password');

            var icon = button.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye', isVisible);
                icon.classList.toggle('fa-eye-slash', !isVisible);
            }
        });
    });
}());
