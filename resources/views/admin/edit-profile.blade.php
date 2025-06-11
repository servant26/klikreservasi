@extends('admin.adminmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('content')
<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-primary" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf

        <!-- Nama -->
        <div class="form-group mb-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control"
                  value="{{ old('name', $admin->name) }}" required autofocus pattern="[A-Za-z\s]+"
                  oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
                  oninput="this.setCustomValidity('')">
        </div>

        <!-- Email -->
        <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                  value="{{ old('email', $admin->email) }}" required
                  oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan alamat email yang valid!')"
                  oninput="this.setCustomValidity('')">
        </div>

        <!-- Password (opsional) -->
        <div class="form-group mb-2">
            <label>Ganti Password (opsional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <!-- Konfirmasi Password -->
        <div class="form-group mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger" style="margin-right: 4px;">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection

