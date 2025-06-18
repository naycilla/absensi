@extends('layouts.main')

@section('title')
  Absensi Harian - {{ $kelas }}
@endsection

@section('body')

<div class="container-fluid">
  
    {{-- datatables --}}
    <div class="row">
      
    <div class="col-12">
        <div class="card mx-2 ">
        <div class="card-body"> 
          <a href="/sekretaris/absensi/tambah" class="btn btn-primary btn-sm mb-3">Tambah</a>
            <table id="example2" class="table table-sm table-bordered table-hover">
            <thead>
            <tr>
                <th>Tanggal</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Dispen</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($absensi as $absensi)
            <tr>
              <td>{{ App\Helpers\Helpers::tanggal($absensi->created_at) }}</td>
              <td>{{ $absensi->hadir }}</td>
              <td>{{ $absensi->sakit }}</td>
              <td>{{ $absensi->izin }}</td>
              <td>{{ $absensi->alpa }}</td>
              <td>{{ $absensi->dispen }}</td>
              <td>
                    <div class="btn-group">
                      <a href="/sekretaris/detail-absensi/{{ $absensi->id }}" class="btn btn-info btn-xs rounded-0">Lihat</a>
                      {{-- <a href="/sekretaris/data-siswa/{absen}/edit" class="btn btn-warning btn-xs rounded-0">Ubah</a> --}}
                      {{-- <a href="/sekretaris/data-siswa/{absen}/hapus" onclick="return alert('Siswa akan dihapus')" class="btn rounded-0 btn-danger btn-xs" >Hapus</a> --}}
                    </div>

              </td>
          </tr>
          @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Tanggal</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Dispen</th>
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
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  
@endpush