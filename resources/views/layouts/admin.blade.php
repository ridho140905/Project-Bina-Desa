<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/main.css') }}?v=1628755089081">

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-admin/apple-touch-icon.png') }}"/>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-admin/favicon-32x32.png') }}"/>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-admin/favicon-16x16.png') }}"/>
  <link rel="mask-icon" href="{{ asset('assets-admin/safari-pinned-tab.svg') }}" color="#00b4b6"/>

  <meta name="description" content="Admin Dashboard">

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>

  <style>
   .button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    border: 1px solid transparent;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    gap: 8px;
}

.button.primary {
    background-color: #485fc7;
    color: white;
    border-color: #485fc7;
}

.button.primary:hover {
    background-color: #3a51bb;
    border-color: #3a51bb;
    transform: translateY(-1px);
}

.button.small {
    padding: 6px 12px;
    font-size: 0.75rem;
}

.button.danger {
    background-color: #f14668;
    color: white;
    border-color: #f14668;
}

.button.danger:hover {
    background-color: #e63a5c;
    border-color: #e63a5c;
}

/* Style untuk table yang konsisten */
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Alert styling */
.alert {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.alert-success {
    background: linear-gradient(135deg, #48c78e 0%, #3ec487 100%);
    color: white;
}

.alert-info {
    background: linear-gradient(135deg, #3e8ed0 0%, #3483c7 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #f14668 0%, #e63a5c 100%);
    color: white;
}
.card {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
}

.card-header-title {
    color: #485fc7;
    font-weight: 600;
    margin: 0;
}

.card-content {
    padding: 1.5rem;
}

/* Field styling */
.field.is-horizontal {
    margin-bottom: 1.5rem;
}

.field-body {
    display: flex;
    gap: 1rem;
}

.field-body .field {
    flex: 1;
}

.label {
    font-weight: 600;
    color: #363636;
    margin-bottom: 0.5rem;
}

.control.icons-left .icon.left {
    left: 0;
    color: #485fc7;
}

.input, .textarea {
    border: 1px solid #dbdbdb;
    border-radius: 4px;
    padding: 0.75rem;
    transition: all 0.2s ease;
}

.input:focus, .textarea:focus {
    border-color: #485fc7;
    box-shadow: 0 0 0 2px rgba(72, 95, 199, 0.1);
}

.input.is-danger, .textarea.is-danger {
    border-color: #f14668;
}

.help.is-danger {
    color: #f14668;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Button styling */
.button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 1px solid transparent;
    border-radius: 4px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.button.green {
    background-color: #48c78e;
    color: white;
    border-color: #48c78e;
}

.button.green:hover {
    background-color: #3ec487;
    border-color: #3ec487;
}

.button.light {
    background-color: #f5f5f5;
    color: #363636;
    border-color: #dbdbdb;
}

.button.light:hover {
    background-color: #e8e8e8;
}

.field.grouped {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Notification styling */
.notification {
    border-radius: 8px;
    margin-bottom: 1.5rem;
    padding: 1.25rem;
}

.notification.is-danger {
    background-color: #f14668;
    color: white;
}

.notification.is-info {
    background-color: #3e8ed0;
    color: white;
}

/* Breadcrumb styling */
.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item a {
    color: #485fc7;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #363636;
}
.columns.is-multiline {
    margin-left: -0.75rem;
    margin-right: -0.75rem;
    margin-top: -0.75rem;
}

.column {
    padding: 0.75rem;
}

.field {
    margin-bottom: 1.5rem;
}

/* Responsive design */
@media screen and (max-width: 768px) {
    .column.is-half {
        width: 100%;
    }

    .card-content {
        padding: 1rem;
    }

    .field.is-grouped {
        flex-direction: column;
        gap: 0.75rem;
    }

    .field.is-grouped .control {
        width: 100%;
    }

    .field.is-grouped .button {
        width: 100%;
        justify-content: center;
    }
}

/* Form element improvements */
.input, .textarea {
    width: 100%;
    transition: all 0.2s ease;
}

.input:focus, .textarea:focus {
    border-color: #485fc7;
    box-shadow: 0 0 0 2px rgba(72, 95, 199, 0.1);
}

.textarea {
    resize: vertical;
    min-height: 100px;
}

/* Button improvements */
.field.is-grouped {
    display: flex;
    gap: 1rem;
    align-items: center;
}

@media screen and (max-width: 768px) {
    .field.is-grouped {
        flex-direction: column;
    }

    .field.is-grouped .control {
        width: 100%;
    }

    .field.is-grouped .button {
        width: 100%;
    }
}
  </style>
</head>
<body>

<div id="app">

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
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe" class="rounded-full">
          </div>
          <div class="is-user-name"><span>Admin</span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
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
      <a href="https://justboil.me/tailwind-admin-templates" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
        <span>About</span>
      </a>
      <a href="https://github.com/justboil/admin-one-tailwind" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
        <span>GitHub</span>
      </a>
      <a title="Log out" class="navbar-item desktop-icon-only">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>

<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">Dashboard</b>
    </div>
  </div>
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
        <a href="{{ url('/berita') }}">
          <span class="icon"><i class="mdi mdi-newspaper"></i></span>
          <span class="menu-item-label">Berita</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/agenda') }}">
          <span class="icon"><i class="mdi mdi-calendar"></i></span>
          <span class="menu-item-label">Agenda</span>
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

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>@yield('page-title', 'Dashboard')</li>
    </ul>
    <a href="https://justboil.me/" onclick="alert('Coming soon'); return false" target="_blank" class="button blue">
      <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
      <span>Premium Demo</span>
    </a>
  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      @yield('hero-title', 'Dashboard')
    </h1>
    <button class="button light">Button</button>
  </div>
</section>

<section class="section main-section">
  @yield('content')
</section>

<footer class="footer">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
    <div class="flex items-center justify-start space-x-3">
      <div>
        © 2021, JustBoil.me
      </div>
      <div>
        <p>Distributed By: <a href="https://themewagon.com/" target="_blank">ThemeWagon</a></p>
      </div>
      <a href="https://github.com/justboil/admin-one-tailwind" style="height: 20px">
        <img src="https://img.shields.io/github/v/release/justboil/admin-one-tailwind?color=%23999">
      </a>
    </div>
  </div>
</footer>

</div>
</body>
</html>
