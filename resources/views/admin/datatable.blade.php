@extends('admin.adminmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Datatable</h1>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Datatable</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                  <th style="width: 2%;">No.</th>
                  <th style="width: 10%;">Identitas</th>
                  <th style="width: 15%;">Jadwal</th>
                  <th style="width: 10%;">Jumlah Orang</th>
                  <th style="width: 10%;">Asal Instansi</th>
                  <th style="width: 10%;">Jenis</th>
                  <th style="width: 10%;">Surat</th>
                    <!-- <th style="width: 8%;">Edit</th> -->
                </tr>
            </thead>
            <tbody>
            @foreach($ajuan as $a)
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
            @endforeach  
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection