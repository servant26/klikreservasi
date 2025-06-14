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
            <div class="small-box p-3" style="background-color: #f0f0f0; border: 1px solid black;">
                <div class="inner text-left">
                    <h4 style="font-size: clamp(1.2rem, 2.5vw, 1.6rem);">Selamat datang di Web Reservasi Aula dan Kunjungan Perpustakaan</h4>
                    <p style="font-size: clamp(0.8rem, 2vw, 1rem);">Silahkan pilih layanan yang anda inginkan</p>
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
                    <div class="small-box p-3" 
                         style="background-color: 
                         {{ $a->status == 1 ? '#f77267' : ($a->status == 2 ? '#d0e6ff' : '#ffe07d') }};
                         border: 1px solid black;">
                        <div class="inner text-left">
                        <h4>
                            {{ $a->status == 1 ? 'Ajuan sedang diproses' : ($a->status == 2 ? 'Ajuan telah diterima' : 'Reschedule sedang diproses') }}
                        </h4>
                            <p>
                                Anda telah mengajukan 
                                @if($a->jenis == 1)
                                    Reservasi Aula
                                @elseif($a->jenis == 2)
                                    Kunjungan Perpustakaan
                                @endif
                                pada {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }}
                                dengan jumlah {{ $a->jumlah_orang }} orang.
                                <br>
                                @if($a->status == 1)
                                    Mohon tunggu, data ajuan anda sedang diproses.
                                @elseif($a->status == 2)
                                    Ajuan anda selesai diproses. Silakan datang pada waktu yang telah ditentukan.
                                @elseif($a->status == 3)
                                    Mohon tunggu, perubahan jadwal anda sedang diproses.
                                @endif
                            </p>
                          <div class="btn-container" style="display: flex; gap: 6px;">
                            <a href="{{ route('user.edit', $a->id) }}" class="btn btn-dark btn-sm">
                                Ubah Data Ajuan
                            </a>
                          <!-- Form Cancel (hidden) -->
                          <form id="delete-form-{{ $a->id }}" action="{{ route('user.destroy', $a->id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                          </form>

                          <!-- Tombol Cancel dengan SweetAlert konfirmasi -->
                          <button type="button" class="btn btn-dark btn-sm" onclick="confirmDelete({{ $a->id }})">
                              Batalkan Ajuan
                          </button>
                          @if($a->status == 2)
                              <div class="btn-group">
                                  <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                      Surat Balasan
                                  </button>
                                  <ul class="dropdown-menu">
                                      <li>
                                          <a class="dropdown-item" href="{{ url($a->surat_balasan) }}" target="_blank">
                                              Lihat Surat Balasan
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item" href="{{ url($a->surat_balasan) }}" download>
                                              Download Surat Balasan
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          @endif
                          </div>
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
  <!-- Reservasi Aula -->
  <div class="col-lg-6 col-md-12 mb-4">
    <a href="{{ route('user.reservasi') }}" style="text-decoration: none;">
      <div class="small-box"
        style="position: relative; overflow: hidden; border-radius: 10px; height: 200px; cursor: pointer;"
        onmouseover="this.querySelector('.desc').style.opacity='1'"
        onmouseout="this.querySelector('.desc').style.opacity='0'">
        
        <div class="bg-image" style="background: url('{{ asset('dist/img/reservasi.jpg') }}') center/cover no-repeat; width: 100%; height: 100%; transition: transform 0.5s ease;"></div>
        
        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1;"></div>
        
        <div class="inner text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; color: #fff; width: 90%;">
          <h4 style="margin-bottom: 10px; font-size: clamp(1.6rem, 2.0vw, 2.0rem);">Reservasi Aula</h4>
          <p class="desc" style="font-size: 14px; margin: 0; opacity: 0; transition: opacity 0.5s ease;">
            Ajukan pemesanan aula untuk kegiatan anda di sini!
          </p>
        </div>
      </div>
    </a>
  </div>

  <!-- Kunjungan Perpustakaan -->
  <div class="col-lg-6 col-md-12 mb-4">
    <a href="{{ route('user.kunjungan') }}" style="text-decoration: none;">
      <div class="small-box"
        style="position: relative; overflow: hidden; border-radius: 10px; height: 200px; cursor: pointer;"
        onmouseover="this.querySelector('.desc').style.opacity='1'"
        onmouseout="this.querySelector('.desc').style.opacity='0'">
        
        <div class="bg-image" style="background: url('{{ asset('dist/img/kunjungan.jpg') }}') center/cover no-repeat; width: 100%; height: 100%; transition: transform 0.5s ease;"></div>
        
        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1;"></div>
        
        <div class="inner text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; color: #fff; width: 90%;">
          <h4 style="margin-bottom: 10px; font-size: clamp(1.6rem, 2.0vw, 2.0rem);">Kunjungan Perpustakaan</h4>
          <p class="desc" style="font-size: 14px; margin: 0; opacity: 0; transition: opacity 0.5s ease;">
            Buat jadwal kunjungan perpustakaan lebih mudah!
          </p>
        </div>
      </div>
    </a>
  </div>
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
@section('scripts')
<script>
    // Fungsi untuk konfirmasi delete menggunakan SweetAlert
    function confirmDelete(id) {
        Swal.fire({
        title: 'Yakin ingin membatalkan ajuan?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Batalkan ajuan!',
        cancelButtonText: 'Kembali',
        reverseButtons: true // Membalikkan posisi tombol
        }).then((result) => {
            if (result.isConfirmed) {
                // Menampilkan notifikasi bahwa data berhasil dihapus
                Swal.fire({
                    icon: 'success',
                    title: 'Ajuan berhasil dihapus!',
                    text: 'Ajuan Anda telah dihapus.',
                    showConfirmButton: false,
                    timer: 1500 // Notifikasi akan ditampilkan selama 1.5 detik
                }).then(() => {
                    // Setelah notifikasi selesai, submit form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                });
            }
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif
@endsection
