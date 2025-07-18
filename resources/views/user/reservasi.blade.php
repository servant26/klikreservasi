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

                <input type="hidden" name="tanggal" id="selectedTanggal">
                @error('tanggal')
                  <div class="text-danger mt-2">{{ $message }}</div>
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
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.tanggal-btn');
    const hiddenInput = document.getElementById('selectedTanggal');

    buttons.forEach(btn => {
      btn.addEventListener('click', function () {
        if (btn.classList.contains('disabled')) return;

        // Hapus semua highlight
        buttons.forEach(b => b.classList.remove('active', 'btn-success'));
        // Tambah highlight ke tombol aktif
        btn.classList.add('active', 'btn-success');
        // Set nilai ke hidden input
        hiddenInput.value = btn.getAttribute('data-tanggal');
      });
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (el) {
      new bootstrap.Tooltip(el);
    });
  });
</script>

@endpush
