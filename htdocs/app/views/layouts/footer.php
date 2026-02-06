</div> <!-- End wrapper -->
    
    <!-- Image Modal Lightbox -->
    <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; max-width: 90%; max-height: 90vh;">
            <button onclick="closeImageModal()" style="position: absolute; top: -50px; right: 0; background: white; color: #333; width: 40px; height: 40px; border-radius: 50%; border: none; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                &times;
            </button>
            <img id="modalImage" src="" alt="" style="max-width: 100%; max-height: 90vh; object-fit: contain; border-radius: 8px;">
        </div>
    </div>
    
    <script src="<?= BASE_URL ?>assets/js/script.js"></script>
    <script>
        // Simple Image Modal Functions
        function showImageModal(imageSrc, imageAlt) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            
            if(modal && modalImg) {
                modalImg.src = imageSrc;
                modalImg.alt = imageAlt;
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if(modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') {
                closeImageModal();
            }
        });
        
        // Close on background click
        document.getElementById('imageModal')?.addEventListener('click', function(e) {
            if(e.target === this) {
                closeImageModal();
            }
        });
        
        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>