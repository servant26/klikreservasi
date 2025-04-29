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
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('content')
<div class="container">
    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
        </div>

        <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Whatsapp</label>
            <input type="number" name="whatsapp" class="form-control" value="{{ old('whatsapp', $user->whatsapp) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Asal</label>
            <input type="text" name="asal" class="form-control" value="{{ old('asal', $user->asal) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Ganti Password (Opsional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        
        <a href="{{ route('user.profile') }}" class="btn btn-danger" style="margin-right: 4px;">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>

        <br><br><br>
        
    </form>
</div>
@endsection
