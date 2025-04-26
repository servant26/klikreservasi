@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Reschedule</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Reschedule</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
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
        </div>
<div class="container">
    <div class="mx-1">
      <form action="{{ route('user.update', $ajuan->id) }}" method="POST">
          @csrf
          <!-- <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" value="{{ $ajuan->name }}" readonly>
          </div>

          <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" value="{{ $ajuan->email }}" readonly>
          </div>

          <div class="form-group">
              <label>Kontak Whatsapp</label>
              <input type="text" class="form-control" value="{{ $ajuan->whatsapp }}" readonly>
          </div>-->

          <div class="form-group">
              <label>Jumlah Orang</label>
              <input type="number" name="jumlah_orang" class="form-control" required value="{{ $ajuan->jumlah_orang }}" autofocus>
          </div>

          <!-- <div class="form-group">
              <label>Jenis Ajuan</label>
              <select name="jenis" class="form-control" required>
                  <option value="1" {{ $ajuan->jenis == 1 ? 'selected' : '' }}>Kunjungan Perpustakaan</option>
                  <option value="2" {{ $ajuan->jenis == 2 ? 'selected' : '' }}>Reservasi Aula</option>
              </select>
          </div> -->

          <div class="form-group">
              <label>Tanggal</label>
              <input type="date" name="tanggal" class="form-control" required value="{{ $ajuan->tanggal }}">
          </div>

          <div class="form-group">
              <label>Jam</label>
              <input type="time" name="jam" class="form-control" required value="{{ \Carbon\Carbon::parse($ajuan->jam)->format('H:i') }}">
          </div>

          <a href="{{ route('user.dashboard') }}" class="btn btn-danger">Back</a>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>
        <br><br>
    </div>
</div>
@endsection
