@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengajuan Reservasi/Kunjungan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Pengajuan Reservasi/Kunjungan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<div class="container">
    <div class="mx-1">
      <!-- <form action="{{ route('user.store') }}" method="POST"> -->
      <form action="" method="POST">
          @csrf
          <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama anda" autofocus>
          </div>
          <div class="form-group">
              <label>Asal</label>
              <input type="text" name="asal" class="form-control" required placeholder="Misal, dari TK... dari Universitas... dsb...">
          </div>
          <div class="form-group">
              <label>Nomor Whatsapp</label>
              <input type="tel" name="nomor_wa" class="form-control" required placeholder="Masukkan nomor yang bisa dihubungi">
          </div>
          <div class="form-group">
              <label>Jumlah Orang</label>
              <input type="number" name="jumlah_orang" class="form-control" required placeholder="Masukkan angka saja, misal 50, bukan 50 orang..">
          </div>
          <div class="form-group">
              <label>Jenis Ajuan</label>
              <select name="jenis" class="form-control" required>
                  <option value="" disabled selected>Pilih Jenis</option>
                  <option value="1">Kunjungan Perpustakaan</option>
                  <option value="2">Reservasi Aula</option>
              </select>
          </div>
          <div class="form-group">
              <label>Tanggal</label>
              <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Jam</label>
              <input type="time" name="jam" class="form-control" required>
          </div>
          <a class="btn btn-danger" href="{{ route('user.dashboard') }}" role="button">Kembali</a>
          <button type="submit" class="btn btn-primary">Kirim</button>
      </form>
        <br><br>
    </div>
</div>
@endsection