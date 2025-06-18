@extends('layouts.main')

@section('title')
  Data User
@endsection

@section('body')

  <div class="card mx-3">

    <!-- /.card-header -->
    <div class="card-body p-3">
      <a href="/admin/kelola-user/create" class="btn btn-primary btn-sm mb-3">Tambah <i class="fas fa-plus"></i></a>
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>NUPTK</th>
            <th>Nama</th>
            <th>No HP</th>
            <th >Aksi</th>
      </tr>
        </thead>
        <tbody>
          @foreach ($user as $user)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->pengelola->nuptk }}</td>
            <td>{{ $user->pengelola->nama }}</td>
            <td>{{ $user->pengelola->nohp }}</td>
            <td>
                <div class="btn-group">
                  <a href="/admin/kelola-user/{{ $user->id }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                  <a href="/admin/kelola-user/{{ $user->id }}/hapus" onclick="confirm('Yakin ingin menghapus?')" class="btn rounded-0 btn-danger btn-xs">Hapus</a>
                </div>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>

    <!-- /.col -->
    </div>
    <!-- /.row -->

</div> <!-- /.container-fluid -->

@endsection
