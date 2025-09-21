@extends('user.usermaster')
@section('menu')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
  @if($ajuan->isEmpty())
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
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="small-box p-3"
          style="background-color: 
            {{ $a->status == 1 ? '#d3d3d3' : ($a->status == 2 ? '#d0e6ff' : ($a->status == 3 ? '#ffe07d' : '#f77267')) }};
              border: 1px solid black;">
                <div class="inner text-left">
                  <h4>
                    @switch($a->status)
                      @case(1)
                        Ajuan sedang diproses
                      @break
                      @case(2)
                        Ajuan telah diterima
                      @break
                      @case(3)
                        Reschedule sedang diproses
                      @break
                      @case(4)
                        Ajuan ditolak
                      @break
                    @endswitch
                  </h4>
                  <p>
                    @switch($a->status)
                      @case(2)
                        Ajuan untuk 
                        @if($a->jenis == 1)
                          Reservasi Aula
                        @elseif($a->jenis == 2)
                          Kunjungan Perpustakaan
                        @endif 
                          pada hari {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }} telah diterima. 
                          Silakan berkunjung pada waktu yang telah ditentukan atau hubungi PIC untuk konfirmasi lebih lanjut.
                        @break

                        @case(3)
                          Anda telah melakukan reschedule untuk 
                          @if($a->jenis == 1)
                            Reservasi Aula
                          @elseif($a->jenis == 2)
                            Kunjungan Perpustakaan
                          @endif 
                            pada hari {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }}.
                            Mohon tunggu, perubahan jadwal sedang diproses.
                          @break

                        @case(4)
                          Mohon maaf, ajuan untuk 
                          @if($a->jenis == 1)
                            Reservasi Aula
                          @elseif($a->jenis == 2)
                            Kunjungan Perpustakaan
                          @endif 
                            pada hari {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }} ditolak. 
                            Silahkan ajukan untuk tanggal lain atau hubungi PIC untuk konfirmasi lebih lanjut: 
                          @break

                        @default
                          Anda telah mengajukan 
                          @if($a->jenis == 1)
                            Reservasi Aula
                          @elseif($a->jenis == 2)
                            Kunjungan Perpustakaan
                          @endif 
                            untuk hari {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ substr($a->jam, 0, 5) }} dengan jumlah {{ $a->jumlah_orang }} orang.
                          <br>
                            Mohon tunggu, data ajuan anda sedang diproses.
                        @endswitch
                  </p>

                  <div class="btn-container" style="display: flex; gap: 6px;">
                      <a href="{{ route('user.edit', $a->id) }}" class="btn btn-dark btn-sm">
                          Ubah Data Ajuan
                      </a>

                      @if($a->status == 4)
                          <!-- Form Cancel -->
                          <form id="delete-form-{{ $a->id }}" action="{{ route('user.destroy', $a->id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                          </form>
                          <button type="button" class="btn btn-dark btn-sm" onclick="confirmDelete({{ $a->id }})">
                              Hapus Ajuan
                          </button>

                          <a href="https://wa.me/62812345678" target="_blank" class="btn btn-dark btn-sm" style="color: white;">
                              Hubungi PIC
                          </a>
                      @else
                          <!-- Form Cancel -->
                          <form id="delete-form-{{ $a->id }}" action="{{ route('user.destroy', $a->id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                          </form>
                          <button type="button" class="btn btn-dark btn-sm" onclick="confirmDelete({{ $a->id }})">
                              Batalkan Ajuan
                          </button>

                          @if($a->status == 2)
                              <a href="https://wa.me/62812345678" target="_blank" class="btn btn-dark btn-sm" style="color: white;">
                                  Hubungi PIC
                              </a>
                          @endif
                      @endif
                  </div>

                </div>

                <div class="icon">
                  <i class="fas 
                    {{ $a->status == 1 ? 'fa-hourglass-half' : 
                    ($a->status == 2 ? 'fa-check-circle' : 
                    ($a->status == 3 ? 'fa-sync-alt' : 'fa-times-circle')) }}">
                  </i>
                </div>
        </div>
      </div>
    </div>
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
        
        <div class="bg-image" style="background: url('{{ asset('dist/img/reservasi1.jpg') }}') center/cover no-repeat; width: 100%; height: 100%; transition: transform 0.5s ease;"></div>
        
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
        
        <div class="bg-image" style="background: url('{{ asset('dist/img/perpustakaan3.jpg') }}') center/cover no-repeat; width: 100%; height: 100%; transition: transform 0.5s ease;"></div>
        
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

<h4>Panduan Penggunaan : <br></h4>
<div class="accordion mb-5" id="accordionExample">
  <!-- 1 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        <h6>Buat Ajuan (Reservasi Aula/Kunjungan Perpustakaan)</h6>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
      <div class="accordion-body">
        Proses pengajuan <b><a href="{{ route('user.reservasi') }}">Reservasi Aula</a></b> dan <b><a href="{{ route('user.kunjungan') }}">Kunjungan Perpustakaan</a></b> dapat dilakukan pada menu masing-masing, setelah masuk ke salah satu menu, lakukan penginputan data sesuai dengan ketentuan yang ada. <b>Jangan lupa</b> untuk mengupload surat ajuan yang terdapat pada akhir form.
      </div>
    </div>
  </div>

  <!-- 2 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <h6>Status Ajuan</h6>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
      <div class="accordion-body">
        Terdapat 4 status ajuan pada sistem web ini :
        <ul>
          <li><span class="badge bg-secondary">Abu-abu</span> berarti ajuan tersebut <b>sedang diproses</b>.</li>
          <li><span class="badge bg-danger">Merah</span> berarti ajuan tersebut <b>ditolak</b>.</li>
          <li><span class="badge bg-warning text-dark">Kuning</span> untuk menandakan bahwa <b>ajuan telah diubah</b>.</li>
          <li><span class="badge bg-primary">Biru</span> untuk status <b>ajuan diterima</b>.</li>
        </ul>
        <b>Pastikan</b> bahwa status ajuan tersebut berwarna <span class="badge bg-primary">Biru</span>! Jika status ajuan berwarna <span class="badge bg-danger">Merah</span>, dipersilahkan untuk membuat ajuan lainnya atau hubungi PIC untuk informasi lebih lanjut.
      </div>
    </div>

  </div>

  <!-- 3 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <h6>Reschedule</h6>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
      <div class="accordion-body">
        Data ajuan yang telah dibuat <b>dapat diubah kembali</b>, anda hanya perlu menekan tombol <b>"Ubah Data Ajuan"</b> pada bagian status card, setelah masuk ke halaman reschedule, lakukan penginputan data yang ingin diubah, baik itu tanggal, waktu, dan sebagainya, kemudian tekan tombol submit.
      </div>
    </div>
  </div>

  <!-- 4 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <h6>Batalkan Ajuan<h6>
      </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour">
      <div class="accordion-body">
        Untuk membatalkan ajuan, anda hanya perlu menekan tombol <b>Batalkan Ajuan</b> yang terdapat pada status ajuan. <b>Perlu dipahami bahwa</b> tombol batalkan ajuan ini hanya akan muncul ketika pengguna telah membuat ajuan.
      </div>
    </div>
  </div>

  <!-- 5 -->
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingFive">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        <h6>Ubah Profil<h6>
      </button>
    </h2>
    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive">
      <div class="accordion-body">
        Anda dapat melakukan perubahan data pada halaman <b><a href="{{ route('user.profile') }}">profile</a></b>, pada halaman tersebut, anda dapat mengubah data seperti nama, email, whatsapp, hingga password.
      </div>
    </div>
  </div>
</div>
<br>
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
