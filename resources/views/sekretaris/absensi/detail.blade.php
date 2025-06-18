@extends('layouts.main')

@section('title')
  Absensi - {{ App\Helpers\Helpers::tanggal($tanggal, false) }}
@endsection

@section('body')
{{-- {{ dd( $absen )}} --}}
<div class="container-fluid">
  
    @if ($hadir->isNotEmpty())
    <div class="card mx-2">
  
      <!-- /.card-header -->
      <div class="card-body p-3">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Absen</th>
                <th>Nama</th>
                <th>Status</th>
              {{-- <th>Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($hadir as $hadir)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $hadir->nisn }}</td>
                <td>{{ $hadir->siswa->no_absen }}</td>
                <td>{{ $hadir->siswa->nama }}</td>
                <td>Hadir</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>  
    @endif
  
      <!-- /.card-header -->
      @if ($absen->isNotEmpty())
      <h4 class="ml-3 mt-4">Tidak Hadir</h4>
      <div class="card mx-2 mb-5">
        <div class="card-body p-3">
            <table class="table table-sm table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Absen</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $absen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen->nisn }}</td>
                    <td>{{ $absen->siswa->no_absen }}</td>
                    <td>{{ $absen->siswa->nama }}</td>
                    @if ($absen->status == 1)
                    <td>Sakit</td>
                    @elseif ($absen->status == 2)
                    <td>Izin</td>
                    @elseif ($absen->status == 3)
                    <td>Alpa</td>
                    @elseif ($absen->status == 4)
                    <td>Dispen</td>
                    @endif
                    <td>{{ $absen->keterangan }}</td>
                    <td>
                        <a href="/sekretaris/download/{{ $absen->gambar }}" class="btn btn-info btn-xs rounded-0">Bukti</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>   
      </div>  

      @endif
      <!-- /.card-body -->
  </div> <!-- /.container-fluid -->
  
  
 @endsection