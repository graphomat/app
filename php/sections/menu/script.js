document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSearch();
    initStickyHeader();
    initSubmenuAccessibility();
});

function initMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.site-nav');
    const submenuButtons = document.querySelectorAll('.has-submenu > .menu-link');
    
    if (!menuToggle || !nav) return;

    menuToggle.addEventListener('click', function() {
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
        nav.classList.toggle('active');
        
        // Prevent body scroll when menu is open
        document.body.style.overflow = !isExpanded ? 'hidden' : '';
    });

    // Handle submenu on mobile
    submenuButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parent = this.parentElement;
                const isExpanded = parent.getAttribute('aria-expanded') === 'true';
                
                // Close other open submenus
                submenuButtons.forEach(btn => {
                    if (btn !== this) {
                        btn.parentElement.setAttribute('aria-expanded', 'false');
                    }
                });
                
                parent.setAttribute('aria-expanded', !isExpanded);
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && 
            !nav.contains(e.target) && 
            !menuToggle.contains(e.target) && 
            nav.classList.contains('active')) {
            menuToggle.setAttribute('aria-expanded', 'false');
            nav.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

function initSearch() {
    const searchToggle = document.querySelector('.search-toggle');
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-form input[type="search"]');
    
    if (!searchToggle || !searchForm) return;

    searchToggle.addEventListener('click', function(e) {
        e.preventDefault();
        const isActive = searchForm.classList.contains('active');
        
        searchForm.classList.toggle('active');
        this.setAttribute('aria-expanded', !isActive);
        
        if (!isActive && searchInput) {
            searchInput.focus();
        }
    });

    // Close search when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchToggle.contains(e.target) && 
            !searchForm.contains(e.target) && 
            searchForm.classList.contains('active')) {
            searchForm.classList.remove('active');
            searchToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Close search on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchForm.classList.contains('active')) {
            searchForm.classList.remove('active');
            searchToggle.setAttribute('aria-expanded', 'false');
            searchToggle.focus();
        }
    });
}

function initStickyHeader() {
    const header = document.querySelector('.site-header');
    if (!header || header.getAttribute('data-sticky') !== 'true') return;

    let lastScroll = 0;
    const scrollThreshold = 50;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Add box-shadow when scrolled
        header.classList.toggle('scrolled', currentScroll > 0);

        // Hide/show header based on scroll direction
        if (Math.abs(currentScroll - lastScroll) < scrollThreshold) return;

        if (currentScroll > lastScroll && currentScroll > header.offsetHeight) {
            // Scrolling down
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            header.style.transform = 'translateY(0)';
        }

        lastScroll = currentScroll;
    }, { passive: true });
}

function initSubmenuAccessibility() {
    const submenuButtons = document.querySelectorAll('.has-submenu > .menu-link');
    
    submenuButtons.forEach(button => {
        // Set initial ARIA attributes
        button.setAttribute('role', 'button');
        button.setAttribute('aria-expanded', 'false');
        
        // Handle keyboard navigation
        button.addEventListener('keydown', function(e) {
            const submenu = this.nextElementSibling;
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            switch (e.key) {
                case ' ':
                case 'Enter':
                    e.preventDefault();
                    this.setAttribute('aria-expanded', !isExpanded);
                    if (!isExpanded && submenu) {
                        const firstLink = submenu.querySelector('a');
                        if (firstLink) firstLink.focus();
                    }
                    break;
                    
                case 'Escape':
                    if (isExpanded) {
                        e.preventDefault();
                        this.setAttribute('aria-expanded', 'false');
                        this.focus();
                    }
                    break;
            }
        });
        
        // Handle mouse interactions
        button.addEventListener('mouseenter', function() {
            this.setAttribute('aria-expanded', 'true');
        });
        
        button.parentElement.addEventListener('mouseleave', function() {
            const button = this.querySelector('.menu-link');
            button.setAttribute('aria-expanded', 'false');
        });
    });

    // Handle focus trap in submenus
    const submenus = document.querySelectorAll('.submenu');
    submenus.forEach(submenu => {
        const links = submenu.querySelectorAll('a');
        if (links.length === 0) return;
        
        const firstLink = links[0];
        const lastLink = links[links.length - 1];
        
        firstLink.addEventListener('keydown', function(e) {
            if (e.key === 'Tab' && e.shiftKey) {
                e.preventDefault();
                lastLink.focus();
            }
        });
        
        lastLink.addEventListener('keydown', function(e) {
            if (e.key === 'Tab' && !e.shiftKey) {
                e.preventDefault();
                firstLink.focus();
            }
        });
    });
}
