/**
 * SmashZone - Professional Admin Panel JavaScript (admin/assets/js/admin.js)
 */

document.addEventListener('DOMContentLoaded', () => {
  
  // 1. Sidebar Collapse & Mobile Drawer Toggle
  const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
  const mobileSidebarClose = document.getElementById('mobileSidebarClose');

  if (sidebarToggleBtn) {
    sidebarToggleBtn.addEventListener('click', () => {
      if (window.innerWidth < 992) {
        document.body.classList.toggle('mobile-sidebar-open');
      } else {
        document.body.classList.toggle('sidebar-collapsed');
      }
    });
  }

  if (mobileSidebarClose) {
    mobileSidebarClose.addEventListener('click', () => {
      document.body.classList.remove('mobile-sidebar-open');
    });
  }

  // Close mobile sidebar when clicking backdrop overlay
  document.addEventListener('click', (e) => {
    if (document.body.classList.contains('mobile-sidebar-open')) {
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      if (sidebar && !sidebar.contains(e.target) && toggleBtn && !toggleBtn.contains(e.target)) {
        document.body.classList.remove('mobile-sidebar-open');
      }
    }
  });

  // 2. Global CSRF Token Setup
  window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  // 3. Image File Upload Previewer Helper
  const imageInputs = document.querySelectorAll('.image-upload-input');
  imageInputs.forEach(input => {
    input.addEventListener('change', function(e) {
      const file = e.target.files[0];
      const previewContainer = this.closest('.image-upload-wrapper')?.querySelector('.image-preview-container') 
                             || document.getElementById('imagePreviewBox');
      const previewImg = previewContainer?.querySelector('img');

      if (file && previewImg) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          previewImg.src = evt.target.result;
          previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    });
  });

  // 4. Global Search Filter in Tables
  const globalSearchInput = document.getElementById('globalAdminSearch');
  if (globalSearchInput) {
    globalSearchInput.addEventListener('input', function() {
      const query = this.value.toLowerCase().trim();
      const tableRows = document.querySelectorAll('.admin-table tbody tr');
      
      tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    });
  }

});

/**
 * Toast Notification Utility
 * @param {string} message 
 * @param {string} type 'success' | 'danger' | 'warning' | 'info'
 */
function showAdminToast(message, type = 'success') {
  const toastElem = document.getElementById('adminToast');
  const toastMessage = document.getElementById('adminToastMessage');
  const toastIcon = document.getElementById('adminToastIcon');

  if (!toastElem || !toastMessage) return;

  // Set colors
  toastElem.className = 'toast align-items-center text-white border-0 shadow-lg';
  if (type === 'success') {
    toastElem.classList.add('bg-success');
    toastIcon.className = 'bi bi-check-circle-fill fs-5';
  } else if (type === 'danger' || type === 'error') {
    toastElem.classList.add('bg-danger');
    toastIcon.className = 'bi bi-x-circle-fill fs-5';
  } else if (type === 'warning') {
    toastElem.classList.add('bg-warning', 'text-dark');
    toastIcon.className = 'bi bi-exclamation-triangle-fill fs-5';
  } else {
    toastElem.classList.add('bg-primary');
    toastIcon.className = 'bi bi-info-circle-fill fs-5';
  }

  toastMessage.textContent = message;
  const bsToast = new bootstrap.Toast(toastElem, { delay: 4000 });
  bsToast.show();
}
