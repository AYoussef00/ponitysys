// CSRF Token Setup for jQuery AJAX
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// Sidebar Toggle for Mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.app-sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = sidebar.contains(event.target) || sidebarToggle.contains(event.target);

        if (!isClickInside && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });
});

// Dropdown Menu Animation
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const menu = dropdown.querySelector('.dropdown-menu');

    if (menu) {
        dropdown.addEventListener('show.bs.dropdown', function() {
            menu.classList.add('animate__animated', 'animate__fadeIn', 'animate__faster');
        });

        dropdown.addEventListener('hide.bs.dropdown', function() {
            menu.classList.remove('animate__animated', 'animate__fadeIn', 'animate__faster');
        });
    }
});

// Active Link Highlight
const currentPath = window.location.pathname;
const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
    }
});

// Theme Toggle (if implemented)
const themeToggle = document.querySelector('.theme-toggle');

if (themeToggle) {
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        document.documentElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
}

// Initialize theme from localStorage
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
}

// Loading State Handler
function showLoading(element) {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = '<div class="loading-spinner"></div>';

    element.style.position = 'relative';
    element.appendChild(overlay);
}

function hideLoading(element) {
    const overlay = element.querySelector('.loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Example usage:
// const cardElement = document.querySelector('.card');
// showLoading(cardElement);
// setTimeout(() => hideLoading(cardElement), 2000);
