  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link text-center">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">Absensi Online</span>
    </a>

    <!-- Sidebar -->
    @can('siswa')
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/siswa/dashboard" class="nav-link {{ Request::is('siswa/dashboard*') ? "active" : "" }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          {{-- <li class="nav-header">DATA HARIAN</li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    @endcan
    <!-- /.sidebar -->

    <!-- Sidebar -->
        @can('sekretaris')
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="/sekretaris/dashboard" class="nav-link {{ Request::is('sekretaris/dashboard*') || Request::is('sekretaris/siswa-*') ? "active" : "" }}">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              {{-- <li class="nav-header">DATA HARIAN</li> --}}
              <li class="nav-item">
                <a href="/sekretaris/data-siswa" class="nav-link {{ Request::is('sekretaris/data-siswa*') ? "active" : "" }}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Data Siswa
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/sekretaris/absensi" class="nav-link {{ Request::is('sekretaris/absensi*') || Request::is('sekretaris/detail-absensi*') || Request::is('sekretaris/absensi-detail*') ? "active" : "" }}">
                  {{-- <i class="nav-icon fas fa-memo-circle-check"></i> --}}
                  <i class="nav-icon fas fa-check-square"></i>
                  <p>Absensi</p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        @endcan
      <!-- /.sidebar -->

      @can('operator')
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/operator/dashboard" class="nav-link {{ Request::is('operator/dashboard*') || Request::is('operator/detail-*') ? "active" : "" }}">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/operator/data-kelas" class="nav-link {{ Request::is('operator/data-*') ? "active" : "" }}">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                  Data Kelas
                </p>
              </a>
            </li>
            {{-- <li class="nav-item">
              <a href="/sekretaris/absensi" class="nav-link {{ Request::is('sekretaris/absensi*') || Request::is('sekretaris/detail-absensi*') || Request::is('sekretaris/absensi-detail*') ? "active" : "" }}">
                <i class="nav-icon fas fa-check-square"></i>
                <p>Absensi</p>
              </a>
            </li> --}}
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      @endcan

      {{-- @if (auth()->user()->level == 4) --}}
      @can('admin')
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/admin/dashboard" class="nav-link {{ Request::is('admin/dashboard*') || Request::is('admin/detail-*') ? "active" : "" }}">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/data-kelas" class="nav-link {{ Request::is('admin/data-*') ? "active" : "" }}">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                  Data Kelas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/kelola-user" class="nav-link {{ Request::is('admin/kelola-*') ? "active" : "" }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Kelola User</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>

      @endcan
      {{-- @endif --}}

  </aside>
