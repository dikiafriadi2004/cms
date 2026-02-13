// Landing Page Animations

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== Scroll Reveal Animation =====
    const revealElements = document.querySelectorAll('.reveal');
    
    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        const revealPoint = 150;
        
        revealElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            
            if (elementTop < windowHeight - revealPoint) {
                element.classList.add('active');
            }
        });
    };
    
    // Initial check
    revealOnScroll();
    
    // On scroll
    window.addEventListener('scroll', revealOnScroll);
    
    
    // ===== Stagger Animation for Items =====
    const staggerContainers = document.querySelectorAll('.stagger-container');
    
    staggerContainers.forEach(container => {
        const items = container.querySelectorAll('.stagger-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.classList.add('show');
                        }, index * 100); // 100ms delay between each item
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        
        observer.observe(container);
    });
    
    
    // ===== Counter Animation =====
    const counters = document.querySelectorAll('.counter-number');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString('id-ID');
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString('id-ID');
            }
        };
        
        updateCounter();
    };
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
    
    
    // ===== Parallax Effect =====
    const parallaxElements = document.querySelectorAll('.parallax');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = element.getAttribute('data-speed') || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
    
    
    // ===== Floating Animation for Cards =====
    const floatingCards = document.querySelectorAll('.floating-card');
    
    floatingCards.forEach((card, index) => {
        // Random delay for each card
        const delay = Math.random() * 2;
        card.style.animationDelay = `${delay}s`;
    });
    
    
    // ===== Smooth Scroll for Anchor Links =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            
            // Skip if href is just "#"
            if (href === '#') return;
            
            e.preventDefault();
            
            const target = document.querySelector(href);
            if (target) {
                const offsetTop = target.offsetTop - 80; // 80px offset for fixed header
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    
    // ===== Typing Animation =====
    const typingElements = document.querySelectorAll('.typing-text');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        element.style.display = 'inline-block';
        
        let index = 0;
        const typeSpeed = 100; // milliseconds per character
        
        const type = () => {
            if (index < text.length) {
                element.textContent += text.charAt(index);
                index++;
                setTimeout(type, typeSpeed);
            }
        };
        
        // Start typing when element is in view
        const typingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    type();
                    typingObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });
        
        typingObserver.observe(element);
    });
    
    
    // ===== Particle Background =====
    const createParticles = () => {
        const particleContainer = document.querySelector('.particles');
        if (!particleContainer) return;
        
        const particleCount = 20;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random position
            particle.style.left = Math.random() * 100 + '%';
            
            // Random size
            const size = Math.random() * 10 + 5;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Random animation duration
            const duration = Math.random() * 10 + 10;
            particle.style.animationDuration = duration + 's';
            
            // Random delay
            const delay = Math.random() * 5;
            particle.style.animationDelay = delay + 's';
            
            particleContainer.appendChild(particle);
        }
    };
    
    createParticles();
    
    
    // ===== Image Lazy Loading with Fade In =====
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                img.classList.add('animate-fade-in-up');
                imageObserver.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => {
        imageObserver.observe(img);
    });
    
    
    // ===== Navbar Background on Scroll =====
    const navbar = document.querySelector('nav');
    
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
    
    
    // ===== Button Ripple Effect =====
    const buttons = document.querySelectorAll('.btn-ripple');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    
    // ===== Tilt Effect on Cards =====
    const tiltCards = document.querySelectorAll('.tilt-card');
    
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
        });
    });
    
    
    // ===== Progress Bar Animation =====
    const progressBars = document.querySelectorAll('.progress-bar');
    
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.getAttribute('data-width');
                bar.style.width = width + '%';
                progressObserver.unobserve(bar);
            }
        });
    }, {
        threshold: 0.5
    });
    
    progressBars.forEach(bar => {
        progressObserver.observe(bar);
    });
    
    
    // ===== Scroll to Top Button =====
    const scrollTopBtn = document.querySelector('.scroll-to-top');
    
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
        
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    
    console.log('🎨 Landing page animations loaded!');
});
