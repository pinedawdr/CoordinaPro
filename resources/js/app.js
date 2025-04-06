import './bootstrap';
import Alpine from 'alpinejs';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@popperjs/core';
import 'bootstrap-icons/font/bootstrap-icons.css';

window.Alpine = Alpine;

Alpine.start();

// Añadir animaciones y mejoras de UI
document.addEventListener('DOMContentLoaded', function() {
    // Destacar filas de tabla al pasar el mouse
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('bg-light', 'transition-colors', 'duration-150');
        });
        row.addEventListener('mouseleave', () => {
            row.classList.remove('bg-light');
        });
    });

    // Animación para mensajes flash
    const flashMessages = document.querySelectorAll('[role="alert"]');
    flashMessages.forEach(message => {
        // Añadir animación
        message.classList.add('scale-in');
        
        // Autoclose después de 5 segundos
        setTimeout(() => {
            message.style.transition = 'all 0.5s ease-out';
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 500);
        }, 5000);
    });

    // Animación para las cards al cargar
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        card.style.transition = 'all 0.3s ease-out';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * (index + 1)); // Efecto cascada
    });

    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Efecto de hover en botones
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-2px)';
        });
        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translateY(0)';
        });
    });

    // Efecto de hover en cards
    const allCards = document.querySelectorAll('.card');
    allCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = 'var(--box-shadow-hover)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = 'var(--box-shadow)';
        });
    });

    // Efecto de hover en enlaces de navegación
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.style.backgroundColor = 'rgba(99, 102, 241, 0.1)';
        });
        link.addEventListener('mouseleave', () => {
            if (!link.classList.contains('active')) {
                link.style.backgroundColor = 'transparent';
            }
        });
    });
    
    // Efecto de hover en badges
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', () => {
            badge.style.transform = 'scale(1.05)';
        });
        badge.addEventListener('mouseleave', () => {
            badge.style.transform = 'scale(1)';
        });
    });
    
    // Efecto de hover en dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', () => {
            dropdown.style.backgroundColor = 'rgba(99, 102, 241, 0.05)';
        });
        dropdown.addEventListener('mouseleave', () => {
            dropdown.style.backgroundColor = 'transparent';
        });
    });
    
    // Efecto de hover en formularios
    const formControls = document.querySelectorAll('.form-control');
    formControls.forEach(control => {
        control.addEventListener('focus', () => {
            control.style.transform = 'translateY(-2px)';
        });
        control.addEventListener('blur', () => {
            control.style.transform = 'translateY(0)';
        });
    });
    
    // Efecto de hover en calendario
    const calendarDays = document.querySelectorAll('.calendar-day');
    calendarDays.forEach(day => {
        day.addEventListener('mouseenter', () => {
            day.style.transform = 'scale(1.1)';
        });
        day.addEventListener('mouseleave', () => {
            day.style.transform = 'scale(1)';
        });
    });
    
    // Efecto de hover en alertas
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.addEventListener('mouseenter', () => {
            alert.style.transform = 'translateY(-2px)';
        });
        alert.addEventListener('mouseleave', () => {
            alert.style.transform = 'translateY(0)';
        });
    });
    
    // Efecto de hover en tablas
    const tables = document.querySelectorAll('.table');
    tables.forEach(table => {
        table.addEventListener('mouseenter', () => {
            table.style.boxShadow = 'var(--box-shadow-hover)';
        });
        table.addEventListener('mouseleave', () => {
            table.style.boxShadow = 'var(--box-shadow)';
        });
    });

    // Animaciones para elementos que entran en viewport
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.card, .table-container, .calendar-container').forEach(el => {
        observer.observe(el);
    });
});
