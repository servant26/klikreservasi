@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Reschedule</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Reschedule</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
<div class="container">
    <form action="{{ route('user.update', $ajuan->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select class="form-control" id="jenis" name="jenis" required>
                <option value="Kunjungan" {{ $ajuan->jenis == 1 ? 'selected' : '' }}>Kunjungan</option>
                <option value="Reservasi" {{ $ajuan->jenis == 2 ? 'selected' : '' }}>Reservasi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $ajuan->tanggal) }}" required>
        </div>

        <div class="form-group">
             <label>Jam</label>
             <!-- <input type="time" name="jam" class="form-control" required value="{{ \Carbon\Carbon::parse($ajuan->jam)->format('H:i') }}"> -->
             <input type="time" name="jam" class="form-control" required value="">
        </div>
            <a class="btn btn-danger" href="{{ route('user.dashboard') }}" role="button">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
