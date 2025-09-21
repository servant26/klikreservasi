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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Reschedule</h3>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('user.update', $ajuan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Atas Nama</label>
                        <input type="text" class="form-control" value="{{ $ajuan->name }}" readonly>
                    </div>

                    <!-- Hidden atau Select untuk jenis -->
                    <input type="hidden" name="jenis" value="{{ old('jenis', $ajuan->jenis) }}">
                    {{-- Jika ingin user bisa ubah jenis, gunakan select: --}}
                    {{-- 
                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                            <option value="1" {{ old('jenis', $ajuan->jenis) == 1 ? 'selected' : '' }}>Reservasi Aula</option>
                            <option value="2" {{ old('jenis', $ajuan->jenis) == 2 ? 'selected' : '' }}>Kunjungan Perpustakaan</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    --}}

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
                                  $isPast  = $dateObj->lt(\Carbon\Carbon::today());

                                  $userAjuan = $ajuanUser[$tgl['date']] ?? null;
                                  $isUser = $userAjuan && $userAjuan->status != 4;

                                  // khusus jenis 1
                                  $isAcc   = ($ajuan->jenis == 1) ? isset($ajuanAcc[$tgl['date']]) : false;
                                  $instansi = $isAcc ? $ajuanAcc[$tgl['date']]->pluck('user.asal')->filter()->implode(', ') : '';
                                @endphp

                                <td>
                                  @if ($isPast)
                                    <span data-bs-toggle="tooltip" title="Tidak dapat membuat ajuan, tanggal sudah lewat">
                                      <button type="button" class="btn btn-outline-primary w-100 text-nowrap" disabled>
                                        {{ $tgl['label'] }}
                                      </button>
                                    </span>

                                @elseif ($ajuan->jenis == 1 && $isUser)
                                  <span data-bs-toggle="tooltip" title="Telah diajukan oleh Anda">
                                    <button type="button" class="btn btn-primary btn-user-submitted tanggal-btn w-100 text-nowrap" data-tanggal="{{ $tgl['date'] }}">
                                      {{ $tgl['label'] }}
                                    </button>
                                  </span>

                                  @elseif ($ajuan->jenis == 1 && $isAcc)
                                    <span data-bs-toggle="tooltip" title="Telah direservasi oleh: {{ $instansi }}">
                                      <button type="button" class="btn btn-danger w-100 text-nowrap" disabled>
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

                            {{-- Kosongkan sisa kolom di akhir --}}
                            @for ($j = $i % $cols; $j < $cols && $j != 0; $j++)
                              <td></td>
                            @endfor
                          </tr>
                        </table>
                      </div>

                      <!-- Tampilkan label tanggal yang dipilih -->
                      <div class="form-group mt-2" @error('tanggal') data-error-target="true" @enderror>
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

                    <div class="form-group">
                        <label>Jam</label>
                        <input type="time" name="jam"
                            class="form-control @error('jam') is-invalid @enderror"
                            required
                            value="{{ old('jam', \Carbon\Carbon::parse($ajuan->jam)->format('H:i')) }}">
                        @error('jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Jumlah Orang</label>
                        <input type="number" name="jumlah_orang"
                            class="form-control @error('jumlah_orang') is-invalid @enderror"
                            required 
                            value="{{ old('jumlah_orang', $ajuan->jumlah_orang) }}" placeholder="Masukkan jumlah orang">
                        @error('jumlah_orang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Upload Surat (JPG)</label>
                        <input type="file" name="surat" accept=".jpg,.jpeg,.png"
                            class="form-control @error('surat') is-invalid @enderror">
                        @if($ajuan->surat)
                            <p>Telah diunggah: <strong>{{ $ajuan->surat }}</strong></p>
                        @endif
                        @error('surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="{{ route('user.dashboard') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        </div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $("#tanggal").datepicker({
            dateFormat: "dd/mm/yy"
        });
    });
</script>
<script>
    $(document).ready(function() {
        @if ($ajuan->jenis == 2)
            $("#tanggal").datepicker({
                dateFormat: "dd/mm/yy"
            });
        @endif

        // Script untuk jenis == 1
        const tanggalButtons = document.querySelectorAll('.tanggal-btn');
        const hiddenInput = document.getElementById('selectedTanggal');
        const displayInput = document.getElementById('tanggalDisplay');

        tanggalButtons.forEach(button => {
            button.addEventListener('click', function () {
                const tanggal = this.getAttribute('data-tanggal');
                const label = this.innerText;

                hiddenInput.value = tanggal;
                displayInput.value = label;

                tanggalButtons.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                });

                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
            });
        });
    });

tanggalButtons.forEach(button => {
    button.addEventListener('click', function () {
        if (this.disabled) return; // tombol merah tidak bisa dipilih

        const tanggal = this.getAttribute('data-tanggal');
        const label = this.innerText;

        hiddenInput.value = tanggal;
        displayInput.value = label;

        tanggalButtons.forEach(btn => {
            // Hanya reset tombol yang BUKAN merah (btn-danger)
            if (!btn.classList.contains('btn-danger')) {
                btn.classList.remove('btn-primary', 'active');
                btn.classList.add('btn-outline-primary');
            }
        });

        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary', 'active');
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalButtons = document.querySelectorAll('.tanggal-btn');
    const hiddenInput = document.getElementById('selectedTanggal');
    const displayInput = document.getElementById('tanggalDisplay');

    // 1. Jika ada tanggal sudah dipilih (misal dari DB), tampilkan
    @if(old('tanggal') || $ajuan->tanggal)
        const existingTanggal = "{{ old('tanggal', $ajuan->tanggal) }}";
        const existingLabel = tanggalButtons.length > 0 ? Array.from(tanggalButtons).find(btn => btn.getAttribute('data-tanggal') === existingTanggal)?.innerText : '';
        if(existingTanggal) {
            hiddenInput.value = existingTanggal;
            displayInput.value = existingLabel || existingTanggal;

            // Tandai tombol yang sesuai
            tanggalButtons.forEach(btn => {
                if(btn.getAttribute('data-tanggal') === existingTanggal) {
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-primary', 'active');
                } else if(!btn.classList.contains('btn-danger')) {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-outline-primary');
                }
            });
        }
    @endif

    // 2. Klik tombol tanggal
    tanggalButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (this.disabled) return; // tombol merah tidak bisa dipilih

            const tanggal = this.getAttribute('data-tanggal');
            const label = this.innerText;

            hiddenInput.value = tanggal;
            displayInput.value = label;

            tanggalButtons.forEach(btn => {
                if (!btn.classList.contains('btn-danger')) {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-outline-primary');
                }
            });

            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary', 'active');
        });
    });
});
</script>

@endsection