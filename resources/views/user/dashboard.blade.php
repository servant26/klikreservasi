@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<!-- Small boxes (Stat box) -->
@foreach($ajuan as $a)
    @if($a->user_id == auth()->id()) <!-- Filter by user_id -->
    <div class="row">
        <div class="col-lg-12 col-12">
            <!-- small box -->
            <div class="small-box 
                {{ $a->status == 1 ? 'bg-danger' : ($a->status == 2 ? 'bg-primary' : 'bg-warning') }} 
                <text-dark p-2">
                <div class="inner text-left">
                    <h4>Status Ajuan Reservasi/Kunjungan</h4>
                    <p>
                        @if($a->status == 1)
                            Ajuan anda sedang diproses
                        @elseif($a->status == 2)
                            Ajuan anda selesai diproses, silahkan datang pada waktu yang telah ditentukan
                        @elseif($a->status == 3)
                            Reschedule anda sedang diproses
                        @endif
                    </p>
                    <!-- Add buttons for details and edit -->
                    <a href="{{ route('user.edit', $a->id) }}" 
                      class="btn {{ in_array($a->status, [1, 2]) ? 'btn-outline-light' : ($a->status == 3 ? 'btn-outline-dark' : 'btn-outline-secondary') }} btn-sm">
                      Reschedule
                    </a>
                </div>
                <div class="icon">
                    <i class="fas 
                        {{ $a->status == 1 ? 'fa-hourglass-half' : ($a->status == 2 ? 'fa-check-circle' : 'fa-sync-alt') }}">
                    </i>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<div class="card">
    <div class="card-header">
      <a class="btn btn-primary" href="{{ route('user.tambah') }}" role="button">Ajukan Kunjungan/Reservasi</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                </tr>
            </thead>
            <tbody>
            @foreach($ajuan as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}<br>{{ substr($a->jam, 0, 5) }}</td>
                    <td>
                        @if($a->jenis == 1)
                            Kunjungan Perpustakaan
                        @elseif($a->jenis == 2)
                            Reservasi Aula
                        @endif
                    </td>
                </tr>
            @endforeach  
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<div class="card bg-gradient-primary" style="display: none;">
  <div class="card-header border-0">
    <h3 class="card-title">
      <i class="fas fa-map-marker-alt mr-1"></i>
      Visitors
    </h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
        <i class="far fa-calendar-alt"></i>
      </button>
      <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <div id="world-map" style="height: 250px; width: 100%;"></div>
  </div>
  <div class="card-footer bg-transparent">
    <div class="row">
      <div class="col-4 text-center">
        <div id="sparkline-1"></div>
        <div class="text-white">Visitors</div>
      </div>
      <div class="col-4 text-center">
        <div id="sparkline-2"></div>
        <div class="text-white">Online</div>
      </div>
      <div class="col-4 text-center">
        <div id="sparkline-3"></div>
        <div class="text-white">Sales</div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
@endsection