  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block justify-content-end">
        @can('sekretaris')
        <a href="/sekretaris/logout" onclick="confirm('Yakin ingin logout?')" class="nav-link">Logout</a>
        @endcan
        @can('siswa')
        <a href="/siswa/logout" onclick="confirm('Yakin ingin logout?')"  class="nav-link">Logout</a>
        @endcan
        @can('operator')
        <a href="/operator/logout" onclick="confirm('Yakin ingin logout?')"  class="nav-link">Logout</a>
        @endcan
        @if (auth()->user()->level == 4)
        <a href="/admin/logout" onclick="confirm('Yakin ingin logout?')"  class="nav-link">Logout</a>
        @endif
      </li>
    </ul>
  </nav>

  <!-- /.navbar -->