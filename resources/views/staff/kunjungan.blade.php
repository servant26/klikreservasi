@extends('staff.staffmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kunjungan Perpustakaan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Kunjungan Perpustakaan</li>
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
    <p>Menampilkan data kunjungan perpustakaan :</p>
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 10%;">Kontak</th>
                    <th style="width: 15%;">Jumlah Orang</th>
                    <th style="width: 15%;">Asal Instansi</th>
                    <th style="width: 15%;">Jenis</th>
                    <th style="width: 12%;">Status</th>
                    <!-- <th style="width: 8%;">Edit</th> -->
                </tr>
            </thead>
            <tbody>
            @foreach($kunjungan as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}<br>{{ substr($a->jam, 0, 5) }}</td>
                    <td>{{ $a->whatsapp }}</td>
                    <td>{{ $a->jumlah_orang }}</td>
                    <td>{{ $a->asal }}</td>
                    <td>
                        @if($a->jenis == 1)
                            Kunjungan Perpustakaan
                        @elseif($a->jenis == 2)
                            Reservasi Aula
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a->status == 1 || $a->status == 3)
                            <a class="btn 
                                @if($a->status == 1) btn-danger @elseif($a->status == 3) btn-warning @endif 
                                btn-block" 
                                href="javascript:void(0);" 
                                onclick="confirmStatusChange('{{ route('staff.updateStatus', $a->id) }}')" 
                                role="button">
                                @if($a->status == 1) Belum ditanggapi @elseif($a->status == 3) Reschedule @endif
                            </a>
                        @elseif($a->status == 2)
                            <a class="btn btn-primary btn-block" href="javascript:void(0);" role="button">Sudah ditanggapi</a>
                        @endif
                    </td>
                    <!-- <td><a class="btn btn-success btn-block" href="{{ route('staff.edit', $a->id) }}" role="button">Edit</a></td> -->
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