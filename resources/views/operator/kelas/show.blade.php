@extends('layouts.main')

@section('title')
  Data Siswa - {{ $kelas[0]->nama_kelas }}
@endsection

{{-- {{ dd($siswa) }} --}}

@section('body')
<div class="container-fluid">
  <div class="row ml-0">
    
    @if (auth()->user()->level == 4)
      <form action="/admin/data-siswa" method="post">
    @elseif(auth()->user()->level == 3)
        <form action="/operator/data-siswa" method="post">
    @endif
      @csrf
      <input type="hidden" name="id_kelas" value="{{ request()->id }}">
      <div class="row mb-2" style="margin-left: 1px">
        <div class="form-group col-2">
          {{-- <label for="level">Status</label> --}}

          <select class="custom-select" name="level">
            <option value="1" >Siswa</option>
            <option value="2">Sekretaris</option>
          </select>
        </div>

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
        {{-- <div class="col-4">
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" value="{{ old('nama') }}">
          @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div> --}}
        <div class="col-4">
          <div class="input-group">
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" value="{{ old('nama') }}">
            
            <span class="input-group-append">
              <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-plus"></i></button>
            </span>
            @error('nama')
                <div class="invalid-feedback mb-1">{{ $message }}</div>
            @enderror
  
          </div>  
        </div>
        </div>
    </form>


  </div>
    <div class="row">
    <div class="col-12">
        <div class="card mx-2 ">
        <div class="card-body">
            <table id="example2" class="table table-sm table-bordered table-hover">
            <thead>
            <tr>
                <th>Absen</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($siswa as $siswa)
            <tr>
                <td>{{ $siswa->no_absen }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>
                  @if($siswa->user->level == 1) 
                  Siswa
                  @elseif($siswa->user->level == 2) 
                  Sekretaris
                  @endif
                </td>
                <td>
                  @if (auth()->user()->level == 3)
                  <div class="btn-group">
                    <a href="/operator/data-siswa/{{ $siswa->nisn }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                    <a href="/operator/data-siswa/{{ $siswa->nisn }}/hapus" onclick="return confirm('Siswa akan dihapus')" class="btn rounded-0 btn-danger btn-xs" >Hapus</a>
                  </div>
                 @endif
                  @if (auth()->user()->level == 4)
                  <div class="btn-group">
                    <a href="/admin/data-siswa/{{ $siswa->nisn }}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a>
                    <a href="/admin/data-siswa/{{ $siswa->nisn }}/hapus" onclick="return confirm('Siswa akan dihapus')" class="btn rounded-0 btn-danger btn-xs" >Hapus</a>
                  </div>
                 @endif
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Absen</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Aksi</th>
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
      $('#example2').DataTable({
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