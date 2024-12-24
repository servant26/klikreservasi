@extends('staff.staffmaster')
@section('content')
<div class="container">
    <div class="mx-1">
        <form action="#" method="POST">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama anda" autofocus>
            </div>
            <div class="form-group">
                <label>Asal</label>
                <input type="text" name="asal" class="form-control" required placeholder="Misal, dari TK... dari Universitas... dsb...">
            </div>
            <div class="form-group">
                <label>Nomor Whatsapp</label>
                <input type="tel" name="nomor_wa" class="form-control" required placeholder="Masukkan nomor yang bisa dihubungi">
            </div>
            <div class="form-group">
                <label>Jenis Ajuan</label>
                <select name="jenis" class="form-control" required>
                    <option value="" disabled selected>Pilih Jenis</option>
                    <option value="Kunjungan">Kunjungan Perpustakaan</option>
                    <option value="Reservasi">Reservasi Aula</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required placeholder="Pilih tanggal">
            </div>
            <div class="form-group">
                <label>Jam</label>
                <input type="time" name="jam" class="form-control" required placeholder="Pilih jam">
            </div>
            <a class="btn btn-danger" href="{{ route('staff.dashboard') }}" role="button">Kembali</a>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        <br><br>
    </div>
</div>
@endsection