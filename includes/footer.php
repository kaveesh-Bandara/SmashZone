<?php
/**
 * SmashZone - Reusable Site Footer & Modals Component
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

  <!-- ==========================================================================
       FOOTER SECTION (#082F5A)
       ========================================================================== -->
  <footer class="site-footer" id="footer">
    <div class="container">
      <div class="row g-4">
        
        <!-- COLUMN 1: BRAND INFO -->
        <div class="col-lg-4 col-md-6">
          <img src="images/logo/logo.png" alt="SmashZone Logo" class="footer-logo bg-white p-2 rounded">
          <p class="footer-about mt-3">
            <strong>SmashZone — Elevate Your Game.</strong><br>
            Your premier online destination for authentic badminton rackets, shuttlecocks, court shoes, apparel, bags, and accessories in Sri Lanka.
          </p>
          <ul class="social-links-list">
            <li><a href="#" class="social-icon-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a></li>
            <li><a href="#" class="social-icon-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a></li>
            <li><a href="#" class="social-icon-btn" aria-label="YouTube"><i class="bi bi-youtube"></i></a></li>
            <li><a href="#" class="social-icon-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a></li>
          </ul>
        </div>

        <!-- COLUMN 2: SHOP -->
        <div class="col-lg-2 col-md-6 col-6">
          <h4 class="footer-heading">Shop</h4>
          <ul class="footer-links">
            <li><a href="rackets.php">Badminton Rackets</a></li>
            <li><a href="shuttlecocks.php">Shuttlecocks</a></li>
            <li><a href="shoes.php">Shoes</a></li>
            <li><a href="clothing.php">Clothings</a></li>
            <li><a href="bags.php">Bags</a></li>
            <li><a href="accessories.php">Accessories</a></li>
          </ul>
        </div>

        <!-- COLUMN 3: CUSTOMER SUPPORT -->
        <div class="col-lg-3 col-md-6 col-6">
          <h4 class="footer-heading">Customer Support</h4>
          <ul class="footer-links">
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="#">FAQ & Help Center</a></li>
            <li><a href="#">Islandwide Delivery</a></li>
            <li><a href="#">Returns & Warranty</a></li>
            <li><a href="about.php">About SmashZone</a></li>
          </ul>
        </div>

        <!-- COLUMN 4: CONTACT & PAYMENTS -->
        <div class="col-lg-3 col-md-6">
          <h4 class="footer-heading">SmashZone Hotline</h4>
          <ul class="footer-links">
            <li><i class="bi bi-telephone-fill text-orange me-2"></i> +94 11 234 5678</li>
            <li><i class="bi bi-whatsapp text-success me-2"></i> +94 77 123 4567</li>
            <li><i class="bi bi-envelope-fill text-orange me-2"></i> support@smashzone.lk</li>
          </ul>
          <div class="mt-4 pt-2">
            <div class="text-white fw-bold mb-2" style="font-size: 0.85rem;">ACCEPT PAYMENTS (LKR)</div>
            <div class="d-flex gap-2 text-white fs-4">
              <i class="bi bi-credit-card"></i>
              <i class="bi bi-paypal"></i>
              <i class="bi bi-bank"></i>
              <i class="bi bi-shield-lock"></i>
            </div>
          </div>
        </div>

      </div>

      <div class="footer-bottom text-center">
        <p class="mb-0">&copy; 2026 SmashZone Sri Lanka. All Rights Reserved. Premier Badminton Equipment.</p>
      </div>

    </div>
  </footer>

  <!-- ==========================================================================
       MODALS & DRAWERS
       ========================================================================== -->
  
  <!-- 1. PRODUCT QUICK VIEW MODAL -->
  <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center">
              <div class="p-3 bg-light rounded-3">
                <img id="quickViewImage" src="" alt="Product Quick View" class="img-fluid" style="max-height: 280px; object-fit: contain;">
              </div>
            </div>
            <div class="col-md-6">
              <span id="quickViewCategory" class="badge bg-light text-primary text-uppercase mb-2">CATEGORY</span>
              <h3 id="quickViewTitle" class="fw-bold mb-2">Product Title</h3>
              <div class="d-flex align-items-center gap-2 mb-3">
                <span id="quickViewPrice" class="fs-3 fw-bold text-primary">Rs. 0</span>
                <span id="quickViewOldPrice" class="text-muted text-decoration-line-through">Rs. 0</span>
              </div>
              <div id="quickViewDesc" class="text-muted mb-4">Product detailed description...</div>
              <button id="quickViewAddCartBtn" class="btn btn-brand-primary w-100 py-3">
                <i class="bi bi-cart-plus me-2"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. AUTHENTICATION MODALS (LOGIN / SIGN UP) -->
  <?php
  require_once __DIR__ . '/../auth.php';
  if (function_exists('renderAuthModals')) {
      renderAuthModals();
  }
  ?>

  <!-- 4. CUSTOM ATTRACTIVE AUTH POPUP TOAST NOTIFICATION -->
  <div id="smashzoneAuthToast" class="smashzone-auth-toast d-none" role="alert">
    <div class="smashzone-toast-icon">
      <i class="bi bi-shield-lock-fill"></i>
    </div>
    <div class="smashzone-toast-body">
      <h6 class="smashzone-toast-title">Login Required!</h6>
      <p id="smashzoneToastMessage" class="smashzone-toast-text">Please log in first to purchase or add products to your cart!</p>
    </div>
    <button type="button" class="smashzone-toast-close" onclick="closeAuthToast()" aria-label="Close">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <!-- BACK TO TOP FLOATING BUTTON -->
  <button id="backToTopBtn" class="back-to-top-btn" aria-label="Back to top">
    <i class="bi bi-arrow-up-short fs-3"></i>
  </button>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SmashZone Global E-Commerce & Cart JavaScript -->
  <script src="js/script.js"></script>

  <!-- Global Auth JS State -->
  <script>
    const IS_LOGGED_IN = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

    let authToastTimer;
    function showSmashZoneAuthToast(message) {
      const toastElem = document.getElementById('smashzoneAuthToast');
      const msgElem = document.getElementById('smashzoneToastMessage');
      if (toastElem && msgElem) {
        msgElem.textContent = message;
        toastElem.classList.remove('d-none');
        // Force reflow
        void toastElem.offsetWidth;
        toastElem.classList.add('smashzone-toast-show');
        clearTimeout(authToastTimer);
        authToastTimer = setTimeout(() => {
          closeAuthToast();
        }, 5000);
      }
    }

    function closeAuthToast() {
      const toastElem = document.getElementById('smashzoneAuthToast');
      if (toastElem) {
        toastElem.classList.remove('smashzone-toast-show');
        setTimeout(() => toastElem.classList.add('d-none'), 300);
      }
    }

    // Helper Function to Enforce Login for Purchases or Sensitive Actions
    function requireLoginPrompt(message = 'Please log in first to purchase or add products to your cart!') {
      if (!IS_LOGGED_IN) {
        // Display Login Alert inside the Login Modal
        const alertBox = document.getElementById('loginAlert');
        if (alertBox) {
          alertBox.className = 'alert alert-warning border border-warning shadow-sm rounded-3 small d-flex align-items-center gap-2 mb-3';
          alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i> <div><strong>Login Required!</strong><br>' + message + '</div>';
        }

        // Show Ultra-Attractive CSS Floating Popup Notification (No plain browser alerts!)
        showSmashZoneAuthToast(message);

        // Open Login Bootstrap Modal
        const modalElem = document.getElementById('loginModal');
        if (modalElem) {
          const bsModal = bootstrap.Modal.getInstance(modalElem) || new bootstrap.Modal(modalElem);
          bsModal.show();
        }
        return false;
      }
      return true;
    }

    // Toggle Password Visibility
    function togglePassVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i class="bi bi-eye-slash text-warning"></i>';
      } else {
        input.type = 'password';
        btn.innerHTML = '<i class="bi bi-eye"></i>';
      }
    }

    // Client-Side Real-Time Validation & AJAX Auth Handlers
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Back to Top Button
      const backToTopBtn = document.getElementById('backToTopBtn');
      if (backToTopBtn) {
        window.addEventListener('scroll', () => {
          if (window.scrollY > 300) {
            backToTopBtn.classList.add('show');
          } else {
            backToTopBtn.classList.remove('show');
          }
        });

        backToTopBtn.addEventListener('click', (e) => {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      }

      // 2. Auto open login modal if URL has ?login_required=1
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('login_required') === '1' && !IS_LOGGED_IN) {
        const loginModalElem = document.getElementById('loginModal');
        if (loginModalElem) {
          const bsModal = bootstrap.Modal.getInstance(loginModalElem) || new bootstrap.Modal(loginModalElem);
          bsModal.show();
        }
      }

      const getAuthEndpoint = () => window.location.pathname.includes('/admin/') ? '../auth.php' : 'auth.php';

      // Validation Helper Functions
      function setFieldState(inputElem, feedbackElem, isValid, message) {
        if (!inputElem) return;
        if (isValid) {
          inputElem.classList.remove('is-invalid-custom');
          inputElem.classList.add('is-valid-custom');
          if (feedbackElem) {
            feedbackElem.classList.remove('d-none', 'invalid');
            feedbackElem.classList.add('valid');
            feedbackElem.textContent = message || '';
          }
        } else {
          inputElem.classList.remove('is-valid-custom');
          inputElem.classList.add('is-invalid-custom');
          if (feedbackElem) {
            feedbackElem.classList.remove('d-none', 'valid');
            feedbackElem.classList.add('invalid');
            feedbackElem.textContent = message || '';
          }
        }
      }

      function clearFieldState(inputElem, feedbackElem) {
        if (!inputElem) return;
        inputElem.classList.remove('is-valid-custom', 'is-invalid-custom');
        if (feedbackElem) {
          feedbackElem.classList.add('d-none');
          feedbackElem.textContent = '';
        }
      }

      // Email Validator
      function validateEmailStr(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email.trim());
      }

      // Name Validator (Letters, spaces, hyphens, apostrophes)
      function validateNameStr(name) {
        const regex = /^[a-zA-Z\s\'-]{2,50}$/;
        return regex.test(name.trim());
      }

      // Sri Lankan Phone Validator
      function validatePhoneStr(phone) {
        const clean = phone.replace(/[\s\-\(\)]+/g, '');
        const regex = /^(?:\+94|0)?7[0-9]{8}$/;
        return regex.test(clean);
      }

      // =========================================================================
      // LOGIN FORM REAL-TIME VALIDATION
      // =========================================================================
      const loginEmail = document.getElementById('loginEmailInput');
      const loginEmailFB = document.getElementById('loginEmailFeedback');
      const loginPassword = document.getElementById('loginPasswordInput');
      const loginPasswordFB = document.getElementById('loginPasswordFeedback');

      loginEmail?.addEventListener('input', () => {
        const val = loginEmail.value;
        if (!val) {
          clearFieldState(loginEmail, loginEmailFB);
        } else if (!validateEmailStr(val)) {
          setFieldState(loginEmail, loginEmailFB, false, 'Please enter a valid email address.');
        } else {
          setFieldState(loginEmail, loginEmailFB, true, '');
        }
      });

      loginPassword?.addEventListener('input', () => {
        const val = loginPassword.value;
        if (!val) {
          clearFieldState(loginPassword, loginPasswordFB);
        } else if (val.length < 8) {
          setFieldState(loginPassword, loginPasswordFB, false, 'Password must be at least 8 characters long.');
        } else {
          setFieldState(loginPassword, loginPasswordFB, true, '');
        }
      });

      // AJAX Login Submission
      document.getElementById('formCustomerLogin')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const alertBox = document.getElementById('loginAlert');
        const submitBtn = document.getElementById('btnLoginSubmit');
        const emailVal = loginEmail ? loginEmail.value.trim() : '';
        const passVal = loginPassword ? loginPassword.value.trim() : '';

        alertBox.className = 'alert d-none';

        if (!validateEmailStr(emailVal)) {
          setFieldState(loginEmail, loginEmailFB, false, 'Please enter a valid email address.');
          loginEmail.focus();
          return;
        }

        if (!passVal || passVal.length < 8) {
          setFieldState(loginPassword, loginPasswordFB, false, 'Please enter your password (min 8 characters).');
          loginPassword.focus();
          return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Logging in...';

        const formData = new FormData(this);

        fetch(getAuthEndpoint(), { method: 'POST', body: formData })
          .then(res => res.json())
          .then(data => {
            alertBox.classList.remove('d-none');
            if (data.status === 'success') {
              alertBox.className = 'alert alert-success border border-success rounded-3 small mb-3';
              alertBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + data.message + ' Redirecting...';
              setTimeout(() => {
                const targetRedirect = window.location.pathname.includes('/admin/') && !data.redirect.startsWith('../') 
                  ? data.redirect.replace('admin/', '') 
                  : data.redirect;
                window.location.href = targetRedirect || 'account.php';
              }, 600);
            } else {
              submitBtn.disabled = false;
              submitBtn.innerHTML = 'LOGIN TO SMASHZONE <i class="bi bi-arrow-right ms-2 fs-5"></i>';
              alertBox.className = 'alert alert-danger border border-danger rounded-3 small mb-3';
              alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> ' + data.message;
            }
          })
          .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'LOGIN TO SMASHZONE <i class="bi bi-arrow-right ms-2 fs-5"></i>';
            alertBox.classList.remove('d-none');
            alertBox.className = 'alert alert-danger border border-danger rounded-3 small mb-3';
            alertBox.textContent = 'Server error processing login request.';
          });
      });

      // =========================================================================
      // REGISTER FORM REAL-TIME VALIDATION & PASSWORD STRENGTH WIDGET
      // =========================================================================
      const regFirstName = document.getElementById('regFirstName');
      const regFirstNameFB = document.getElementById('regFirstNameFeedback');
      const regLastName = document.getElementById('regLastName');
      const regLastNameFB = document.getElementById('regLastNameFeedback');
      const regEmail = document.getElementById('regEmail');
      const regEmailFB = document.getElementById('regEmailFeedback');
      const regPhone = document.getElementById('regPhone');
      const regPhoneFB = document.getElementById('regPhoneFeedback');
      const regPassword = document.getElementById('regPasswordInput');
      const regConfirmPass = document.getElementById('regConfirmPasswordInput');
      const regConfirmFB = document.getElementById('regConfirmFeedback');
      const btnRegisterSubmit = document.getElementById('btnRegisterSubmit');

      // Rule Elements
      const ruleLength = document.getElementById('ruleLength');
      const ruleUpper  = document.getElementById('ruleUpper');
      const ruleLower  = document.getElementById('ruleLower');
      const ruleNum    = document.getElementById('ruleNum');
      const ruleSpec   = document.getElementById('ruleSpec');
      const passStrengthBar = document.getElementById('passStrengthBar');
      const passStrengthText = document.getElementById('passStrengthText');

      let isPassValid = false;

      function updateRuleState(ruleElem, isMet) {
        if (!ruleElem) return;
        if (isMet) {
          ruleElem.className = 'pass-rule-item met';
          ruleElem.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + ruleElem.textContent.trim();
        } else {
          ruleElem.className = 'pass-rule-item unmet';
          ruleElem.innerHTML = '<i class="bi bi-circle"></i> ' + ruleElem.textContent.trim();
        }
      }

      function checkPasswordStrength() {
        if (!regPassword) return false;
        const val = regPassword.value;

        const lenMet   = val.length >= 8;
        const upperMet = (val.match(/[A-Z]/g) || []).length >= 2;
        const lowerMet = (val.match(/[a-z]/g) || []).length >= 2;
        const numMet   = (val.match(/[0-9]/g) || []).length >= 1;
        const specMet  = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(val);

        updateRuleState(ruleLength, lenMet);
        updateRuleState(ruleUpper, upperMet);
        updateRuleState(ruleLower, lowerMet);
        updateRuleState(ruleNum, numMet);
        updateRuleState(ruleSpec, specMet);

        const metCount = [lenMet, upperMet, lowerMet, numMet, specMet].filter(Boolean).length;

        if (val.length === 0) {
          passStrengthBar.className = 'pass-strength-bar';
          passStrengthBar.style.width = '0%';
          passStrengthText.className = 'pass-strength-label text-muted';
          passStrengthText.textContent = 'Not Entered';
        } else if (metCount < 3) {
          passStrengthBar.className = 'pass-strength-bar weak';
          passStrengthText.className = 'pass-strength-label weak';
          passStrengthText.textContent = 'Weak';
        } else if (metCount < 5) {
          passStrengthBar.className = 'pass-strength-bar medium';
          passStrengthText.className = 'pass-strength-label medium';
          passStrengthText.textContent = 'Medium';
        } else {
          passStrengthBar.className = 'pass-strength-bar strong';
          passStrengthText.className = 'pass-strength-label strong';
          passStrengthText.textContent = 'Strong ✓';
        }

        isPassValid = (metCount === 5);
        validateRegisterFormState();
      }

      function checkConfirmPassword() {
        if (!regConfirmPass || !regPassword) return false;
        const passVal = regPassword.value;
        const confirmVal = regConfirmPass.value;

        if (!confirmVal) {
          clearFieldState(regConfirmPass, regConfirmFB);
          validateRegisterFormState();
          return false;
        }

        if (passVal === confirmVal && confirmVal.length > 0) {
          setFieldState(regConfirmPass, regConfirmFB, true, 'Passwords match ✓');
          validateRegisterFormState();
          return true;
        } else {
          setFieldState(regConfirmPass, regConfirmFB, false, 'Passwords do not match');
          validateRegisterFormState();
          return false;
        }
      }

      function validateRegisterFormState() {
        if (!btnRegisterSubmit) return;

        const fnValid = regFirstName ? validateNameStr(regFirstName.value) : false;
        const lnValid = regLastName ? validateNameStr(regLastName.value) : false;
        const emailValid = regEmail ? validateEmailStr(regEmail.value) : false;
        const phoneValid = regPhone ? validatePhoneStr(regPhone.value) : false;
        const confirmValid = regConfirmPass ? (regConfirmPass.value === regPassword.value && regConfirmPass.value.length > 0) : false;

        if (fnValid && lnValid && emailValid && phoneValid && isPassValid && confirmValid) {
          btnRegisterSubmit.disabled = false;
        } else {
          btnRegisterSubmit.disabled = true;
        }
      }

      // Input Event Listeners for Registration Form
      regFirstName?.addEventListener('input', () => {
        const val = regFirstName.value;
        if (!val) clearFieldState(regFirstName, regFirstNameFB);
        else if (!validateNameStr(val)) setFieldState(regFirstName, regFirstNameFB, false, 'Letters only (2-50 chars).');
        else setFieldState(regFirstName, regFirstNameFB, true, '');
        validateRegisterFormState();
      });

      regLastName?.addEventListener('input', () => {
        const val = regLastName.value;
        if (!val) clearFieldState(regLastName, regLastNameFB);
        else if (!validateNameStr(val)) setFieldState(regLastName, regLastNameFB, false, 'Letters only (2-50 chars).');
        else setFieldState(regLastName, regLastNameFB, true, '');
        validateRegisterFormState();
      });

      regEmail?.addEventListener('input', () => {
        const val = regEmail.value;
        if (!val) clearFieldState(regEmail, regEmailFB);
        else if (!validateEmailStr(val)) setFieldState(regEmail, regEmailFB, false, 'Please enter a valid email address.');
        else setFieldState(regEmail, regEmailFB, true, '');
        validateRegisterFormState();
      });

      regPhone?.addEventListener('input', () => {
        const val = regPhone.value;
        if (!val) clearFieldState(regPhone, regPhoneFB);
        else if (!validatePhoneStr(val)) setFieldState(regPhone, regPhoneFB, false, 'Please enter a valid Sri Lankan phone number.');
        else setFieldState(regPhone, regPhoneFB, true, 'Valid Sri Lankan phone number');
        validateRegisterFormState();
      });

      regPassword?.addEventListener('input', () => {
        checkPasswordStrength();
        checkConfirmPassword();
      });

      regConfirmPass?.addEventListener('input', () => {
        checkConfirmPassword();
      });

      // AJAX Customer Registration Submission
      document.getElementById('formCustomerRegister')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const alertBox = document.getElementById('registerAlert');
        const submitBtn = document.getElementById('btnRegisterSubmit');

        alertBox.className = 'alert d-none';

        if (submitBtn.disabled) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Creating Account...';

        const formData = new FormData(this);

        fetch(getAuthEndpoint(), { method: 'POST', body: formData })
          .then(res => res.json())
          .then(data => {
            alertBox.classList.remove('d-none');
            if (data.status === 'success') {
              alertBox.className = 'alert alert-success border border-success rounded-3 small mb-3';
              alertBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + data.message + ' Redirecting...';
              setTimeout(() => {
                window.location.href = data.redirect || 'account.php';
              }, 600);
            } else {
              submitBtn.disabled = false;
              submitBtn.innerHTML = 'CREATE SMASHZONE ACCOUNT <i class="bi bi-person-check-fill ms-2 fs-5"></i>';
              alertBox.className = 'alert alert-danger border border-danger rounded-3 small mb-3';
              alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> ' + data.message;
            }
          })
          .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'CREATE SMASHZONE ACCOUNT <i class="bi bi-person-check-fill ms-2 fs-5"></i>';
            alertBox.classList.remove('d-none');
            alertBox.className = 'alert alert-danger border border-danger rounded-3 small mb-3';
            alertBox.textContent = 'Server error processing registration request.';
          });
      });
    });
  </script>

</body>
</html>

