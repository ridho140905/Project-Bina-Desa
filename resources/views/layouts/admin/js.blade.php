<!-- START JS BOTTOM -->
<!-- Scripts below are for demo only -->
<script type="text/javascript" src="{{ asset('assets-admin/js/main.min.js') }}?v=1628755089081"></script>

<!-- Tambahkan script ini untuk fix dropdown -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inisialisasi dropdown navbar
  const dropdowns = document.querySelectorAll('.navbar-item.dropdown');

  dropdowns.forEach(function(dropdown) {
    const link = dropdown.querySelector('.navbar-link');

    if (link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Tutup dropdown lainnya
        dropdowns.forEach(function(otherDropdown) {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove('is-active');
          }
        });

        // Toggle dropdown ini
        dropdown.classList.toggle('is-active');
      });
    }
  });

  // Tutup dropdown saat klik di luar
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.navbar-item.dropdown')) {
      dropdowns.forEach(function(dropdown) {
        dropdown.classList.remove('is-active');
      });
    }
  });

  // Inisialisasi navbar menu toggle (untuk mobile)
  const navbarMenuToggle = document.querySelector('.--jb-navbar-menu-toggle');
  const navbarMenu = document.getElementById('navbar-menu');

  if (navbarMenuToggle && navbarMenu) {
    navbarMenuToggle.addEventListener('click', function() {
      navbarMenu.classList.toggle('is-active');
    });
  }

  // Inisialisasi aside button (untuk mobile)
  const asideButton = document.querySelector('.mobile-aside-button');
  const aside = document.querySelector('aside.aside');

  if (asideButton && aside) {
    asideButton.addEventListener('click', function() {
      aside.classList.toggle('is-expanded');
    });
  }
});
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-130795909-1');
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="{{ asset('assets-admin/js/chart.sample.min.js') }}"></script>
<!-- END JS BOTTOM -->
