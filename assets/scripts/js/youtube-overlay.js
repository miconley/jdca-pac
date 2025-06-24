/**
 * YouTube Video Overlay
 * Handles YouTube video overlay functionality for ad archive
 */

document.addEventListener('DOMContentLoaded', function() {
    // Create overlay HTML structure
    function createOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'youtube-overlay';
        overlay.className = 'youtube-overlay';
        overlay.innerHTML = `
            <div class="overlay-content">
                <button class="close-button" aria-label="Close video">×</button>
                <div class="video-container">
                    <iframe id="youtube-iframe" 
                            src="" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
        return overlay;
    }

    // Convert YouTube URL to embed URL
    function getYouTubeEmbedUrl(url) {
        if (!url) return '';
        
        // Handle different YouTube URL formats
        let videoId = '';
        
        if (url.includes('youtube.com/watch?v=')) {
            videoId = url.split('v=')[1].split('&')[0];
        } else if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1].split('?')[0];
        } else if (url.includes('youtube.com/embed/')) {
            videoId = url.split('embed/')[1].split('?')[0];
        }
        
        if (videoId) {
            return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        }
        
        return '';
    }

    // Show overlay
    function showOverlay(videoUrl) {
        let overlay = document.getElementById('youtube-overlay');
        
        if (!overlay) {
            overlay = createOverlay();
        }
        
        const iframe = overlay.querySelector('#youtube-iframe');
        const embedUrl = getYouTubeEmbedUrl(videoUrl);
        
        if (embedUrl) {
            iframe.src = embedUrl;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent body scroll
            
            // Focus on overlay for accessibility
            overlay.focus();
        }
    }

    // Hide overlay
    function hideOverlay() {
        const overlay = document.getElementById('youtube-overlay');
        
        if (overlay) {
            overlay.style.display = 'none';
            document.body.style.overflow = ''; // Restore body scroll
            
            // Stop video by clearing src
            const iframe = overlay.querySelector('#youtube-iframe');
            iframe.src = '';
        }
    }

    // Event listeners for play buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('play')) {
            e.preventDefault();
            const videoUrl = e.target.getAttribute('data-url');
            showOverlay(videoUrl);
        }
    });

    // Event listener for close button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('close-button') || 
            e.target.id === 'youtube-overlay') {
            hideOverlay();
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideOverlay();
        }
    });

    // Prevent closing when clicking on video content
    document.addEventListener('click', function(e) {
        if (e.target.closest('.overlay-content') && 
            !e.target.classList.contains('close-button')) {
            e.stopPropagation();
        }
    });
});