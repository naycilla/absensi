@extends('layouts.main')

@section('title')
  Ubah Data Siswa
@endsection

@section('body')
<div class="container-fluid">
    <div class="card mx-2">
        <div class="card-body">
            @if (auth()->user()->level === 3)
                <form action="/operator/data-siswa/{{ $siswa[0]->nisn }}/edit" method="post">
            @endif
            @if (auth()->user()->level === 4)
                <form action="/admin/data-siswa/{{ $siswa[0]->nisn }}/edit" method="post">
            @endif
                @csrf
                <div class="row">
                    <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                    <div class="form-group col-lg-2">
                        <label for="no_absen">No Absen</label>
                        <input type="text" name="no_absen" class="form-control @error('no_absen') is-invalid @enderror " id="no_absen" value="{{ old('no_absen', $siswa[0]->no_absen) }}">
                        @error('no_absen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" id="nisn" value="{{ old('nisn', $siswa[0]->nisn)}}">
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror                          
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror " id="nama" value="{{ old('nama', $siswa[0]->nama)}}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>    
                    <div class="form-group col-3">
                        <label for="level">Status</label>

                        <select class="custom-select" name="level">
                        @if ($level == 2)
                        <option value="2" selected>Sekretaris</option>
                        <option value="1" >Siswa</option>
                        @elseif($level == 1)
                        <option value="2">Sekretaris</option>
                        <option value="1" selected>Siswa</option>
                        @endif
                        </select>
                    </div>
            
                <button type="submit" class="btn btn-sm btn-primary mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
