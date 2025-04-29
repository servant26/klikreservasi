@extends('user.usermaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">My Profile</h1>
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
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            
            <div class="mb-3">
                <label class="form-label text-muted">Nama</label>
                <div class="fs-5">{{ $user->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Email</label>
                <div class="fs-5">{{ $user->email }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">WhatsApp</label>
                <div class="fs-5">{{ $user->whatsapp ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Asal</label>
                <div class="fs-5">{{ $user->asal ?? '-' }}</div>
            </div>

        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-danger" style="margin-right: 10px;">
                Back
            </a>
            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                Edit Profile
            </a>
        </div>

        </div>
    </div>
</div>
@endsection
