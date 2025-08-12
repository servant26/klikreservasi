@extends('staff.staffmaster')
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
      <form action="{{ route('staff.profile.update') }}" method="POST" id="profileForm">
          @csrf
          <div class="form-group mb-2">
              <label>Nama</label>
              <input type="text" name="name" class="form-control" placeholder="Masukkan nama"
                  value="{{ old('name', $staff->name) }}"
                  required pattern="[A-Za-z\s]+"
                  oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
                  oninput="this.setCustomValidity('')" autofocus>
          </div>

          <div class="form-group mb-2">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                  value="{{ old('email', $staff->email) }}"
                  required
                  oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan alamat email yang valid!')"
                  oninput="this.setCustomValidity('')">
          </div>

          <div class="form-group mb-2">
              <label>Ganti Password (opsional)</label>
              <input type="password" name="password" id="password" class="form-control"
                    minlength="8" placeholder="Password minimal 8 karakter"
                    oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Password minimal 8 karakter!' : 'Password minimal 8 karakter!')"
                    oninput="this.setCustomValidity('')">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password.</small>
          </div>

        <div class="form-group mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan konfirmasi password"
                oninvalid="this.setCustomValidity('Konfirmasi password wajib diisi')"
                oninput="this.setCustomValidity('')">
        </div>

          <a href="{{ route('staff.dashboard') }}" class="btn btn-danger" style="margin-right: 4px;">Back</a>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
  </div>
@endsection

