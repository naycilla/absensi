@extends('layouts.main')

@section('title')
  Absensi Harian - {{ $kelas }}
@endsection

@section('body')
<div class="container-fluid">
  <form action="/sekretaris/tambah-absensi" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_absensi" value="{{ $absensi->id }}">
      <div class="row mx-1 mb-3">
        <div class="form-group col-4">
          <select class="custom-select" name="nisn" required>
            <option selected disabled>--Nama--</option>
            @foreach ($siswa as $siswa)
            <option value="{{ $siswa->nisn }}">{{ $siswa->nama }}</option>
            @endforeach
          </select>
        </div>
          <div class="form-group col-2">
            <select class="custom-select" name="status">
              <option selected disabled>--Status--</option>
              <option value="1">Sakit</option>
              <option value="2">Izin</option>
              <option value="3">Alpa</option>
              <option value="4">Dispen</option>
            </select>
          </div>
            <div class="form-group custom-file ml-1 col-3">
              <input type="file" name="bukti" class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile">Bukti</label>
            </div>
          <div class="input-group col-10 mr-1">
            <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
            <span class="input-group-append">
              <button type="submit" class="btn btn-secondary px-3"><i class="fa fa-plus"></i></button>
            </span>
          </div>
        </form>
          <a href="/sekretaris/absensi/{{ $absensi->id }}" class="btn btn-primary">Simpan</a>
  </div>


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
            <th>Keterangan</th>
            <th>Aksi</th>
      </tr>
        </thead>
        <tbody>
          @foreach ($detail as $detail)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $detail->siswa->nisn }}</td>
            <td>{{ $detail->siswa->no_absen }}</td>
            <td>{{ $detail->siswa->nama }}</td>
            @if ($detail->status == '1')
                <td>Sakit</td>
            @elseif($detail->status == '2')
                <td>Izin</td>
            @elseif($detail->status == '3')
                <td>Alpa</td>
            @elseif($detail->status == '4')
                <td>Dispen</td>
            @endif
            <td>{{ $detail->keterangan }}</td>
            <td>
                  <div class="btn-group">
                    <a href="/sekretaris/download/{{ $detail->gambar }}" class="btn btn-info btn-xs rounded-0">Bukti</a>
                    <a href="/sekretaris/absensi-detail/{{ $detail->siswa->nisn }}/hapus" class="btn rounded-0 btn-danger btn-xs">Hapus</a>
                  </div>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>

    </div>


</div> <!-- /.container-fluid -->

@endsection

@push('js')
<script>
  $(function () {
    bsCustomFileInput.init();
  });
</script>
  
@endpush