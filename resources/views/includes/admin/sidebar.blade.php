<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img
        src="{{ asset('assets/img/AdminLTELogo.png') }}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
      />
      <span class="brand-text fw-light">Event System</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="navigation"
        aria-label="Main navigation"
        data-accordion="false"
        id="navigation"
      >

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Events -->
        <li class="nav-item {{ request()->is('admin/events*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/events*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-clipboard-fill"></i>
            <p>
              Events
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Event Listing</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.events.create') }}" class="nav-link {{ request()->routeIs('admin.events.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Add Event</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
