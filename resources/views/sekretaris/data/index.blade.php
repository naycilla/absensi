@extends('layouts.main')

@section('title')
  Data Siswa - {{ $kelas }}
@endsection

@section('body')
<div class="container-fluid">
    {{-- input form --}}
    <form action="/sekretaris/data-siswa" method="post">
      @csrf
      <div class="row mb-3" style="margin-left: 1px">
        <div class="col-2">
          <input type="text" name="no_absen" class="form-control @error('no_absen') is-invalid @enderror" placeholder="Absen" value="{{ old('no_absen') }}" autofocus>
          @error('no_absen')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-3">
          <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" placeholder="NISN" value="{{ old('nisn') }}">
          @error('nisn')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-4">
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" value="{{ old('nama') }}">
          @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-2 pt-1">
            <button type="submit" name="submit" class="btn btn-primary btn-sm py-1">Tambah</button>
        </div>
      </div>

        </div>
    </form>

    {{-- datatables --}}
    <div class="row">
    <div class="col-12">
        <div class="card mx-2 ">
        <div class="card-body">
            <table id="data-siswa" class="table table-sm table-bordered table-hover">
            <thead>
            <tr>
                <th>Absen</th>
                <th>NISN</th> 
                <th>Nama</th>
                {{-- <th>Aksi</th> --}}
            </tr>
            </thead>
            <tbody>
            @foreach ($siswa as $siswa)
            <tr>
                <td>{{ $siswa->no_absen }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nama }}</td>
                {{-- <td>
                      <div class="btn-group">
                        <a href="/sekretaris/data-siswa/{{ $siswa->no_absen }}" class="btn btn-info btn-xs rounded-0">Lihat</a>
                        <a href="/sekretaris/data-siswa/{{ $siswa->no_absen }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                        <a href="/sekretaris/data-siswa/{{ $siswa->no_absen }}/hapus" onclick="return confirm('Siswa akan dihapus')" class="btn rounded-0 btn-danger btn-xs" >Hapus</a>
                      </div>

                </td> --}}
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
              <th>NISN</th>
              <th>Absen</th>
                <th>Nama</th>
                {{-- <th>Aksi</th> --}}
            </tr>
            </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->

@endsection

@push('js')
<script>
    $(function () {
      $('#data-siswa').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  
@endpush