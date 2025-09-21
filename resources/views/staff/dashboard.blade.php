@extends('staff.staffmaster')
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
              <li class="breadcrumb-item"><a href="#">Staff</a></li>
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
  <div class="row">
    <div class="col-lg-4 col-md-4 col-12">
      <!-- Bounce Rate -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h5>Reservasi Aula</h5>
          <h5>{{ $reservasi }}</h5>
        </div>
        <div class="icon">
          <i class="fas fa-building"></i>
        </div>
        <a href="{{ route('staff.reservasi') }}" class="small-box-footer">More</a>
      </div>
    </div>
    <!-- Column 1: New Orders and Bounce Rate -->
    <div class="col-lg-4 col-md-4 col-12">
      <!-- Bounce Rate -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h5>Kunjungan Perpustakaan</h5>
          <h5>{{ $kunjungan }}</h5>
        </div>
        <div class="icon">
          <i class="fas fa-book"></i>
        </div>
        <a href="{{ route('staff.kunjungan') }}" class="small-box-footer">More</a>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-12">
      <div class="small-box bg-warning mb-3">
        <div class="inner">
          <h5>Reschedule</h5>
          <h5>{{ $reschedule }}</h5>
        </div>
        <div class="icon">
          <i class="fas fa-sync"></i>
        </div>
        <a href="{{ route('staff.reschedule') }}" class="small-box-footer">More</a>
      </div>
    </div>
  </div>

  <!-- /.row -->
  <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <form method="GET" class="mb-3">
          <div class="form-group">
            <label for="filter">Filter Ajuan:</label>
            <select name="filter" id="filter" class="form-control w-100" onchange="this.form.submit()">
                <option value="menunggu" {{ request('filter', 'bulan') == 'menunggu' ? 'selected' : '' }}>Menunggu Respon</option>
                <option value="ditanggapi" {{ request('filter', 'bulan') == 'ditanggapi' ? 'selected' : '' }}>Telah Ditanggapi</option>
                <option value="hari" {{ request('filter', 'bulan') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu" {{ request('filter', 'bulan') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ request('filter', 'bulan') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="semester" {{ request('filter', 'bulan') == 'semester' ? 'selected' : '' }}>Semester Ini</option>
                <option value="tahun" {{ request('filter', 'bulan') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="semua" {{ request('filter', 'bulan') == 'semua' ? 'selected' : '' }}>Semua</option>
            </select>
          </div>
        </form>

        <div class="table-responsive-wrapper" style="overflow-x: auto;">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th style="min-width: 1px;">No.</th>
                <th style="min-width: 10px;">Identitas</th>
                <th style="min-width: 150px;">Jadwal</th>
                <th style="min-width: 80px;">Asal Instansi</th>
                <th style="min-width: 30px;">Jenis</th>
                <th style="min-width: 150px;">Status</th>
                <th style="min-width: 50px;">Surat</th>
                <!-- <th style="width: 8%;">Edit</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach($ajuan as $a)
                <tr id="row-{{ $a->id }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    {{ $a->nama }}<br>
                    <a href="https://wa.me/{{ $a->whatsapp }}" target="_blank">{{ $a->whatsapp }}</a>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}<br>{{ substr($a->jam, 0, 5) }}</td>
                  <td>{{ $a->asal }}</td>
                  <td>
                    @if($a->jenis == 1)
                      Reservasi Aula
                    @elseif($a->jenis == 2)
                      Kunjungan Perpustakaan
                    @endif
                  </td>
                  <!-- kolom lainnya -->
                  <td class="text-center">
                    <div class="d-grid gap-2">
                      @if($a->status == 2)
                      <a class="btn btn-primary btn-block" href="javascript:void(0);">Telah Ditanggapi</a>
                        <!-- <a class="btn btn-primary btn-block"
                          href="javascript:void(0);"
                          onclick="handleStatusAction({{ $a->status }}, '{{ $a->nama }}', '{{ $a->whatsapp }}', '{{ route('staff.updateStatus', $a->id) }}')">
                          Telah Ditanggapi
                        </a> -->
                      @elseif($a->status == 1 || $a->status == 3)
                        <a class="btn
                          @if($a->status == 1) btn-danger
                          @elseif($a->status == 3) btn-warning
                          @endif btn-block"
                            href="javascript:void(0);"
                            onclick="handleStatusAction({{ $a->status }}, '{{ $a->nama }}', '{{ $a->whatsapp }}', '', {{ $a->id }})">
                          @if($a->status == 1) Menunggu Respon
                            @elseif($a->status == 3) Reschedule
                            @endif
                          </a>
                      @endif
                    </div>
                  </td>
                  <td class="text-center">
                    @if($a->surat)
                      <button onclick="showSuratModal('{{ url('uploads/surat/' . $a->surat) }}')" class="btn btn-secondary w-100">
                        Detail
                      </button>
                    @else
                      <span class="text-muted">Tidak ada surat</span>
                    @endif
                  </td>
                @endforeach  
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card-body -->
  </div>
@endsection