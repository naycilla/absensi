@extends('layouts.main')

@section('title')
  {{ $nama }} - {{ $kelas }}
@endsection

@section('body')
{{-- {{ dd( $sakit )}} --}}
<div class="container-fluid">
    <form action="/siswa/dashboard/bulan" method="post">
      @csrf
      {{-- <input type="hidden" name="id_absensi" value=""> --}}
        <div class="row ml-1 mb-1 justify-content-end">
          <div class="form-group col-3 mr-0">
            <select class="custom-select custom-select-sm" name="bulan">
              <option selected disabled>--Bulan--</option>
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
   
          <div class="col-1" >
              <button type="submit" class="btn btn-sm btn-primary px-2">Filter</button>
          </div>
          </form>
  </div>
  
  
    @if ($hadir->isNotEmpty())
    <div class="card mx-2">
  
      <!-- /.card-header -->
      <div class="card-body p-3">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Status</th>
              {{-- <th>Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($hadir as $hadir)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ App\Helpers\Helpers::tanggal($hadir->created_at) }}</td>
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
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $absen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ App\Helpers\Helpers::tanggal($absen->created_at) }}</td>
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
                        <a href="/siswa/download/{{ $absen->gambar }}" class="btn btn-info btn-xs rounded-0">Bukti</a>
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