import './bootstrap';
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// resources/js/app.js
import Swal from 'sweetalert2'
window.Swal = Swal
