</main>

<!-- Footer dengan tema Aurora -->
<footer class="aurora-footer mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="text-white mb-3">
                    <img src="<?= base_url('logo-bcs.png') ?>" alt="Logo BCS Mall" height="30" class="me-2">
                    BCS Mall Parkir
                </h5>
                <p class="text-white-50">
                    Sistem manajemen parkir modern dan terintegrasi untuk kenyamanan dan keamanan pengunjung BCS Mall.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 hover-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-white">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h6 class="text-white mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= site_url('/') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-chevron-right me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/about') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-chevron-right me-2"></i>Tentang
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/services') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-chevron-right me-2"></i>Layanan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/contact') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-chevron-right me-2"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="text-white mb-3">Layanan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= site_url('/parking') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-car me-2"></i>Parkir Mobil
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/motorcycle') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-motorcycle me-2"></i>Parkir Motor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/valet') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-concierge-bell me-2"></i>Valet Service
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('/membership') ?>" class="text-white-50 text-decoration-none hover-white">
                            <i class="fas fa-card-membership me-2"></i>Membership
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="text-white mb-3">Kontak Info</h6>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Jl. Mall BCS No. 123, Jakarta
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        (021) 1234-5678
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        info@bcsmall.co.id
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock me-2"></i>
                        24/7 Operation
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4 border-white-50">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-white-50 mb-0">
                    © <?= date('Y') ?> BCS Mall Parkir. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-white-50">
                    Made with <i class="fas fa-heart text-danger"></i> by BCS Tech Team
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
.aurora-footer {
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: auto;
}

.aurora-footer h5,
.aurora-footer h6 {
    color: white;
    font-weight: 600;
}

.aurora-footer a {
    transition: all 0.3s ease;
}

.aurora-footer a:hover {
    color: white !important;
    transform: translateX(5px);
}

.aurora-footer .list-unstyled li {
    transition: all 0.3s ease;
}

.aurora-footer .list-unstyled li:hover {
    transform: translateX(5px);
}

.hover-white:hover {
    color: white !important;
}

@media (max-width: 768px) {
    .aurora-footer {
        text-align: center;
    }
    
    .aurora-footer .text-md-end {
        text-align: center !important;
    }
}
</style>

<!-- Custom JavaScript -->
<script>
// Auto-hide navbar on scroll
let lastScrollTop = 0;
const navbar = document.querySelector('.aurora-header');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        navbar.style.transform = 'translateY(-100%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop;
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Active nav link highlighting
const currentPath = window.location.pathname;
const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
    }
});

// Manual dropdown control - TANPA Bootstrap JS
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Check current role
    console.log('Current user role:', '<?= session()->get('role') ?>');
    console.log('Is logged in:', '<?= session()->get('isLoggedIn') ? 'true' : 'false' ?>');
    
    // Initialize all dropdowns dengan JavaScript murni
    const dropdownTriggers = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    console.log('Found dropdown triggers:', dropdownTriggers.length);
    
    dropdownTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Dropdown clicked:', trigger.textContent.trim());
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
            
            // Toggle current dropdown
            const dropdownMenu = trigger.nextElementSibling;
            if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                dropdownMenu.classList.toggle('show');
                console.log('Dropdown menu toggled:', dropdownMenu.classList.contains('show'));
            }
        });
    });
    
    // Handle dropdown item clicks - PERBAIKAN
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    console.log('Found dropdown items:', dropdownItems.length);
    
    dropdownItems.forEach(function(item, index) {
        console.log('Dropdown item', index, ':', item.href, item.textContent.trim());
        
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Dropdown item clicked:', this.href);
            console.log('Dropdown item text:', this.textContent.trim());
            
            // Close dropdown
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
            
            // Navigate to URL
            if (this.href && this.href !== '#') {
                console.log('Navigating to:', this.href);
                window.location.href = this.href;
            } else {
                console.log('Invalid href:', this.href);
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-bs-toggle="dropdown"]')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    
    // Close dropdowns when pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    
    // Debug: Check owner dropdown specifically
    const ownerDropdown = document.querySelector('[data-bs-toggle="dropdown"]');
    if (ownerDropdown) {
        console.log('Owner dropdown found:', ownerDropdown.textContent.trim());
    }
});

// reCAPTCHA callback untuk bahasa Indonesia
function recaptchaCallback() {
    console.log('reCAPTCHA berhasil diverifikasi');
}

// reCAPTCHA onload callback
function recaptchaOnloadCallback() {
    console.log('reCAPTCHA dimuat dengan bahasa Indonesia');
}
</script>

<!-- Bootstrap 5 JavaScript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
