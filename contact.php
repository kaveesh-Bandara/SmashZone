<?php
/**
 * SmashZone - Contact Us Page (contact.php)
 * Powered by PHP & MySQL database smashZone
 */

require_once __DIR__ . '/includes/db.php';

$pageTitle = "Contact Us — SmashZone Sri Lanka Badminton Hub";
$pageMetaDesc = "Get in touch with SmashZone badminton gear experts in Sri Lanka. Contact hotline +94 11 234 5678 or email support@smashzone.lk.";

require_once __DIR__ . '/includes/header.php';
?>

  <!-- HERO BANNER -->
  <section class="category-page-hero">
    <div class="container text-center">
      <h1 class="category-hero-title">Get in Touch with <span class="text-orange">SmashZone</span></h1>
      <p class="category-hero-desc mx-auto" style="max-width: 680px;">
        Have questions about badminton rackets, string tension, shoe sizing, or bulk shuttlecock orders? Our customer support team is ready to assist you.
      </p>
    </div>
  </section>

  <!-- MAIN CONTACT SECTION -->
  <main class="py-5" style="background-color: var(--light-bg);">
    <div class="container">
      <div class="row g-4">
        
        <!-- CONTACT INFORMATION CARDS -->
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h3 class="fw-bold text-navy mb-4"><i class="bi bi-geo-alt-fill text-orange me-2"></i> Store Headquarters</h3>
            
            <div class="d-flex align-items-start gap-3 mb-4">
              <div class="bg-light p-3 rounded-circle text-primary fs-4">
                <i class="bi bi-building"></i>
              </div>
              <div>
                <strong class="d-block text-navy">SmashZone Flagship Store</strong>
                <span class="text-muted small">No. 142, Galle Road, Colombo 03, Sri Lanka</span>
              </div>
            </div>

            <div class="d-flex align-items-start gap-3 mb-4">
              <div class="bg-light p-3 rounded-circle text-success fs-4">
                <i class="bi bi-whatsapp"></i>
              </div>
              <div>
                <strong class="d-block text-navy">WhatsApp & Call Support</strong>
                <span class="text-muted small">+94 77 123 4567 / +94 11 234 5678</span>
              </div>
            </div>

            <div class="d-flex align-items-start gap-3 mb-4">
              <div class="bg-light p-3 rounded-circle text-warning fs-4">
                <i class="bi bi-envelope-check"></i>
              </div>
              <div>
                <strong class="d-block text-navy">Email Inquiries</strong>
                <span class="text-muted small">support@smashzone.lk<br>kavishhapuarachchi@gmail.com</span>
              </div>
            </div>

            <div class="mt-auto p-3 bg-navy text-white rounded-3">
              <strong class="d-block mb-1 small text-warning"><i class="bi bi-clock-fill me-1"></i> STORE HOURS</strong>
              <span class="small">Monday – Saturday: 9:00 AM – 7:30 PM<br>Sunday & Poya Days: 10:00 AM – 5:00 PM</span>
            </div>
          </div>
        </div>

        <!-- CONTACT FORM -->
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4 p-4">
            <h3 class="fw-bold text-navy mb-2">Send Us a Message</h3>
            <p class="text-muted small mb-4">Fill out the form below to send a message to SmashZone customer support.</p>

            <div id="contactAlert" class="alert d-none"></div>

            <form id="formContactUs">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label font-semibold small text-muted">Your Full Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Kavish Hapuarachchi" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-semibold small text-muted">Your Email Address</label>
                  <input type="email" name="email" class="form-control" placeholder="kavish@example.com" required>
                </div>
                <div class="col-12">
                  <label class="form-label font-semibold small text-muted">Inquiry Subject</label>
                  <input type="text" name="subject" class="form-control" placeholder="Racket Stringing / Order Inquiry" required>
                </div>
                <div class="col-12">
                  <label class="form-label font-semibold small text-muted">Message Content</label>
                  <textarea name="message" rows="5" class="form-control" placeholder="Write your message or equipment query here..." required></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-hero-orange w-100 py-3 fw-bold justify-content-center fs-6">
                    SEND MESSAGE TO SUPPORT <i class="bi bi-send-fill ms-2"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('formContactUs')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const alertBox = document.getElementById('contactAlert');
        alertBox.className = 'alert d-none';

        fetch('api/contact.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(data => {
            alertBox.classList.remove('d-none');
            if (data.status === 'success') {
              alertBox.className = 'alert alert-success';
              alertBox.textContent = data.message;
              this.reset();
            } else {
              alertBox.className = 'alert alert-danger';
              alertBox.textContent = data.message;
            }
          });
      });
    });
  </script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
