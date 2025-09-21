@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Form Ajuan Reservasi Aula</h1>
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
    <!-- /.row -->
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Silahkan isi form berikut :</h3>
          </div>
          <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <!-- Nama User -->
                <div class="form-group">
                  <label>Atas Nama</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>

                <!-- Dropdown Tombol Lihat -->
                <div class="btn-group mb-3">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Lihat Foto Aula & SOP Reservasi
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#carouselModal">
                        Foto Aula
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sopModal">
                        SOP Reservasi
                      </a>
                    </li>
                  </ul>
                </div>


                <!-- Pilih Tanggal -->
                <div class="form-group">
                  <label><strong>Pilih Tanggal</strong></label>
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <tr>
                        @php
                          $cols = 4;
                          $i = 0;
                        @endphp
                        @foreach ($tanggalList as $tgl)
                        @php
                          $dateObj = \Carbon\Carbon::parse($tgl['date']);
                          $isPast = $dateObj->lt(\Carbon\Carbon::today());
                          $userAjuan = $ajuanUser[$tgl['date']] ?? null;
                          $instansi = isset($ajuanAcc[$tgl['date']])
                              ? $ajuanAcc[$tgl['date']]->pluck('user.asal')->filter()->implode(', ')
                              : '';
                        @endphp
                        <td>
                          @if ($isPast)
                            <span data-bs-toggle="tooltip"
                                  title="Tidak dapat membuat ajuan, tanggal sudah lewat">
                              <button class="btn btn-outline-primary w-100 text-nowrap" disabled>
                                {{ $tgl['label'] }}
                              </button>
                            </span>
                          @elseif ($userAjuan && $userAjuan->status != 4)
                            <span data-bs-toggle="tooltip"
                                  title="Telah diajukan oleh Anda">
                              <button class="btn btn-primary w-100 text-nowrap">
                                {{ $tgl['label'] }}
                              </button>
                            </span>
                          @elseif (isset($ajuanAcc[$tgl['date']]))
                            <span data-bs-toggle="tooltip"
                                  title="Telah direservasi oleh: {{ $instansi }}">
                              <button class="btn btn-danger w-100 text-nowrap" disabled>
                                {{ $tgl['label'] }}
                              </button>
                            </span>
                          @else
                            <button type="button"
                                    class="btn btn-outline-primary tanggal-btn w-100 text-nowrap"
                                    data-tanggal="{{ $tgl['date'] }}">
                              {{ $tgl['label'] }}
                            </button>
                          @endif
                        </td>
                          @php $i++; @endphp
                          @if ($i % $cols == 0)
                            </tr><tr>
                          @endif
                        @endforeach
                        {{-- Kosongkan sisa kolom jika kurang dari 5 di akhir --}}
                        @for ($j = $i % $cols; $j < $cols && $j != 0; $j++)
                          <td></td>
                        @endfor
                      </tr>
                    </table>
                  </div>

                  <!-- Tampilkan label tanggal yang dipilih -->
                  <div class="form-group mt-2" 
                      @error('tanggal') data-error-target="true" @enderror>
                      <label><strong>Tanggal Terpilih</strong></label>
                      <input 
                          type="text" 
                          id="tanggalDisplay" 
                          name="tanggal_display"
                          class="form-control @error('tanggal') is-invalid @enderror" 
                          placeholder="Belum ada tanggal dipilih" 
                          readonly>
                  </div>

                  <!-- Input hidden untuk backend -->
                  <input type="hidden" name="tanggal" id="selectedTanggal">

                  @error('tanggal')
                      <div class="text-danger">{{ $message }}</div>
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

                <!-- Jumlah Orang -->
                <div class="form-group">
                  <label>Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="form-control @error('jumlah_orang') is-invalid @enderror" value="{{ old('jumlah_orang') }}" required placeholder="Masukkan jumlah orang">
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
          <!-- Modal Carousel -->
          <div class="modal fade" id="carouselModal" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="carouselModalLabel">Foto Aula</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                  <div id="carouselAula" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      @for ($i = 1; $i <= 6; $i++)
                        <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                          <img src="{{ asset('dist/img/reservasi' . $i . '.jpg') }}" class="d-block w-100" alt="Reservasi {{ $i }}">
                        </div>
                      @endfor
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAula" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselAula" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal SOP -->
          <div class="modal fade" id="sopModal" tabindex="-1" aria-labelledby="sopModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="sopModalLabel">SOP Reservasi Aula</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                  <div id="carouselSOP" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      @for ($i = 1; $i <= 2; $i++)   {{-- ubah jumlah sesuai banyaknya gambar SOP --}}
                        <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                          <img src="{{ asset('dist/img/sop' . $i . '.png') }}" class="d-block w-100" alt="SOP {{ $i }}">
                        </div>
                      @endfor
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselSOP" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselSOP" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <br><br>
        </div>
      </div>
    </div>
@endsection
