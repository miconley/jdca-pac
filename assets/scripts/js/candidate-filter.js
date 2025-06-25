/**
 * Candidate Filter JavaScript
 * Handles candidate filtering functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('candidate-filter-form');
    const clearButton = document.getElementById('clear-filters');
    const checkboxes = document.querySelectorAll('.term-checkbox');
    const caretButtons = document.querySelectorAll('.caret');
    const toggleButton = document.querySelector('.candidate-filter-toggle');
    const closeButton = document.querySelector('.candidate-filter-header .close');
    const filterAside = document.querySelector('.candidate_filter');
    const mobileApplyButton = document.getElementById('mobile-apply-filters');
    
    if (!filterForm) return;
    
    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth < 769;
    }
    
    // Update URL parameters when checkboxes change
    function updateURL() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        // Group values by taxonomy name (removing [] from form names)
        for (let pair of formData.entries()) {
            const [name, value] = pair;
            // Remove [] from the name to get clean taxonomy name
            const cleanName = name.replace('[]', '');
            
            if (params.has(cleanName)) {
                // If parameter already exists, append to array
                const existing = params.get(cleanName);
                params.set(cleanName, existing + ',' + value);
            } else {
                params.set(cleanName, value);
            }
        }
        
        // Build final URL parameters
        const finalParams = new URLSearchParams();
        for (let [key, value] of params.entries()) {
            if (value.includes(',')) {
                // Multiple values - add as array
                const values = value.split(',');
                values.forEach(val => finalParams.append(key + '[]', val));
            } else {
                // Single value - add as array for consistency
                finalParams.append(key + '[]', value);
            }
        }
        
        return finalParams.toString();
    }
    
    // Auto-apply filters when checkbox changes
    function applyFilters() {
        const queryString = updateURL();
        let url = filterForm.action;
        
        if (queryString) {
            url += '?' + queryString;
        }
        
        window.location.href = url;
    }
    
    // Handle clear filters button
    if (clearButton) {
        clearButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Uncheck all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Redirect to clean URL
            window.location.href = filterForm.action;
        });
    }
    
    // Update filter state and visual feedback
    function updateFilterState() {
        const checkedBoxes = document.querySelectorAll('.term-checkbox:checked');
        const hasFilters = checkedBoxes.length > 0;
        
        // Update clear button state
        if (clearButton) {
            clearButton.disabled = !hasFilters;
            clearButton.style.opacity = hasFilters ? '1' : '0.5';
        }
        
        // Update mobile apply button state
        if (mobileApplyButton) {
            mobileApplyButton.disabled = !hasFilters;
            mobileApplyButton.innerHTML = '✓ Save';
        }
        
        // Add visual indicators to sections with active filters
        document.querySelectorAll('.taxonomy-section').forEach(section => {
            const sectionCheckboxes = section.querySelectorAll('.term-checkbox:checked');
            section.classList.toggle('has-active-filters', sectionCheckboxes.length > 0);
        });
    }
    
    // Listen for checkbox changes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateFilterState();
            
            // Only auto-apply on desktop, not mobile
            if (!isMobile()) {
                // Auto-apply filters after a short delay to allow for multiple selections
                setTimeout(applyFilters, 300);
            }
        });
    });
    
    // Handle expand/collapse functionality for filter sections
    function toggleSection(caretButton) {
        const section = caretButton.closest('.taxonomy-section');
        const termsList = section.querySelector('.taxonomy-terms');
        const isOpen = caretButton.classList.contains('open');
        
        if (isOpen) {
            // Collapse the section
            caretButton.classList.remove('open');
            caretButton.classList.add('closed');
            section.classList.add('collapsed');
        } else {
            // Expand the section
            caretButton.classList.remove('closed');
            caretButton.classList.add('open');
            section.classList.remove('collapsed');
        }
    }
    
    // Add click event listeners to caret buttons
    caretButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSection(this);
        });
    });
    
    // Initialize sections based on device type
    function initializeSections() {
        caretButtons.forEach(button => {
            const section = button.closest('.taxonomy-section');
            
            if (isMobile()) {
                // On mobile, start collapsed
                button.classList.remove('open');
                button.classList.add('closed');
                section.classList.add('collapsed');
            } else {
                // On desktop, start expanded
                button.classList.add('open');
                button.classList.remove('closed');
                section.classList.remove('collapsed');
            }
        });
    }
    
    // Initialize sections on page load
    initializeSections();
    
    // Mobile filter toggle functionality
    function openMobileFilter() {
        if (filterAside) {
            filterAside.classList.add('open');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
        }
    }
    
    function closeMobileFilter() {
        if (filterAside) {
            filterAside.classList.remove('open');
            document.body.style.overflow = ''; // Restore body scroll
        }
    }
    
    // Toggle button event listener
    if (toggleButton) {
        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            openMobileFilter();
        });
    }
    
    // Close button event listener
    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileFilter();
        });
    }
    
    // Close filter when clicking outside on mobile
    if (filterAside) {
        filterAside.addEventListener('click', function(e) {
            // Only close if clicking on the backdrop (the aside itself, not its children)
            if (e.target === filterAside) {
                closeMobileFilter();
            }
        });
    }
    
    // Close filter on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && filterAside && filterAside.classList.contains('open')) {
            closeMobileFilter();
        }
    });
    
    // Mobile apply button event listener
    if (mobileApplyButton) {
        mobileApplyButton.addEventListener('click', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }
    
    // Initialize filter state
    updateFilterState();
    
    // Handle window resize - reinitialize sections if device type changes
    window.addEventListener('resize', function() {
        initializeSections();
    });
    
    // Handle form submission
    filterForm.addEventListener('submit', function(e) {
        // On mobile, allow form submission, on desktop prevent it
        if (!isMobile()) {
            e.preventDefault();
        } else {
            // Let mobile form submit normally
            applyFilters();
            e.preventDefault(); // Still prevent to use our custom navigation
        }
    });
});