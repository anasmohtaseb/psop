// Palestine Science Olympiad Portal - Main JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Form validation helper
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger-color)';
                } else {
                    field.style.borderColor = '';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
            }
        });
    });

    // Dropdown menu toggle
    const userMenus = document.querySelectorAll('.user-menu');
    userMenus.forEach(menu => {
        menu.addEventListener('click', function() {
            const dropdown = this.querySelector('.dropdown');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        });
    });

    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navLinks = document.getElementById('navLinks');

    if (mobileMenuToggle && navLinks) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Close menu when clicking on a link
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (navLinks.classList.contains('active') && 
                !navLinks.contains(event.target) && 
                !mobileMenuToggle.contains(event.target)) {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-menu')) {
            document.querySelectorAll('.dropdown.show').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Sticky Header Effect
    initStickyHeader();
});

// ====================================
// Sticky Header on Scroll
// ====================================
function initStickyHeader() {
    const header = document.querySelector('header');
    if (!header) return;

    let ticking = false;

    function updateHeader() {
        const currentScroll = window.pageYOffset;

        // Add scrolled class for styling
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
        }
    });
}

// Hero Slider Functionality
let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    
    if (!slides.length) return;
    
    // Wrap around
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }
    
    // Update slides
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === currentSlide) {
            slide.classList.add('active');
        }
    });
    
    // Update dots
    dots.forEach((dot, i) => {
        dot.classList.remove('active');
        if (i === currentSlide) {
            dot.classList.add('active');
        }
    });
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
    resetSlideInterval();
}

function goToSlide(index) {
    showSlide(index);
    resetSlideInterval();
}

function resetSlideInterval() {
    clearInterval(slideInterval);
    startSlideInterval();
}

function startSlideInterval() {
    slideInterval = setInterval(() => {
        showSlide(currentSlide + 1);
    }, 5000); // Change slide every 5 seconds
}

// Initialize slider when page loads
if (document.querySelector('.hero-slider')) {
    showSlide(0);
    startSlideInterval();
    
    const slider = document.querySelector('.hero-slider');
    
    // Pause on hover (desktop)
    slider.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });
    
    slider.addEventListener('mouseleave', () => {
        startSlideInterval();
    });
    
    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        clearInterval(slideInterval);
    }, { passive: true });
    
    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startSlideInterval();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next slide
                changeSlide(1);
            } else {
                // Swipe right - previous slide
                changeSlide(-1);
            }
        }
    }
}

// ====================================
// Animated Counter for Stats
// ====================================
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16); // 60fps
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Intersection Observer for counter animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
};

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            const target = entry.target.textContent.replace(/[^0-9]/g, '');
            const suffix = entry.target.textContent.replace(/[0-9]/g, '');
            
            if (target) {
                const targetNumber = parseInt(target);
                entry.target.textContent = '0' + suffix;
                
                setTimeout(() => {
                    animateCounter(entry.target, targetNumber, 2000);
                    // Add suffix back after animation
                    setTimeout(() => {
                        entry.target.textContent = targetNumber + suffix;
                    }, 2000);
                }, 200);
            }
        }
    });
}, observerOptions);

// Observe all stat numbers
document.addEventListener('DOMContentLoaded', () => {
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        counterObserver.observe(stat);
    });
});
