@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengajuan Kunjungan Perpustakaan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Form</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
            <div class="card card-primary collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Lihat Jadwal</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Silahkan isi datanya</h3>
              </div>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                    <div class="form-group">
                        <label>Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" class="form-control @error('jumlah_orang') is-invalid @enderror" value="{{ old('jumlah_orang') }}" required autofocus>
                        @error('jumlah_orang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required />
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jam</label>
                        <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam') }}" required>
                        @error('jam')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                        <!-- Hidden input untuk 'jenis' -->
                        <input type="hidden" name="jenis" value="{{ $jenis }}">

                        <a class="btn btn-danger" href="{{ route('user.dashboard') }}">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
        <br><br>
    </div>
</div>
@endsection