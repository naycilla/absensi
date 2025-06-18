@extends('layouts.main')

@section('title')
  Selamat Datang, {{ auth()->user()->pengelola->nama }}
@endsection

@section('body')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @can('admin')
          <div class="col-12 col-sm-8 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chalkboard p-3"></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">Jumlah Kelas</span>

                <span class="info-box-number">
                  {{ $kelas }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endcan
          @can('operator')
          <div class="col-12 col-sm-8 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chalkboard p-3"></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">Jumlah Kelas</span>

                <span class="info-box-number">
                  {{ $kelas }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          @endcan
            <!-- /.col -->
            <!-- /.col -->
  
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
            <!-- /.col -->
            <div class="col-12 col-sm-8 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Jumlah siswa</span>
                  <span class="info-box-number">{{ $siswa }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            {{-- @if (auth()->user()->level == 4) --}}
            @can('admin')
            <div class="col-12 col-sm-8 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Jumlah operator</span>
                  <span class="info-box-number">{{ $operator }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-8 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Jumlah Admin</span>
                  <span class="info-box-number">{{ $admin }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            @endcan
            {{-- @endif --}}
  
            <!-- /.col -->
          </div>
  

        <!-- Small boxes (Stat box) -->
      </div> <!-- /.row -->      
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

 @endsection
