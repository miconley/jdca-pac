/**
 * Mobile Navigation JavaScript
 * Handles mobile menu toggle functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu');
    const mobileNavMenu = document.getElementById('mobile-nav-menu');
    const header = document.querySelector('.header');
    const body = document.body;
    
    if (!mobileMenuButton || !mobileNavMenu || !header) return;
    
    // Set header height CSS variable
    function setHeaderHeight() {
        const headerHeight = header.offsetHeight;
        document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
    }
    
    // Initialize header height
    setHeaderHeight();
    
    // Calculate mobile nav height for content pushing
    function calculateNavHeight() {
        if (mobileNavMenu.classList.contains('open')) {
            // Wait for CSS transition to complete, then measure actual height
            setTimeout(() => {
                const navHeight = mobileNavMenu.scrollHeight;
                document.documentElement.style.setProperty('--mobile-nav-height', navHeight + 'px');
            }, 50);
        } else {
            document.documentElement.style.setProperty('--mobile-nav-height', '0px');
        }
    }
    
    // Open mobile navigation
    function openMobileNav() {
        mobileNavMenu.classList.add('open');
        body.classList.add('mobile-nav-open');
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        
        // Calculate height after opening
        calculateNavHeight();
        
        // Prevent body scroll
        body.style.overflow = 'hidden';
    }
    
    // Close mobile navigation
    function closeMobileNav() {
        mobileNavMenu.classList.remove('open');
        body.classList.remove('mobile-nav-open');
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        
        // Reset height
        calculateNavHeight();
        
        // Restore body scroll
        body.style.overflow = '';
    }
    
    // Toggle mobile navigation
    function toggleMobileNav() {
        if (mobileNavMenu.classList.contains('open')) {
            closeMobileNav();
        } else {
            openMobileNav();
        }
    }
    
    // Mobile menu button click handler
    mobileMenuButton.addEventListener('click', function(e) {
        e.preventDefault();
        toggleMobileNav();
    });
    
    // Mobile nav close button click handler
    const mobileNavCloseButton = document.querySelector('.mobile-close-button');
    if (mobileNavCloseButton) {
        mobileNavCloseButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileNav();
        });
    }
    
    // Close mobile nav when clicking on menu links
    const mobileNavLinks = mobileNavMenu.querySelectorAll('a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Close nav after a short delay to allow for page navigation
            setTimeout(closeMobileNav, 100);
        });
    });
    
    // Close mobile nav on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNavMenu.classList.contains('open')) {
            closeMobileNav();
        }
    });
    
    // Handle window resize - close mobile nav if window becomes large and recalculate header height
    window.addEventListener('resize', function() {
        setHeaderHeight();
        if (window.innerWidth >= 769 && mobileNavMenu.classList.contains('open')) {
            closeMobileNav();
        }
    });
    
    // Initialize aria-expanded attribute
    mobileMenuButton.setAttribute('aria-expanded', 'false');
});