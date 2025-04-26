@extends('user.usermaster')
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
              <li class="breadcrumb-item"><a href="#">User</a></li>
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
@if($ajuan->where('user_id', auth()->id())->isEmpty())
    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- Card abu-abu untuk user yang belum mengajukan -->
            <div class="small-box bg-secondary text-white p-2">
                <div class="inner text-left">
                    <h4>Selamat datang di Web Reservasi Kunjungan Perpustakaan</h4>
                    <p>Silahkan pilih layanan yang anda inginkan</p>
                    <!-- Tombol untuk mengajukan reservasi -->
                    <!-- <a class="btn btn-outline-light btn-sm" href="{{ route('user.tambah') }}" role="button">
                        Ajukan Kunjungan/Reservasi
                    </a> -->
                </div>
                <div class="icon">
                    <i class="fas fa-info-circle"></i>
                </div>
            </div>
        </div>
    </div>
@else
    @foreach($ajuan as $a)
        @if($a->user_id == auth()->id())
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="small-box 
                        {{ $a->status == 1 ? 'bg-danger text-white' : ($a->status == 2 ? 'bg-primary text-white' : 'bg-warning') }} 
                        p-2">
                        <div class="inner text-left">
                            <h4>Status Ajuan Reservasi/Kunjungan</h4>
                            <p>
                                Anda telah mengajukan 
                                @if($a->jenis == 1)
                                    kunjungan perpustakaan
                                @elseif($a->jenis == 2)
                                    reservasi aula
                                @endif
                                pada {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }}
                                dengan jumlah {{ $a->jumlah_orang }} orang.
                                <br>
                                @if($a->status == 1)
                                    Mohon tunggu, data ajuan anda sedang diproses.
                                @elseif($a->status == 2)
                                    Ajuan anda selesai diproses. Silakan datang pada waktu yang telah ditentukan.
                                @elseif($a->status == 3)
                                    Mohon tunggu, reschedule anda sedang diproses.
                                @endif
                            </p>
                            <!-- Tombol untuk reschedule -->
                            <a href="{{ route('user.edit', $a->id) }}" 
                              class="btn {{ in_array($a->status, [1, 2]) ? 'btn-outline-light' : ($a->status == 3 ? 'btn-outline-dark' : 'btn-outline-secondary') }} btn-sm">
                              Reschedule/Ganti Jadwal
                            </a>
                        </div>
                        <div class="icon">
                            <i class="fas 
                                {{ $a->status == 1 ? 'fa-hourglass-half' : ($a->status == 2 ? 'fa-check-circle' : 'fa-sync-alt') }}">
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif


<div class="row">
  <!-- Column 1: New Orders and Bounce Rate -->
  <div class="col-lg-6 col-6">
    <!-- New Orders -->
    <div class="small-box bg-info mb-3">
      <div class="inner">
        <h4>Reservasi Aula</h4>
        <p><br><br></p>
      </div>
      <div class="icon">
        <i class="fas fa-building"></i>
      </div>
      <a href="{{ route('user.tambah') }}" class="small-box-footer">Buat Ajuan <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-6 col-6">
    <!-- Bounce Rate -->
    <div class="small-box bg-success">
      <div class="inner">
        <h4>Kunjungan Perpustakaan</h4>
        <p><br><br></p>
      </div>
      <div class="icon">
        <i class="fas fa-book"></i>
      </div>
      <a href="{{ route('user.tambah') }}" class="small-box-footer">Buat Ajuan <i class="fas fa-arrow-circle-right"></i></a>
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