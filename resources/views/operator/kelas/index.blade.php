@extends('layouts.main')

@section('title')
  Data Kelas
@endsection

@section('body')
<div class="container-fluid">
  @if(auth()->user()->level == 4)
  <form action="/admin/data-kelas" method="post">
  @else
  <form action="/operator/data-kelas" method="post">
    @endif
    @csrf
    {{-- <input type="hidden" name="id_absensi" value=""> --}}
      <div class="row ml-1 mb-1">
        <div class="form-group col-2">
            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" autofocus>
          </div>
          @error('nama_kelas')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        <div class="form-group col-3">
            <input type="text" class="form-control @error('nisn') is-invalid @enderror" placeholder="NISN Sekretaris" name="nisn">
        </div>
        @error('nisn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-group col-2">
            <input type="text" class="form-control @error('no_absen') is-invalid @enderror" placeholder="Absen" name="no_absen">
        </div>
        @error('no_absen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-group col-3">
            <input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" name="nama">
        </div>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="col-1">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

        </form>
  </div>


  <div class="card mx-2">

    <!-- /.card-header -->
    <div class="card-body p-3">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Kelas</th>
            <th width="30%">Aksi</th>
      </tr>
        </thead>
        <tbody>
          @foreach ($kelas as $kelas)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kelas->nama_kelas }}</td>
            <td>
                @if (auth()->user()->level == 3)
                <div class="btn-group">
                  <a href="/operator/data-kelas/{{ $kelas->id }}" class="btn btn-info btn-xs rounded-0">Lihat</a>
                  <a href="/operator/data-kelas/{{ $kelas->id }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                  <a href="/operator/data-kelas/{{ $kelas->id }}/hapus" onclick="confirm('Yakin ingin menghapus kelas?')" class="btn rounded-0 btn-danger btn-xs">Hapus</a>
                </div>
              @endif
              @if (auth()->user()->level == 4)
                <div class="btn-group">
                  <a href="/admin/data-kelas/{{ $kelas->id }}" class="btn btn-info btn-xs rounded-0">Lihat</a>
                  <a href="/admin/data-kelas/{{ $kelas->id }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                  <a href="/admin/data-kelas/{{ $kelas->id }}/hapus" onclick="confirm('Yakin ingin menghapus kelas?')" class="btn rounded-0 btn-danger btn-xs">Hapus</a>
                </div>
              @endif
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
