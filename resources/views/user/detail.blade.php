@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Ajuan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Detail Ajuan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $ajuan->nama }}</p>
                <p><strong>Asal:</strong> {{ $ajuan->asal }}</p>
                <p><strong>Nomor WA:</strong> {{ $ajuan->whatsapp }}</p>
                <p><strong>Jenis:</strong> {{ $ajuan->jenis == 1 ? 'Kunjungan Perpustakaan' : 'Reservasi Aula' }}</p>
                <p><strong>Tanggal:</strong> {{ $ajuan->tanggal }}</p>
                <p><strong>Jam:</strong> {{ $ajuan->jam }}</p>
                <p><strong>Status:</strong> 
                    @if($ajuan->status == 1)
                        Dalam Proses
                    @elseif($ajuan->status == 2)
                        Selesai
                    @else
                        Belum Diproses
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
