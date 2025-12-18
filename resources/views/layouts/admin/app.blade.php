<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- MATERIAL DESIGN ICONS - HARUS DILOAD DI SINI -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

    <!-- START CSS -->
    @include('layouts.admin.css')
    <!-- END CSS -->

    <!-- START JS -->
    @include('layouts.admin.js')
    <!-- END JS -->

    <style>
        /* Sidebar Toggle untuk Mobile */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            /* Sidebar untuk mobile */
            aside.sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
                width: 280px;
            }

            aside.sidebar.active {
                transform: translateX(0);
            }

            /* Overlay untuk sidebar */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 40;
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Tombol toggle di header */
            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 100;
                background: #3b82f6;
                color: white;
                border: none;
                border-radius: 4px;
                padding: 8px 12px;
                cursor: pointer;
            }

            /* Adjust header untuk mobile */
            header.navbar {
                padding-left: 60px;
            }

            /* Main content adjustment */
            #app > div:not(.sidebar-overlay):not(.sidebar-toggle) {
                transition: margin-left 0.3s ease;
            }

            /* Ketika sidebar aktif */
            body.sidebar-active main {
                margin-left: 0;
            }
        }

        @media (max-width: 480px) {
            aside.sidebar {
                width: 250px;
            }

            .sidebar-toggle {
                top: 12px;
                left: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>

<body>

    <div id="app">

        <!-- START HEADER -->
        @include('layouts.admin.header')
        <!-- END HEADER -->

        <!-- Sidebar Toggle Button untuk Mobile -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="mdi mdi-menu"></i>
        </button>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- START SIDEBAR -->
        @include('layouts.admin.sidebar')
        <!-- END SIDEBAR -->

        <!-- START MAIN CONTENT -->
        @yield('content')
        <!-- END MAIN CONTENT -->

        <!-- START FOOTER -->
        @include('layouts.admin.footer')
        <!-- END FOOTER -->

    </div>

    <!-- FLOATING WHATSAPP - SIMPLE & CLEAN -->
    <div class="floating-whatsapp">
        <a href="https://wa.me/6289620830434?text=Halo,%20saya%20ingin%20bertanya"
           target="_blank"
           class="whatsapp-float"
           title="Chat WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="whatsapp-icon">
                <path fill="#ffffff" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
            </svg>
        </a>
    </div>

    <script>
        // Sidebar Toggle untuk Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('aside.sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            if (sidebarToggle && sidebar) {
                // Toggle sidebar
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                    body.classList.toggle('sidebar-active');
                });

                // Close sidebar dengan overlay
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    body.classList.remove('sidebar-active');
                });

                // Close sidebar dengan Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        body.classList.remove('sidebar-active');
                    }
                });

                // Close sidebar ketika klik link di sidebar (untuk mobile)
                const sidebarLinks = sidebar.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 768) {
                            sidebar.classList.remove('active');
                            sidebarOverlay.classList.remove('active');
                            body.classList.remove('sidebar-active');
                        }
                    });
                });
            }

            // Auto close sidebar di mobile saat resize ke desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    if (sidebar) sidebar.classList.remove('active');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                    body.classList.remove('sidebar-active');
                }
            });
        });
    </script>

</body>
</html>
