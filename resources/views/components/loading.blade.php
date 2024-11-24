 <!-- Loading Overlay -->
 <div id="loadingOverlay" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50 hidden">
     <div class="flex flex-col items-center">
         <svg class="animate-spin h-12 w-12 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
         </svg>
         <p class="mt-4 text-gray-600">Loading, please wait...</p>
     </div>
 </div>


 <script>
// Show loading overlay before the page unloads
window.addEventListener('beforeunload', function() {
    document.getElementById('loadingOverlay').classList.remove('hidden'); // Show before navigating away
});

// Hide loading overlay when the page is fully loaded
window.addEventListener('load', function() {
    document.getElementById('loadingOverlay').classList.add('hidden'); // Hide when fully loaded
});
 </script>