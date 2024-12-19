/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// assets/js/app.js

import '../scss/app.scss';
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
document.querySelectorAll('.info-btn').forEach(button => {
    button.addEventListener('click', function () {
        const modalId = `modal-${this.dataset.jeu}`;
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    });
});

document.querySelectorAll('.modal .close').forEach(button => {
    button.addEventListener('click', function () {
        this.closest('.modal').style.display = 'none';
    });
});

window.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal')) {
        e.target.style.display = 'none';
    }
});
