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
            <div id="aktivitasList">
                <!-- Optional: Tombol pencarian -->
                <input class="search form-control mb-3" placeholder="Cari aktivitas..."/>

                <ul class="list-group list">
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
                            $borderClass = '';

                            if (in_array($statusLama, [1, 3]) && $statusBaru == 2) {
                                $keterangan = "Anda menerima ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                                $borderClass = 'status-accepted';
                            } elseif ($statusLama == 2 && $statusBaru == 1) {
                                $keterangan = "Anda membatalkan ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                                $borderClass = 'status-cancelled';
                            } elseif ($statusBaru == 4) {
                                $keterangan = "Anda menolak ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                                $borderClass = 'status-cancelled';
                            } else {
                                $keterangan = "Anda mengubah status ajuan dari {$instansi} untuk {$jenis} pada hari {$tanggal} pukul {$jam}";
                                $borderClass = 'status-changed';
                            }
                        @endphp

                        <li class="list-group-item {{ $borderClass }}">
                            <div>
                                <span class="keterangan">{{ $keterangan }}</span><br>

                                @if($statusBaru == 4)
                                    <form action="{{ route('staff.restore', $item->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Pulihkan</button>
                                    </form>
                                @endif

                                <small class="text-muted waktu d-block mt-2">{{ $timeAgo }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- List.js Pagination -->
                <ul class="pagination mt-3 d-flex justify-content-center"></ul>
            </div>
        @endif

        <a href="{{ route('staff.dashboard') }}" class="btn btn-danger mt-3">Back to Dashboard</a>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
    var options = {
        valueNames: ['keterangan', 'waktu'],
        page: 5,
        pagination: {
            innerWindow: 1,
            left: 1,
            right: 1,
            paginationClass: "pagination"
        }
    };
    var aktivitasList = new List('aktivitasList', options);
</script>
@endsection
