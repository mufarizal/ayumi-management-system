import './bootstrap';
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// resources/js/app.js
import Swal from 'sweetalert2'
window.Swal = Swal

// Clock
// Clock & Greeting Functions
        function updateGreeting() {
            const hour = new Date().getHours();
            let greeting = '';

            if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
            else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
            else greeting = 'Selamat Malam';

            document.getElementById('greeting').textContent = greeting;
        }

        function updateClock() {
            const now = new Date();

            // Time
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeStr;

            // Date
            const dateStr = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('current-date').textContent = dateStr;
        }

        // Initialize Clock
        updateGreeting();
        updateClock();
        setInterval(updateClock, 1000);
        setInterval(updateGreeting, 60000);
