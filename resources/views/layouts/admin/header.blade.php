<!-- START HEADER -->
<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input"></div>
    </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">

      <!-- Menu Authentication -->
      @if(session('user_id'))
      <!-- Tampilan ketika user sudah login -->
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            <img src="https://avatars.dicebear.com/v2/initials/{{ substr(session('username'), 0, 1) }}.svg" alt="{{ session('username') }}" class="rounded-full">
          </div>
          <div class="is-user-name"><span>{{ session('username') }}</span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          <a href="{{ route('dashboard') }}" class="navbar-item">
            <span class="icon"><i class="mdi mdi-view-dashboard"></i></span>
            <span>Dashboard</span>
          </a>
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <hr class="navbar-divider">
          <a href="{{ route('auth.logout') }}" class="navbar-item">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>

      <a href="{{ route('auth.logout') }}" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Logout</span>
      </a>

      @else
      <!-- Tampilan ketika user belum login -->
      <a href="{{ route('auth.index') }}" class="navbar-item has-divider">
        <span class="icon"><i class="mdi mdi-login"></i></span>
        <span>Login</span>
      </a>
      <a href="{{ route('auth.showRegister') }}" class="navbar-item has-divider">
        <span class="icon"><i class="mdi mdi-account-plus"></i></span>
        <span>Register</span>
      </a>
      @endif

      <!-- Menu lainnya -->
      <div class="navbar-item dropdown has-divider">
        <a class="navbar-link">
          <span class="icon"><i class="mdi mdi-menu"></i></span>
          <span>Sample Menu</span>
          <span class="icon">
            <i class="mdi mdi-chevron-down"></i>
          </span>
        </a>
        <div class="navbar-dropdown">
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-help-circle"></i></span>
            <span>Help</span>
          </a>
        </div>
      </div>

      <a href="https://justboil.me/tailwind-admin-templates" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
        <span>About</span>
      </a>
      <a href="https://github.com/justboil/admin-one-tailwind" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
        <span>GitHub</span>
      </a>
    </div>
  </div>
</nav>
<!-- END HEADER -->
