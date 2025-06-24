/**
 * Candidate Filter JavaScript
 * Handles candidate filtering functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('candidate-filter-form');
    const clearButton = document.getElementById('clear-filters');
    const checkboxes = document.querySelectorAll('.term-checkbox');
    
    if (!filterForm) return;
    
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
        
        // Add visual indicators to sections with active filters
        document.querySelectorAll('.taxonomy-section').forEach(section => {
            const sectionCheckboxes = section.querySelectorAll('.term-checkbox:checked');
            section.classList.toggle('has-active-filters', sectionCheckboxes.length > 0);
        });
    }
    
    // Listen for checkbox changes and auto-apply filters
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateFilterState();
            // Auto-apply filters after a short delay to allow for multiple selections
            setTimeout(applyFilters, 300);
        });
    });
    
    // Initialize filter state
    updateFilterState();
    
    // Prevent form submission since we auto-apply
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });
});