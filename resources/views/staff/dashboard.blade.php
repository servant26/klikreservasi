@extends('staff.staffmaster')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <!-- Column 1: New Orders and Bounce Rate -->
  <div class="col-lg-4 col-6">
    <!-- New Orders -->
    <div class="small-box bg-info mb-3">
      <div class="inner">
        <h3>150</h3>
        <p>Total Kunjungan/Reservasi Bulan Ini</p>
      </div>
      <div class="icon">
        <i class="fas fa-book"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <!-- New Orders -->
    <div class="small-box bg-warning mb-3">
      <div class="inner">
        <h3>0</h3>
        <p>Re-Schedule</p>
      </div>
      <div class="icon">
        <i class="fa fa-refresh"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-4 col-6">
    <!-- Bounce Rate -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>0</h3>
        <p>Ajuan Kunjungan Terbaru</p>
      </div>
      <div class="icon">
        <i class="fas fa-building"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <!-- Bounce Rate -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>0</h3>
        <p>Ajuan Reservasi Terbaru</p>
      </div>
      <div class="icon">
        <i class="fas fa-building"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- Column 2: Calendar -->
  <div class="col-lg-4 col-12">
    <div class="card bg-gradient-success">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="far fa-calendar-alt"></i>
          Calendar
        </h3>
        <div class="card-tools">
          <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
              <i class="fas fa-bars"></i>
            </button>
            <div class="dropdown-menu" role="menu">
              <a href="#" class="dropdown-item">Add new event</a>
              <a href="#" class="dropdown-item">Clear events</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">View calendar</a>
            </div>
          </div>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body pt-0">
        <div id="calendar" style="width: 100%"></div>
      </div>
    </div>
  </div> 
</div>
<div class="card">
    <div class="card-header">
      <a class="btn btn-primary" href="{{ route('staff.tambah') }}" role="button">Tambah Data</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Internet Explorer 4.0</td>
                    <td>Win 95+</td>
                    <td>4</td>
                    <td>Reservasi</td>
                    <td>25 Desember 2024</td>
                    <td>08:00</td>
                    <td><a class="btn btn-primary" href="" role="button">Sudah direspon</a></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Internet Explorer 5.0</td>
                    <td>Win 95+</td>
                    <td>5</td>
                    <td>Reservasi</td>
                    <td>25 Desember 2024</td>
                    <td>11:00</td>
                    <td><a class="btn btn-primary" href="" role="button">Sudah direspon</a></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Konqureror 3.5</td>
                    <td>KDE 3.5</td>
                    <td>3.5</td>
                    <td>Kunjungan</td>
                    <td>26 Desember 2024</td>
                    <td>10:00</td>
                    <td><a class="btn btn-danger" href="" role="button">Belum direspon</a></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Internet Explorer 4.5</td>
                    <td>Mac OS 8-9</td>
                    <td>-</td>
                    <td>Reservasi</td>
                    <td>27 Desember 2024</td>
                    <td>08:00</td>
                    <td><a class="btn btn-warning" href="" role="button">Re-Schedule</a></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Internet Explorer 5.1</td>
                    <td>Mac OS 7.6-9</td>
                    <td>1</td>
                    <td>Kunjungan</td>
                    <td>29 Desember 2024</td>
                    <td>09:00</td>
                    <td><a class="btn btn-danger" href="" role="button">Belum direspon</a></td>
                </tr>
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