@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Form Ajuan Kunjungan Perpustakaan</h1>
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
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Silahkan isi datanya</h3>
          </div>
          <form id="kunjunganForm" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <!-- Nama User -->
              <div class="form-group">
                <label>Atas Nama</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
              </div>

              <!-- Tanggal -->
              <div class="form-group">
                <label>Tanggal</label>
                <input type="text" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required />
                @error('tanggal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Jam -->
              <div class="form-group">
                <label>Jam</label>
                <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam') }}" required>
                  @error('jam')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <!-- Deskripsi -->
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Jumlah Orang -->
              <div class="form-group">
                <label>Jumlah Orang</label>
                <input type="number" name="jumlah_orang" class="form-control @error('jumlah_orang') is-invalid @enderror" value="{{ old('jumlah_orang') }}" required>
                @error('jumlah_orang')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Upload Surat (JPG) -->
              <div class="form-group">
              <label>Upload Surat (JPG)</label>
              <input type="file" name="surat" accept=".jpg" class="form-control @error('surat') is-invalid @enderror" required>
                @error('surat')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <input type="hidden" name="jenis" value="{{ $jenis }}">
                <a class="btn btn-danger" href="{{ route('user.dashboard') }}">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
          <br><br>
        </div>
      </div>
    </div>
@endsection