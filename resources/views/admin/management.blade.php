@extends('admin.adminmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Management Staff</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Management Staff</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection


@section('content')
<div class="container mt-4">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.management.store') }}" method="POST" class="mb-4">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Nama" required autofocus>
        </div>
        <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Tambah Staff</button>
        </div>
    </div>
</form>


    <!-- Tabel Staff -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staffs as $staff)
            <tr>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->created_at->format('d-m-Y') }}</td>
                <td>
                    <form action="{{ route('admin.management.delete', $staff->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus staff ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
