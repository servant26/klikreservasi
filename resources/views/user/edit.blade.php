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

<div class="form-group">
    <label>Tanggal</label>

    @if ($ajuan->jenis == 2)
        <input type="text" id="tanggal" name="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            required
            value="{{ old('tanggal', \Carbon\Carbon::parse($ajuan->tanggal)->format('d/m/Y')) }}">
        <!-- @error('tanggal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror -->
    @else
        {{-- Tampilkan pilihan tombol tanggal --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    @php $cols = 5; $i = 0; @endphp
                    @foreach ($tanggalList as $tgl)
                        @php
                            $isAcc = isset($ajuanAcc[$tgl['date']]);
                            $instansi = $isAcc ? $ajuanAcc[$tgl['date']]->pluck('user.asal')->filter()->implode(', ') : '';
                        @endphp
                        <td>
                            @if ($isAcc)
                                <span data-bs-toggle="tooltip"
                                    title="Telah direservasi oleh: {{ $instansi }}">
                                    <button type="button"
                                            class="btn btn-danger w-100"
                                            disabled>
                                        {{ $tgl['label'] }}
                                    </button>
                                </span>
                            @else
                                <button type="button"
                                        class="btn btn-outline-primary tanggal-btn w-100"
                                        data-tanggal="{{ $tgl['date'] }}">
                                    {{ $tgl['label'] }}
                                </button>
                            @endif
                        </td>
                        @php $i++; @endphp
                        @if ($i % $cols == 0)</tr><tr>@endif
                    @endforeach
                    @for ($j = $i % $cols; $j < $cols && $j != 0; $j++) <td></td> @endfor
                </tr>
            </table>
        </div>

        <div class="form-group mt-3">
            <label><strong>Tanggal Terpilih</strong></label>
            <input type="text" id="tanggalDisplay" class="form-control" placeholder="Belum ada tanggal dipilih" readonly disabled>
        </div>

        <input type="hidden" name="tanggal" id="selectedTanggal" value="{{ old('tanggal', $ajuan->tanggal) }}">
        @error('tanggal')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    @endif
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
                        <label>Deskripsi</label>
                        <textarea name="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            required>{{ old('deskripsi', $ajuan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jumlah Orang</label>
                        <input type="number" name="jumlah_orang"
                            class="form-control @error('jumlah_orang') is-invalid @enderror"
                            required
                            value="{{ old('jumlah_orang', $ajuan->jumlah_orang) }}">
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
</script>
@endsection