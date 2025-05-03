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
    <p>Menampilkan data user yang melakukan perubahan jadwal :</p>
<form method="GET" action="{{ route('staff.kunjungan') }}" class="mb-3">
    <select name="filter" onchange="this.form.submit()" class="form-select" style="width: 250px;">
        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Data</option>
        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
        <option value="this_week" {{ request('filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
        <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
        <option value="this_semester" {{ request('filter') == 'this_semester' ? 'selected' : '' }}>Semester Ini</option>
        <option value="this_year" {{ request('filter') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
    </select>
</form>

        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style="width: 2%;">No.</th>
              <th style="width: 10%;">Identitas</th>
              <th style="width: 15%;">Jadwal</th>
              <th style="width: 10%;">Jumlah Orang</th>
              <th style="width: 10%;">Asal Instansi</th>
              <th style="width: 10%;">Jenis</th>
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
                    <td>
                        @if($a->jenis == 1)
                            Reservasi Aula
                        @elseif($a->jenis == 2)
                            Kunjungan Perpustakaan
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
                            <a class="btn btn-primary btn-block" 
                                href="javascript:void(0);" 
                                onclick="confirmStatusChange('{{ route('staff.updateStatus', $a->id) }}')" 
                                role="button">
                                Sudah ditanggapi
                            </a>
                        @endif
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