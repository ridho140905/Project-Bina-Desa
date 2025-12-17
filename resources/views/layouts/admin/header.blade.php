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
      <!-- Sample Menu Dropdown (BIARKAN TETAP ADA) -->
      <div class="navbar-item dropdown has-divider">
        <a class="navbar-link">
          <span class="icon"><i class="mdi mdi-menu"></i></span>
          <span>Sample Menu</span>
          <span class="icon">
            <i class="mdi mdi-chevron-down"></i>
          </span>
        </a>
        <div class="navbar-dropdown">
          <a href="profile.html" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>

      <!-- Menu Authentication -->
      @auth
      <!-- Tampilan ketika user sudah login -->
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            @if(Auth::user()->profile_picture)
            <!-- Tampilkan profile picture dari upload user -->
            <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_picture) }}"
                 alt="{{ Auth::user()->name }}"
                 class="rounded-full"
                 style="width: 32px; height: 32px; object-fit: cover;">
            @else
            <!-- Tampilkan avatar default (bisa tetap pake dicebear atau ganti) -->
            <img src="https://avatars.dicebear.com/v2/initials/{{ substr(Auth::user()->name, 0, 1) }}.svg"
                 alt="{{ Auth::user()->name }}"
                 class="rounded-full"
                 style="width: 32px; height: 32px;">
            @endif
          </div>
          <div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          <a href="{{ route('dashboard.index') }}" class="navbar-item">
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
          <a href="#" class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="navbar-item">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
          <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>

      <!-- Menu desktop only -->
      <a href="https://justboil.me/tailwind-admin-templates" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
        <span>About</span>
      </a>
      <a href="https://github.com/justboil/admin-one-tailwind" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
        <span>GitHub</span>
      </a>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();" class="navbar-item desktop-icon-only" title="Log out">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
      <form id="logout-form-desktop" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

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

      <!-- Menu desktop only untuk non-login -->
      <a href="https://justboil.me/tailwind-admin-templates" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
        <span>About</span>
      </a>
      <a href="https://github.com/justboil/admin-one-tailwind" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
        <span>GitHub</span>
      </a>
      @endif
    </div>
  </div>
</nav>
<!-- END HEADER -->
