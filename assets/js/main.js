/**
 * One Woman Job - Main JavaScript
 *
 * @package OneWomanJob
 */

(function() {
    'use strict';

    // ==================== NAVBAR SCROLL EFFECT ====================
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // ==================== MOBILE MENU ====================
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close mobile menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });
    }

    // ==================== SCROLL ANIMATIONS ====================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate').forEach(el => {
        observer.observe(el);
    });

    // ==================== AUTO-ROTATING SLIDER ====================
    const slider = document.getElementById('workSlider');
    const dotsContainer = document.getElementById('sliderDots');

    if (slider && dotsContainer) {
        const slides = slider.querySelectorAll('.work-slide');
        let currentIndex = 0;
        let autoSlideInterval;
        let isPaused = false;

        function getSlideWidth() {
            const slide = slides[0];
            if (!slide) return 0;
            const width = slide.offsetWidth;
            const gap = 20;
            return width + gap;
        }

        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.classList.add('slider-dot');
            dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });

        const dots = dotsContainer.querySelectorAll('.slider-dot');

        function updateDots() {
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function goToSlide(index) {
            currentIndex = index;
            const slideWidth = getSlideWidth();
            slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            updateDots();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            goToSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            goToSlide(currentIndex);
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                if (!isPaused) {
                    nextSlide();
                }
            }, 4000);
        }

        slider.addEventListener('mouseenter', () => { isPaused = true; });
        slider.addEventListener('mouseleave', () => { isPaused = false; });

        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;

        slider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            isPaused = true;
        });

        slider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            isPaused = false;
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        window.addEventListener('resize', () => {
            goToSlide(currentIndex);
        });

        startAutoSlide();
    }

    // ==================== SMOOTH SCROLL FOR NAV LINKS ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = target.offsetTop - navHeight - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

})();
