@extends('staff.staffmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Reschedule</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Re Schedule</li>
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
<form method="GET" class="mb-3">
  <div class="form-group">
    <label for="filter">Filter Waktu:</label>
    <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
      <option value="hari" {{ request('filter', 'bulan') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
      <option value="minggu" {{ request('filter', 'bulan') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
      <option value="bulan" {{ request('filter', 'bulan') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
      <option value="semester" {{ request('filter', 'bulan') == 'semester' ? 'selected' : '' }}>Semester Ini</option>
      <option value="tahun" {{ request('filter', 'bulan') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
      <option value="semua" {{ request('filter', 'bulan') == 'semua' ? 'selected' : '' }}>Semua</option>
    </select>
  </div>
</form>


        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style="width: 5%;">No.</th>
              <th style="width: 15%;">Identitas</th>
              <th style="width: 20%;">Jadwal</th>
              <th style="width: 10%;">Jumlah Orang</th>
              <th style="width: 20%;">Asal Instansi</th>
              <th style="width: 20%;">Status</th>
              <th style="width: 10%;">Surat</th>
              <!-- <th style="width: 8%;">Edit</th> -->
            </tr>
            </thead>
            <tbody>
            @foreach($reschedule as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      {{ $a->nama }}<br>
                      <a href="https://wa.me/{{ $a->whatsapp }}" target="_blank">{{ $a->whatsapp }}</a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}<br>{{ substr($a->jam, 0, 5) }}</td>
                    <td>{{ $a->jumlah_orang }} Orang</td>
                    <td>{{ $a->asal }}</td>
                <td class="text-center">
                  <div class="d-grid gap-2">
                      @if($a->status == 2)
                          {{-- Sudah ditanggapi → Bisa dibatalkan --}}
                          <a class="btn btn-primary btn-block" 
                              href="javascript:void(0);" 
                              onclick="confirmStatusChange('{{ route('staff.updateStatus', $a->id) }}')" 
                              role="button">
                              Telah ditanggapi
                          </a>
                      @elseif($a->status == 1 || $a->status == 3)
                          {{-- Belum ditanggapi atau Reschedule → Tautkan ke halaman balas --}}
                          <a class="btn 
                              @if($a->status == 1) btn-danger 
                              @elseif($a->status == 3) btn-warning 
                              @endif btn-block" 
                              href="{{ route('staff.balasForm', $a->id) }}" 
                              role="button">
                              @if($a->status == 1) Menunggu balasan @elseif($a->status == 3) Reschedule @endif
                          </a>
                      @endif
                  </div>
                </td>
                    <td class="text-center">
                    @if($a->surat)
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Detail
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li>
                                    <a class="dropdown-item" href="{{ url('uploads/surat/' . $a->surat) }}" target="_blank">
                                        Lihat Surat
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('uploads/surat/' . $a->surat) }}" download>
                                        Download Surat
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @else
                            <span class="text-muted">Tidak ada surat</span>
                        @endif
                    </td>
                    <!-- <td><a class="btn btn-success btn-block" href="{{ route('staff.edit', $a->id) }}" role="button">Edit</a></td> -->
                </tr>
            @endforeach  
            </tbody>
        </table>
        <a href="{{ route('staff.dashboard') }}" class="btn btn-danger btn-sm mt-4">Back to Dashboard</a>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.row -->
@endsection