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
<div class="container mt-3">

    @if (session('success'))
        <div class="alert alert-primary">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-2">
            @foreach ($errors->all() as $error)
                <div class="bg-danger text-white px-3 py-2 rounded mb-3">
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    {{-- Form Tambah Staff --}}
    <form action="{{ route('admin.management.store') }}" method="POST" class="mb-4" autocomplete="off">
        @csrf
        <div class="row g-3">
            <!-- Nama -->
            <div class="col-12 col-sm-6 col-md-3 mb-1 mb-md-0">
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama"
                    value="{{ old('name') }}" required autofocus
                    pattern="[A-Za-z\s]+"
                    oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
                    oninput="this.setCustomValidity('')" autocomplete="off">
            </div>

            <!-- Email -->
            <div class="col-12 col-sm-6 col-md-3 mb-1 mb-md-0">
                <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                    value="{{ old('email') }}" required
                    oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan alamat email yang valid!')"
                    oninput="this.setCustomValidity('')" autocomplete="off">
            </div>

            <!-- Password -->
            <div class="col-12 col-sm-6 col-md-3 mb-1 mb-md-0">
                <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                    required minlength="8"
                    oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Password minimal 8 karakter!')"
                    oninput="this.setCustomValidity('')" autocomplete="new-password">
            </div>
            <br><br>
            <!-- Tombol -->
            <div class="col-12 col-sm-6 col-md-3 d-grid">
                <button type="submit" class="btn btn-primary w-100">Tambah Staff</button>
            </div>
        </div>
    </form>

    <!-- Tabel Staff (scrollable di mobile) -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
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
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="confirmDelete({{ $staff->id }})">Hapus</button>
                        <form id="delete-form-{{ $staff->id }}" action="{{ route('admin.management.delete', $staff->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data staff akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Warna tombol konfirmasi
            cancelButtonColor: '#6c757d', // Warna tombol batal
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true // Ini akan menukar posisi tombol
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection