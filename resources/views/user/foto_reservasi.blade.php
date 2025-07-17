@extends('user.usermaster')

@section('menu')
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Foto Reservasi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></li>
          <li class="breadcrumb-item active">Foto Reservasi Aula</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="container mb-5">

  {{-- Carousel --}}
  <div id="carouselReservasi" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi1.jpg') }}" onclick="showPreview('{{ asset('dist/img/reservasi1.jpg') }}')" alt="SOP 1">
        </div>
      </div>
      <div class="carousel-item">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi2.jpg') }}" onclick="showPreview('{{ asset('dist/img/reservasi2.jpg') }}')" alt="SOP 2">
        </div>
      </div>
      <div class="carousel-item">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi3.jpg') }}" onclick="showPreview('{{ asset('dist/img/reservasi3.jpg') }}')" alt="SOP 3">
        </div>
      </div>
      <div class="carousel-item">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi4.jpg') }}" onclick="showPreview('{{ asset('dist/img/reservasi4.jpg') }}')" alt="SOP 4">
        </div>
      </div>
      <div class="carousel-item">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi5.jpeg') }}" onclick="showPreview('{{ asset('dist/img/reservasi5.jpeg') }}')" alt="SOP 5">
        </div>
      </div>
      <div class="carousel-item">
        <div class="overlay-wrapper">
          <img src="{{ asset('dist/img/reservasi6.jpg') }}" onclick="showPreview('{{ asset('dist/img/reservasi6.jpg') }}')" alt="SOP 6">
        </div>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselReservasi" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselReservasi" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
    <a href="{{ route('user.dashboard') }}" class="btn btn-danger">Back</a>
    <a href="{{ route('user.reservasi') }}" class="btn btn-primary">Next</a>

  {{-- Modal Preview --}}
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body p-0">
          <img id="modalImage" src="" class="img-fluid w-100 rounded shadow" alt="Preview">
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Custom Styles --}}
<style>
    .overlay-wrapper {
    position: relative;
    max-height: 420px; /* sebelumnya 350px */
    overflow: hidden;
    border-radius: 0.5rem;
    }

    .overlay-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(55%);
    cursor: pointer;
    transition: filter 0.3s;
    }

    .overlay-wrapper img:hover {
    filter: brightness(65%);
    }
</style>

{{-- Script --}}
<script>
  function showPreview(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
  }
</script>
@endsection
