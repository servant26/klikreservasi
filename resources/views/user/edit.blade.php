@extends('user.usermaster')

@section('content')
<div class="container">
    <h2>Edit Ajuan</h2>
    <form action="{{ route('user.update', $ajuan->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Tambahkan ini -->
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $ajuan->nama }}" required>
        </div>
        <div class="form-group">
            <label for="asal">Asal</label>
            <input type="text" class="form-control" id="asal" name="asal" value="{{ $ajuan->asal }}" required>
        </div>
        <div class="form-group">
            <label for="whatsapp">Nomor WhatsApp</label>
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $ajuan->whatsapp }}" required>
        </div>
        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select class="form-control" id="jenis" name="jenis" required>
                <option value="1" {{ $ajuan->jenis == 1 ? 'selected' : '' }}>Reservasi</option>
                <option value="2" {{ $ajuan->jenis == 2 ? 'selected' : '' }}>Kunjungan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $ajuan->tanggal }}" required>
        </div>
        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" class="form-control" id="jam" name="jam" value="{{ $ajuan->jam }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
