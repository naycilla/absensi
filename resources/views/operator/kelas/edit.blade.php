@extends('layouts.main')

@section('title')
  Ubah Data Kelas 
@endsection

@section('body')
<div class="container-fluid">
    <div class="card mx-2">
        <div class="card-body">
            @if (auth()->user()->level == 3)
            <form action="/operator/data-kelas/{{ $kelas[0]->id }}" method="post">
            @endif
            @if (auth()->user()->level == 4)
            <form action="/admin/data-kelas/{{ $kelas[0]->id }}" method="post">
            @endif
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-lg-6">
                        <input type="hidden" name="id" value="{{ $kelas[0]->id }}">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror " id="nama_kelas" value="{{ old('nama_kelas', $kelas[0]->nama_kelas) }}">
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
