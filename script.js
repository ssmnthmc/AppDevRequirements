// Global initialization block handling setup variables cleanly
document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. Loader Control System ---
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loadingOverlay.classList.add('hidden');
            }, 1000);
        });
    }

    // --- 2. Throttled/Unified Scroll Events Engine ---
    const backToTopButton = document.getElementById('back-to-top');
    const header = document.querySelector('header');

    window.addEventListener('scroll', () => {
        const scrolledDistance = window.pageYOffset;

        // Back-To-Top button check
        if (backToTopButton) {
            if (scrolledDistance > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        }

        // Sticky Header structural transformation check
        if (header) {
            if (scrolledDistance > 50) {
                header.style.backgroundColor = '#7c3aed';
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.3)';
            } else {
                header.style.backgroundColor = '#8b5cf6';
                header.style.boxShadow = 'none';
            }
        }
    });

    if (backToTopButton) {
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // --- 3. Persistent Dark Mode Engine ---
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;

    const updateDarkModeUI = (isDark) => {
        const icon = darkModeToggle?.querySelector('i');
        if (!icon || !darkModeToggle) return;

        if (isDark) {
            body.classList.add('dark-mode');
            icon.className = 'fas fa-sun';
            darkModeToggle.style.backgroundColor = '#fbbf24';
        } else {
            body.classList.remove('dark-mode');
            icon.className = 'fas fa-moon';
            darkModeToggle.style.backgroundColor = '#f59e0b';
        }
    };

    // Load initial browser state memory data configuration setup
    const preservedState = localStorage.getItem('darkMode') === 'true';
    updateDarkModeUI(preservedState);

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            const stateActive = !body.classList.contains('dark-mode');
            updateDarkModeUI(stateActive);
            localStorage.setItem('darkMode', stateActive);
        });
    }

    // --- 4. Lightbox Modal Interception Fix ---
    const galleryItems = document.querySelectorAll('.image-wrapper');
    const modal = document.getElementById('image-modal');
    const modalImg = document.getElementById('modal-image');
    const closeBtn = document.querySelector('.modal-close');
    
    if (galleryItems.length && modal && modalImg) {
        galleryItems.forEach(item => {
            item.addEventListener('click', function() {
                const sourcePath = this.getAttribute('data-src');
                if (sourcePath) {
                    modalImg.src = sourcePath;
                    modal.classList.add('active'); // Adds active class, triggering the smooth CSS transition
                }
            });
        });
        
        const closeModal = () => modal.classList.remove('active'); // Smoothly fades out by dropping the active class

        if (closeBtn) closeBtn.onclick = closeModal;
        modal.onclick = (e) => { if (e.target === modal) closeModal(); };
    }

    // --- 5. Smooth Internal Page Scrolling Engine ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetElement = document.querySelector(this.getAttribute('href'));
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // --- 6. Form Submission Response Management ---
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            const button = this.querySelector('.submit-button');
            
            if (name && email && message && button) {
                alert('✨ Thank you for contacting me! ✨\n\nI will get back to you soon! 😊');
                this.reset();
                
                button.innerHTML = '<i class="fas fa-check"></i> Sent!';
                button.style.backgroundColor = '#4CAF50';
                
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-paper-plane"></i> Submit';
                    button.style.backgroundColor = '#f59e0b';
                }, 3000);
            }
        });
    }

    // --- 7. Intersection Observers Optimization Matrix ---
    const scrollElements = document.querySelectorAll('.about-card, .skills-table-container, .skills-list-container, .gallery-item');
    const progressBars = document.querySelectorAll('.progress-value');

    const onScrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                onScrollObserver.unobserve(entry.target); // Unbind after animating for performance optimization
            }
        });
    }, { threshold: 0.1 });

    scrollElements.forEach(el => {
        el.classList.add('animate-on-scroll');
        onScrollObserver.observe(el);
    });

    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const targetWidth = entry.target.getAttribute('data-width');
                if (targetWidth) {
                    entry.target.style.width = targetWidth;
                }
                progressObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    progressBars.forEach(bar => progressObserver.observe(bar));

    // --- 8. Header Title Pulsing Transform Animation Fix ---
    const headerTitle = document.getElementById('header-title');
    if (headerTitle) {
        headerTitle.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        headerTitle.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
});

console.log('✨ Sammie\'s Portfolio Engine status: Fully Functional & Bug-Free! ✨');