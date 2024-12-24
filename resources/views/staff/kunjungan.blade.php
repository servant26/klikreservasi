@extends('staff.staffmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kunjungan Terbaru</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Kunjungan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="card">
    <!-- /.card-header -->
    <div class="card-body">
    <p>Menampilkan data kunjungan terbaru :</p>
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Nama</th>
                    <th>Asal</th>
                    <th>Kontak</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th style="width: 15%;">Status</th>
                    <th>Edit Data</th>
                </tr>
            </thead>
            <tbody>
            @foreach($kunjungan as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->asal }}</td>
                    <td>{{ $a->whatsapp }}</td>
                    <td>
                        @if($a->jenis == 1)
                            Kunjungan
                        @elseif($a->jenis == 2)
                            Reservasi
                        @endif
                    </td>
                    <td>{{ $a->tanggal }}</td>
                    <td>{{ $a->jam }}</td>
                    <td class="text-center">
                      @if($a->status == 1)
                          <a class="btn btn-danger btn-block" href="" role="button">Belum ditanggapi</a>
                      @elseif($a->status == 2)
                          <a class="btn btn-primary btn-block" href="" role="button">Sudah ditanggapi</a>
                      @elseif($a->status == 3)
                          <a class="btn btn-warning btn-block" href="" role="button">Re-schedule</a>
                      @endif
                    </td>
                    <td><a class="btn btn-success btn-block" href="" role="button">Edit Data</a></td>
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