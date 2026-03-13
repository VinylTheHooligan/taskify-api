import './stimulus_bootstrap.js';
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';

function initToasts() {
    document.querySelectorAll('.toast').forEach(toastEl => {
        new bootstrap.Toast(toastEl, { delay: 4000 }).show();
    });
}

// Chargement initial
document.addEventListener('DOMContentLoaded', initToasts);

// Navigation via Turbo
document.addEventListener('turbo:load', initToasts);
document.addEventListener('turbo:render', initToasts);