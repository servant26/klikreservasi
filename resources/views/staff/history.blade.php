@extends('staff.staffmaster')
@section('menu')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">History</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($aktivitas->isEmpty())
            <p>Belum ada aktivitas untuk saat ini.</p>
        @else
            <ul class="list-group">
                @foreach($aktivitas as $item)
                    @php
                        $statusLama = $item->status_lama;
                        $statusBaru = $item->status_baru;
                        $timeAgo = \Carbon\Carbon::parse($item->created_at)->diffForHumans();

                        $user = $item->ajuan->user->name ?? 'User';
                        $instansi = $item->ajuan->user->asal ?? 'Instansi';
                        $jenis = $item->ajuan->jenis == 1 ? 'reservasi aula' : 'kunjungan perpustakaan';
                        $tanggal = \Carbon\Carbon::parse($item->ajuan->tanggal)->translatedFormat('l, d F Y');
                        $jam = \Carbon\Carbon::parse($item->ajuan->jam)->format('H:i');

                        $keterangan = '';
                        $borderClass = ''; // Default border class

                        if (in_array($statusLama, [1, 3]) && $statusBaru == 2) {
                            $keterangan = "Anda menerima ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                            $borderClass = 'status-accepted'; // Border warna biru untuk diterima
                        } elseif ($statusLama == 2 && $statusBaru == 1) {
                            $keterangan = "Anda membatalkan ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                            $borderClass = 'status-cancelled'; // Border warna merah untuk dibatalkan
                        } else {
                            $keterangan = "Anda mengubah status ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                            // Tidak perlu border khusus jika status berubah, hanya default border
                        }
                    @endphp

                    <li class="list-group-item {{ $borderClass }}">
                        {{ $keterangan }}<br>
                        <small class="text-muted">{{ $timeAgo }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
        
        <!-- Tombol Back to Dashboard -->
        <a href="{{ route('staff.dashboard') }}" class="btn btn-danger mt-4">Back to Dashboard</a>
    </div>
</div>
@endsection




