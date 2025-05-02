@extends('admin.adminmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data @if($period == 'hari') Hari ini @elseif($period == 'minggu') Minggu ini @elseif($period == 'bulan') Bulan ini @elseif($period == 'semester') Semester ini @elseif($period == 'tahun') Tahun ini @else Semua waktu @endif:</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Dropdown for period selection -->
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="form-group">
                <select name="period" class="form-control" onchange="this.form.submit()">
                    <option value="hari" {{ $period == 'hari' ? 'selected' : '' }}>Hari ini</option>
                    <option value="minggu" {{ $period == 'minggu' ? 'selected' : '' }}>Minggu ini</option>
                    <option value="bulan" {{ $period == 'bulan' ? 'selected' : '' }}>Bulan ini</option>
                    <option value="semester" {{ $period == 'semester' ? 'selected' : '' }}>Semester ini</option>
                    <option value="tahun" {{ $period == 'tahun' ? 'selected' : '' }}>Tahun ini</option>
                    <option value="semuanya" {{ $period == 'semuanya' ? 'selected' : '' }}>Semua waktu</option>
                </select>
            </div>
        </form>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection



@section('content')
  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total ajuan</span>
                <span class="info-box-number">{{ $totalAjuan }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reservasi Aula</span>
                <span class="info-box-number">{{ $reservasi }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kunjungan Perpustakaan</span>
                <span class="info-box-number">{{ $kunjungan }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row --><br>
        <div class="row">
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
