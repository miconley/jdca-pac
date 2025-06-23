/**
 * Candidate Filter JavaScript
 * Handles candidate filtering functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('candidate-filter-form');
    const applyButton = document.getElementById('apply-filters');
    const clearButton = document.getElementById('clear-filters');
    const checkboxes = document.querySelectorAll('.term-checkbox');
    
    if (!filterForm) return;
    
    // Update URL parameters when checkboxes change
    function updateURL() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        // Add all checked values to URL params
        for (let pair of formData.entries()) {
            const [name, value] = pair;
            if (params.has(name)) {
                // If parameter already exists, append to array
                const existing = params.get(name);
                params.set(name, existing + ',' + value);
            } else {
                params.set(name, value);
            }
        }
        
        // Convert comma-separated values to array format for URL
        const finalParams = new URLSearchParams();
        for (let [key, value] of params.entries()) {
            if (value.includes(',')) {
                const values = value.split(',');
                values.forEach(val => finalParams.append(key + '[]', val));
            } else {
                finalParams.append(key + '[]', value);
            }
        }
        
        return finalParams.toString();
    }
    
    // Handle apply filters button
    if (applyButton) {
        applyButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const queryString = updateURL();
            let url = filterForm.action;
            
            if (queryString) {
                url += '?' + queryString;
            }
            
            window.location.href = url;
        });
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
    
    // Add visual feedback for filter state
    function updateFilterState() {
        const checkedBoxes = document.querySelectorAll('.term-checkbox:checked');
        const hasFilters = checkedBoxes.length > 0;
        
        // Update button states
        if (applyButton) {
            applyButton.disabled = !hasFilters;
            applyButton.textContent = hasFilters ? 
                `Apply Filters (${checkedBoxes.length})` : 
                'Apply Filters';
        }
        
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
    
    // Listen for checkbox changes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateFilterState);
    });
    
    // Initialize filter state
    updateFilterState();
    
    // Handle form submission with proper array formatting
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const queryString = updateURL();
        let url = filterForm.action;
        
        if (queryString) {
            url += '?' + queryString;
        }
        
        window.location.href = url;
    });
});