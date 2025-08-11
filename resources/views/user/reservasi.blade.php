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

                <!-- Tombol Lihat Foto Aula -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#carouselModal">
                  Lihat Foto Aula
                </button>

                <!-- Pilih Tanggal -->
                <div class="form-group">
                  <label><strong>Pilih Tanggal</strong></label>
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <tr>
                        @php
                          $cols = 5;
                          $i = 0;
                        @endphp

                        @foreach ($tanggalList as $tgl)
                          @php
                            $isAcc = isset($ajuanAcc[$tgl['date']]);
                            $instansi = $isAcc ? $ajuanAcc[$tgl['date']]->pluck('user.asal')->filter()->implode(', ') : '';
                          @endphp
                        <td>
                          @if ($isAcc)
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="Telah direservasi oleh: {{ $instansi }}"
                                  style="display: inline-block; width: 100%;">
                              <button type="button"
                                      class="btn btn-danger w-100 text-nowrap"
                                      style="pointer-events: none;"
                                      disabled>
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

                        {{-- Kosongkan sisa kolom jika kurang dari 7 di akhir --}}
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
          <br><br>
        </div>
      </div>
    </div>
@endsection
