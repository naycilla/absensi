@extends('layouts.main')

@section('title')
  Ubah Data User
@endsection

@section('body')
<div class="container-fluid">
    <div class="card mx-2">
        <div class="card-body">
            <form action="/admin/kelola-user/{{ $user[0]->id }}" method="post">
                @csrf
                @method('put')                
                  <div class="row mx-1 mt-2">
                    <div class="form-group col-3">
                      <input type="text" class="form-control @error('nuptk') is-invalid @enderror" placeholder="NUPTK" name="nuptk" value="{{ old('nuptk', $user[0]->pengelola->nuptk) }}" autofocus>
                      @error('nuptk')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
            
                  <div class="form-group col-5">
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" name="nama" value="{{ old('nama', $user[0]->pengelola->nama) }}" autofocus>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <input type="text" class="form-control @error('nohp') is-invalid @enderror" placeholder="Nomor HP" name="nohp" value="{{ old('nohp', $user[0]->pengelola->nohp) }}">
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="row mx-1 mb-1">
            
                    <div class="form-group col-12">
                        <select class="custom-select" name="level">
                        @if (old('level', $user[0]->level) == 4)
                            <option value="3">Operator</option>
                            <option value="4" selected>Admin</option>
                        @else
                            <option value="3">Operator</option>
                            <option value="4" >Admin</option>
                        @endif
                        </select>
                      </div>

                    <div class="form-group col-12">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username', $user[0]->username) }}" autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-1 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            
                  </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
