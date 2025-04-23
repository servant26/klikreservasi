@extends('staff.staffmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Staff</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <!-- Column 1: New Orders and Bounce Rate -->
  <div class="col-lg-4 col-6">
    <!-- New Orders -->
    <div class="small-box bg-info mb-3">
      <div class="inner">
        <h3>{{ $ajuan->count() }}</h3>
        <p>Total Kunjungan/Reservasi Bulan Ini</p>
      </div>
      <div class="icon">
        <i class="far fa-envelope"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <!-- New Orders -->
    <div class="small-box bg-warning mb-3">
      <div class="inner">
        <h3>{{ $reschedule }}</h3>
        <p>Reschedule</p>
      </div>
      <div class="icon">
        <i class="fas fa-sync"></i>
      </div>
      <a href="{{ route('staff.reschedule') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-6">
    <!-- Bounce Rate -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $kunjungan }}</h3>
        <p>Ajuan Kunjungan Perpustakaan</p>
      </div>
      <div class="icon">
        <i class="fas fa-book"></i>
      </div>
      <a href="{{ route('staff.kunjungan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <!-- Bounce Rate -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $reservasi }}</h3>
        <p>Ajuan Reservasi Aula</p>
      </div>
      <div class="icon">
        <i class="fas fa-building"></i>
      </div>
      <a href="{{ route('staff.reservasi') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- Column 2: Calendar -->
  <div class="col-lg-4 col-12">
    <div class="card bg-gradient-success">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="far fa-calendar-alt"></i>
          Calendar
        </h3>
        <div class="card-tools">
          <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
              <i class="fas fa-bars"></i>
            </button>
            <div class="dropdown-menu" role="menu">
              <a href="#" class="dropdown-item">Add new event</a>
              <a href="#" class="dropdown-item">Clear events</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">View calendar</a>
            </div>
          </div>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body pt-0">
        <div id="calendar" style="width: 100%"></div>
      </div>
    </div>
  </div> 
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title">Petunjuk Penggunaan</h3>
      </div>
      <div class="card-body">
        Berikut merupakan tata cara pembuatan ajuan layanan pada perpustakaan :<br><br>
        <ol>
          <li>Pengunjung melakukan registrasi terlebih dahulu pada halaman register.</li>
          <li>Setelah melakukan registrasi dan berhasil masuk ke halaman web, akan tampil 2 layanan pilihan seperti yang tertera di atas, yaitu reservasi aula, dan kunjungan perpustakaan.</li>
          <li>Ketika masuk ke salah satu halaman layanan, sistem web akan menunjukkan sebuah form yang harus diisi oleh user, salah satunya seperti tanggal ajuan, form tersebut tentunya berkaitan dengan data yang ingin diajukan.</li>
          <li>User juga dapat melihat jadwal yang tersedia pada halaman form tersebut.</li>
          <li>User tidak dapat membuat ajuan pada waktu yang sama dengan user lainnya, jika hal tersebut terjadi, maka sistem web akan memberikan notifikasi untuk memberitahukan hal tersebut.</li>
          <li>Setelah membuat ajuan, akan muncul status bar pada halaman atas yang menampilkan status ajuan yang telah dibuat oleh user, merah berarti sedang diproses, kuning berarti reschedule, dan biru berarti ajuan tersebut telah diterima.</li>
          <li>User dapat mengubah data yang telah diajukan, tidak ada batasan tertentu terkait hal tersebut.</li>
        </ol>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<div class="card bg-gradient-primary" style="display: none;">
  <div class="card-header border-0">
    <h3 class="card-title">
      <i class="fas fa-map-marker-alt mr-1"></i>
      Visitors
    </h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
        <i class="far fa-calendar-alt"></i>
      </button>
      <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <div id="world-map" style="height: 250px; width: 100%;"></div>
  </div>
  <div class="card-footer bg-transparent">
    <div class="row">
      <div class="col-4 text-center">
        <div id="sparkline-1"></div>
        <div class="text-white">Visitors</div>
      </div>
      <div class="col-4 text-center">
        <div id="sparkline-2"></div>
        <div class="text-white">Online</div>
      </div>
      <div class="col-4 text-center">
        <div id="sparkline-3"></div>
        <div class="text-white">Sales</div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
@endsection