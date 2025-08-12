@extends('user.usermaster')
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
  <div class="container">
  <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST" autocomplete="off">
      @csrf

      <!-- Nama -->
      <div class="form-group mb-2">
          <label>Nama</label>
          <input type="text" name="name" class="form-control"
              value="{{ old('name', $user->name) }}"
              required pattern="[A-Za-z\s]+"
              oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
              oninput="this.setCustomValidity('')">
          @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Email -->
      <div class="form-group mb-2">
          <label>Email</label>
          <input type="email" name="email" class="form-control"
              value="{{ old('email', $user->email) }}"
              required
              oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan format email yang benar!')"
              oninput="this.setCustomValidity('')">
          @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Whatsapp (kembalikan ke number sesuai request) -->
      <div class="form-group mb-2">
          <label>Whatsapp</label>
          <input type="number" name="whatsapp" class="form-control"
              value="{{ old('whatsapp', $user->whatsapp) }}"
              required
              oninvalid="this.setCustomValidity('Nomor WhatsApp wajib diisi')"
              oninput="this.setCustomValidity('')">
          @error('whatsapp') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Asal -->
      <div class="form-group mb-3">
          <label>Asal</label>
          <input type="text" name="asal" class="form-control"
              value="{{ old('asal', $user->asal) }}"
              required
              oninvalid="this.setCustomValidity('Form ini wajib diisi!')"
              oninput="this.setCustomValidity('')">
          @error('asal') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Password (opsional, minlength 8) -->
      <div class="form-group mb-3">
          <label>Ganti Password (Opsional)</label>
          <input type="password" name="password" id="password" class="form-control"
              minlength="8"
              oninvalid="this.setCustomValidity(this.validity.valueMissing ? '' : 'Password minimal 8 karakter!')"
              oninput="this.setCustomValidity('')">
          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
          <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password.</small>
      </div>

      <!-- Konfirmasi Password (will become required if password is filled) -->
      <div class="form-group mb-3">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
              oninvalid="this.setCustomValidity('Konfirmasi password wajib diisi')"
              oninput="this.setCustomValidity('')">
          <small id="confirmHint" class="text-danger d-none">Konfirmasi password tidak sama</small>
      </div>

      <a href="{{ route('user.dashboard') }}" class="btn btn-danger" style="margin-right: 4px;">Back</a>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
@endsection
