@extends('layouts.main')

@section('title')
   {{ $tanggal }}
@endsection

@section('body')
{{-- {{ dd( $absen )}} --}}
<div class="container-fluid">
  
    @if (isset($hadir))
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
      @if (isset($sakit))
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
                @foreach ($sakit as $sakit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sakit->nisn }}</td>
                    <td>{{ $sakit->siswa->no_absen }}</td>
                    <td>{{ $sakit->siswa->nama }}</td>
                    <td>Sakit</td>
                    <td>{{ $sakit->keterangan }}</td>
                    <td>
                        <a href="/sekretaris/download/{{ $sakit->gambar }}" class="btn btn-info btn-xs rounded-0">Bukti</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>   
      </div>  

      @endif
      <!-- /.card-body -->
  
      <!-- /.card-header -->
      @if (isset($izin))
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
                @foreach ($izin as $izin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $izin->nisn }}</td>
                    <td>{{ $izin->siswa->no_absen }}</td>
                    <td>{{ $izin->siswa->nama }}</td>
                    @if ($izin->status == 2)
                    <td>Izin</td>
                    @endif
                    @if ($izin->status == 4)
                    <td>Dispen</td>
                    @endif
                    <td>{{ $izin->keterangan }}</td>
                    <td>
                        <a href="/sekretaris/download/{{ $izin->gambar }}" class="btn btn-info btn-xs rounded-0">Bukti</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>   
      </div>  

      @endif
      <!-- /.card-body -->
  
      <!-- /.card-header -->
      @if (isset($alpa) )
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
                </tr>
            </thead>
            <tbody>
                @foreach ($alpa as $alpa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $alpa->nisn }}</td>
                    <td>{{ $alpa->siswa->no_absen }}</td>
                    <td>{{ $alpa->siswa->nama }}</td>
                    <td>Alpa</td>
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