document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;

    let overlay = document.querySelector('.nav-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.classList.add('nav-overlay');
        document.body.appendChild(overlay);
    }

    function toggleMenu() {
        navLinks.classList.toggle('active');
        overlay.classList.toggle('active');
        body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';

        const icon = menuToggle?.querySelector('i');
        if (icon) {
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMenu();
        });
    }

    overlay.addEventListener('click', function() {
        toggleMenu();
    });

    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function() {
            if (navLinks.classList.contains('active')) {
                toggleMenu();
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (navLinks?.classList.contains('active') &&
            !navLinks.contains(e.target) &&
            !menuToggle?.contains(e.target)) {
            toggleMenu();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && navLinks?.classList.contains('active')) {
            toggleMenu();
        }
    });

    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a');

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (window.scrollY >= (sectionTop - 100)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card, .project-card, .certification-card, .education-item').forEach(el => {
        observer.observe(el);
    });

    const techIcons = [
        '🤖', '🧠', '⚡', '💻', '📊', '📈', '🔬', '🧮', '🔢', '🧪',
        '📡', '🖥️', '💾', '🧬', '🔍', '🎯', '🔮', '💡', '🔧', '⚙️',
        '🔄', '📱', '🌐', '🛠️', '🎮', '🚀', '💎', '🎲', '🔐', '🔗',
        '🧩', '🎪', '🏆', '🎨', '✨', '🌟', '💫', '☄️', '🌌', '🪐'
    ];

    const techIconClasses = [
        'fas fa-robot', 'fas fa-brain', 'fas fa-microchip', 'fas fa-code',
        'fas fa-database', 'fas fa-chart-line', 'fas fa-cogs', 'fas fa-network-wired',
        'fas fa-server', 'fas fa-laptop-code', 'fas fa-cloud', 'fas fa-magic',
        'fas fa-bolt', 'fas fa-filter', 'fas fa-project-diagram', 'fas fa-stream',
        'fas fa-sitemap', 'fas fa-cube', 'fas fa-shield-alt', 'fas fa-key'
    ];

    const floatingIconsContainer = document.getElementById('floating-icons');
    const particlesContainer = document.getElementById('particles');

    function generateFloatingIcons() {
        if (!floatingIconsContainer) return;
        const numIcons = 40;
        for (let i = 0; i < numIcons; i++) {
            const icon = document.createElement('div');
            icon.classList.add('icon');

            if (Math.random() > 0.5) {
                icon.textContent = techIcons[Math.floor(Math.random() * techIcons.length)];
            } else {
                const iconClass = techIconClasses[Math.floor(Math.random() * techIconClasses.length)];
                icon.innerHTML = `<i class="${iconClass}"></i>`;
            }

            icon.style.left = `${Math.random() * 100}%`;
            icon.style.top = `${Math.random() * 100}%`;
            icon.style.animationDelay = `${Math.random() * 20}s`;

            floatingIconsContainer.appendChild(icon);
        }
    }

    function generateParticles() {
        if (!particlesContainer) return;
        const numParticles = 60;
        for (let i = 0; i < numParticles; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            particle.style.animationDelay = `${Math.random() * 15}s`;
            particle.style.opacity = `${0.05 + Math.random() * 0.1}`;
            particlesContainer.appendChild(particle);
        }
    }

    generateFloatingIcons();
    generateParticles();

    function sparkleEffect() {
        const icons = document.querySelectorAll('.icon');
        if (icons.length === 0) return;
        const randomIcon = icons[Math.floor(Math.random() * icons.length)];
        randomIcon.style.opacity = '0.4';
        randomIcon.style.transform = 'scale(1.5)';
        randomIcon.style.filter = 'blur(0px) drop-shadow(0 0 8px var(--accent-primary))';

        setTimeout(() => {
            randomIcon.style.opacity = '';
            randomIcon.style.transform = '';
            randomIcon.style.filter = '';
        }, 1000);

        setTimeout(sparkleEffect, 3000 + Math.random() * 5000);
    }
    setTimeout(sparkleEffect, 5000);

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.borderColor = 'var(--accent-primary)';
            this.style.boxShadow = '0 10px 30px rgba(76, 179, 205, 0.15)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.borderColor = '';
            this.style.boxShadow = '';
        });
    });

    const yearSpan = document.getElementById('current-year');
    if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
    }

    setTimeout(() => {
        document.querySelectorAll('.animate-on-load').forEach(el => {
            el.classList.add('animate-in');
        });
    }, 100);
});