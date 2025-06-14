@extends('staff.staffmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Balas Ajuan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Balas Ajuan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<form action="{{ route('staff.balasSubmit', $ajuan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">

        {{-- Identitas Pemohon --}}
        @php
            $nama = $ajuan->nama ?? '';
            $asal = $ajuan->asal ?? '';
            $identitas = trim("$nama, $asal", " ,/");
        @endphp
        <div class="form-group">
            <label>Identitas Pemohon :</label>
            <input type="text" class="form-control" value="{{ $identitas }}" readonly>
        </div>

        {{-- Deskripsi Pengajuan --}}
        @php
            use Carbon\Carbon;
            Carbon::setLocale('id');
            $hari = Carbon::parse($ajuan->tanggal)->translatedFormat('l');
            $tanggal = Carbon::parse($ajuan->tanggal)->translatedFormat('d F Y');
            $jam = date('H:i', strtotime($ajuan->jam));
            $jenisText = $ajuan->jenis == 1 ? 'Reservasi Aula' : 'Kunjungan Perpustakaan';
            $jumlah = $ajuan->jumlah_orang;
            $jadwal = "$hari, $tanggal pukul $jam";
        @endphp

        <div class="form-group">
            <label>Jenis Ajuan :</label>
            <input type="text" class="form-control" value="{{ $jenisText }} {{ $jumlah }} Orang" readonly>
        </div>

        <div class="form-group">
            <label>Jadwal :</label>
            <input type="text" class="form-control" value="{{ $jadwal }}" readonly>
        </div>


        {{-- Tombol Lihat Surat sejajar dengan label --}}
        @if($ajuan->surat)
        <div class="form-group d-flex align-items-center" style="gap: 1rem;">
            <label class="mb-0">Surat Ajuan :</label>
            <a href="{{ url('uploads/surat/' . $ajuan->surat) }}" target="_blank" class="btn btn-info btn-sm ms-auto">
                <i class="fas fa-eye"></i> Lihat Surat
            </a>
        </div>
        @endif

      <div class="form-group">
          <label>Deskripsi Ajuan :</label>
          <textarea class="form-control" rows="3" readonly>{{ $ajuan->deskripsi ?? '-' }}</textarea>
      </div>


        {{-- Upload Surat Balasan --}}
        <div class="form-group">
            <label>Upload Surat Balasan :</label>
            <input type="file" name="surat_balasan" class="form-control-file" accept="image/*">
            @if ($errors->has('surat_balasan'))
                <div class="text-danger mt-1">
                    {{ $errors->first('surat_balasan') }}
                </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-group mt-4">
            <a class="btn btn-danger" href="{{ route('staff.dashboard') }}">Back to Dashboard</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </div>
</form>



</div>
@endsection