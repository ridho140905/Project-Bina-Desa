<!-- START SIDEBAR -->
<aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
        <div class="sidebar-header">
            <!-- Logo kustom di sebelah kiri -->
            <div class="logo-container">
                <img src="{{ asset('assets-admin/img/logoprofildesa.png') }}" alt="Desa Binaan" class="sidebar-logo">
            </div>

            <!-- Teks di sebelah kanan logo -->
            <div class="header-title">
                <b class="font-black"> Profil</b> <b class="font-black">Desa</b>
            </div>
        </div>
    </div>

    <p class="menu-label">Sign up</p>
    <ul class="menu-list">
        <li class="{{ request()->is('auth.register') ? 'active' : '' }}">
            <a href="{{ url('/register') }}">
                <span class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                </span>
                <span class="menu-item-label">Buat akun</span>
            </a>
        </li>
    </ul>

    <div class="menu is-menu-main">
        <p class="menu-label">General</p>
        <ul class="menu-list">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>
        </ul>

        <p class="menu-label">Management</p>
        <ul class="menu-list">
            <li class="{{ request()->is('profil*') ? 'active' : '' }}">
                <a href="{{ url('/profil') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Profil</span>
                </a>
            </li>

            <!-- PERBAIKAN: Class aktif untuk User yang benar -->
            <li class="{{ request()->is('user*') ? 'active' : '' }}">
                <a href="{{ url('/user') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-.12a2 2 0 0 0-1.9 1.37l-.86 2.58c1.08.6 1.82 1.73 1.82 3.05v8h3zm-7.5-10.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S11 9.17 11 10s.67 1.5 1.5 1.5zM5.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm2 16v-7H9V9c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v6h1.5v7h4zm6.5 0v-4h1v-4c0-.82-.68-1.5-1.5-1.5h-2c-.82 0-1.5.68-1.5 1.5v4h1v4h3z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">User</span>
                </a>
            </li>

            <li class="{{ request()->is('warga*') ? 'active' : '' }}">
                <a href="{{ url('/warga') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Warga</span>
                </a>
            </li>

            <li class="{{ request()->is('berita*') ? 'active' : '' }}">
                <a href="{{ url('/berita') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Berita</span>
                </a>
            </li>

            <li class="{{ request()->is('kategoriberita*') ? 'active' : '' }}">
                <a href="{{ url('/kategoriberita') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Kategori Berita</span>
                </a>
            </li>

            <li class="{{ request()->is('agenda*') ? 'active' : '' }}">
                <a href="{{ url('/agenda') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Agenda</span>
                </a>
            </li>

            <li class="{{ request()->is('galeri*') ? 'active' : '' }}">
                <a href="{{ url('/galeri') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Galeri</span>
                </a>
            </li>

            <!-- PERBAIKAN: Identitas Pengembang sekarang berada di dalam <ul> -->
            <li class="{{ request()->is('developer*') ? 'active' : '' }}">
                <a href="{{ url('/developer') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                    </span>
                    <span class="menu-item-label">Identitas Pengembang</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- END SIDEBAR -->

<style>
    /* Style untuk header sidebar dengan logo */
    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-logo {
        width: 36px;
        height: 36px;
        object-fit: contain;
        border-radius: 6px;
    }



    /* Style untuk menjaga konsistensi dengan kode asli */
    .aside-tools {
        padding: 20px 15px;
    }

    .aside-tools>div {
        display: flex;
        align-items: center;
    }

    /* Pastikan icon bawaan tidak muncul */
    .aside-tools .icon {
        display: none;
    }

    }
</style>
