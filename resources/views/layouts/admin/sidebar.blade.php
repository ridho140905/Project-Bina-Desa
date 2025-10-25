<!-- START SIDEBAR -->
<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">Dashboard</b>
    </div>
  </div>


    <p class="menu-label">Sign up</p>
    <ul class="menu-list">
      <li class="{{ request()->is('auth.register') ? 'active' : '' }}">
        <a href="{{ url('/register') }}">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Buat akun</span>
        </a>
      </li>
    </ul>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ url('/dashboard') }}">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
    </ul>

    <p class="menu-label">Management</p>
    <ul class="menu-list">
      <li class="{{ request()->is('profil*') ? 'active' : '' }}">
        <a href="{{ url('/profil') }}">
          <span class="icon"><i class="mdi mdi-account-group"></i></span>
          <span class="menu-item-label">Profil</span>
        </a>
      </li>
      <li class="{{ request()->is('berita*') ? 'active' : '' }}">
        <a href="{{ url('/user') }}">
          <span class="icon"><i class="mdi mdi-newspaper"></i></span>
          <span class="menu-item-label">user</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/warga') }}">
          <span class="icon"><i class="mdi mdi-calendar"></i></span>
          <span class="menu-item-label">warga</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/galeri') }}">
          <span class="icon"><i class="mdi mdi-image-multiple"></i></span>
          <span class="menu-item-label">Galeri</span>
        </a>
      </li>
    </ul>

    <p class="menu-label">About</p>
    <ul class="menu-list">
      <li>
        <a href="https://justboil.me" onclick="alert('Coming soon'); return false" target="_blank" class="has-icon">
          <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
          <span class="menu-item-label">Premium Demo</span>
        </a>
      </li>
      <li>
        <a href="https://justboil.me/tailwind-admin-templates" class="has-icon">
          <span class="icon"><i class="mdi mdi-help-circle"></i></span>
          <span class="menu-item-label">About</span>
        </a>
      </li>
      <li>
        <a href="https://github.com/justboil/admin-one-tailwind" class="has-icon">
          <span class="icon"><i class="mdi mdi-github-circle"></i></span>
          <span class="menu-item-label">GitHub</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
<!-- END SIDEBAR -->
