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
            <div class="card card-primary collapsed-card">
              <div class="card-header">
                <h3 class="card-title">List Jadwal</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
    <div class="card-body">
        @if($ajuanLain->isEmpty())
            <p>Tidak ada jadwal yang akan datang.</p>
        @else
            <ul>
                @foreach($ajuanLain as $a)
                    @php
                        $tanggal = \Carbon\Carbon::parse($a->tanggal);
                        $jam = \Carbon\Carbon::parse($a->jam);
                        $periode = match (true) {
                            $jam->hour < 12 => 'pagi',
                            $jam->hour < 15 => 'siang',
                            $jam->hour < 18 => 'sore',
                            default => 'malam',
                        };
                    @endphp
                    <li>
                        {{ $a->user->asal ?? 'Asal tidak diketahui' }} :
                        {{ $tanggal->translatedFormat('l, d F Y') }} jam {{ $jam->format('H:i') }} {{ $periode }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        </div>
<div class="container">
    <div class="mx-1">
    <form action="{{ route('user.update', $ajuan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Atas Nama</label>
            <input type="text" class="form-control" value="{{ $ajuan->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required value="{{ old('tanggal', \Carbon\Carbon::parse($ajuan->tanggal)->format('d/m/Y')) }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jam</label>
            <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" required value="{{ old('jam', \Carbon\Carbon::parse($ajuan->jam)->format('H:i')) }}">
            @error('jam')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jenis Ajuan</label>
            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                <option value="1" {{ old('jenis', $ajuan->jenis) == 1 ? 'selected' : '' }}>Reservasi Aula</option>
                <option value="2" {{ old('jenis', $ajuan->jenis) == 2 ? 'selected' : '' }}>Kunjungan Perpustakaan</option>
            </select>
            @error('jenis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $ajuan->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jumlah Orang</label>
            <input type="number" name="jumlah_orang" class="form-control @error('jumlah_orang') is-invalid @enderror" required value="{{ old('jumlah_orang', $ajuan->jumlah_orang) }}">
            @error('jumlah_orang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Upload Surat (JPG)</label>
            <input type="file" name="surat" accept=".jpg,.jpeg" class="form-control @error('surat') is-invalid @enderror">
            
            <!-- Tampilkan keterangan surat lama jika ada -->
            @if($ajuan->surat)
                <p>Telah diunggah : {{ $ajuan->surat }}</p>
            @endif
            
            @error('surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

          <a href="{{ route('user.dashboard') }}" class="btn btn-danger">Back</a>
          <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <br><br>
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
@endsection
