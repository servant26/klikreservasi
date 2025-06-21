<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dispursip Samarinda</title>
  <link rel="icon" href="{{ asset('dist/img/logorbg.png') }}" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <style>
    .status-accepted {
        border-left: 5px solid #17a2b8; /* Info (teal) */
        padding-left: 25px;
    }

    .status-cancelled {
        border-left: 5px solid #dc3545; /* Danger (red) */
        padding-left: 25px;
    }
    @media (max-width: 767px) {
      .small-box .inner h3 {
        font-size: 2.5rem; /* atau ukuran yang kamu mau, default biasanya sekitar 2rem */
      }

      .small-box .inner p {
        font-size: 1.1rem; /* sesuaikan juga paragrafnya */
      }
    }
    
  </style>
</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ ucfirst(Auth::user()->role) }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="{{ asset('dist/img/staff.png') }}" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <a href="#" class="d-block">Selamat Datang {{ ucfirst(Auth::user()->name) }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
              <a href="/staff/dashboard" class="nav-link 
                  {{ 
                      request()->routeIs('staff.dashboard') || 
                      request()->routeIs('staff.reservasi') || 
                      request()->routeIs('staff.kunjungan') || 
                      request()->routeIs('staff.reschedule') ||
                      request()->routeIs('staff.balasForm')
                      ? 'active' : '' 
                  }}">
                  <i class="nav-icon fa fa-home"></i>
                  <p>Home</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="/staff/profile" class="nav-link {{ Request::is('staff/profile') ? 'active' : '' }}">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/staff/history" class="nav-link {{ Request::is('staff/history') ? 'active' : '' }}">
              <i class="nav-icon fas fa-arrow-circle-right"></i>
              <p>
                History
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link" onclick="confirmLogout(event)">
                  <i class="nav-icon fa fa-power-off"></i>
                  <p>Logout</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('menu')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @yield('content')
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#"></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tambahkan sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('js')
<script>
function confirmStatusChange(url) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Status akan diubah.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, ubah status!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

  $(function () {
    $("#example1").DataTable({
      "responsive": false,    // Nonaktifkan responsive bawaannya
      "scrollX": true,        // Aktifkan scroll horizontal
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 5
    });

    // Autofocus ke search input
    setTimeout(function () {
      $('#example1_filter input').focus();
    }, 500);

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 5
    });
  });

  function confirmLogout(event) {
    event.preventDefault();

    Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Anda akan keluar dari sesi saat ini.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal',
        reverseButtons: true // Tukar posisi tombol
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}

function showSuratModal(suratUrl) {
    Swal.fire({
        title: '📄 Detail Surat',
        text: 'Pilih tindakan:',
        icon: 'info',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'Download Surat', // kanan
        denyButtonText: 'Lihat Surat',       // tengah
        cancelButtonText: 'Kembali',         // kiri
        reverseButtons: true, // biar urutannya sesuai visual: kiri-tengah-kanan
        confirmButtonColor: '#0d6efd', // biru
        denyButtonColor: '#0d6efd',    // biru
        cancelButtonColor: '#dc3545'   // merah
    }).then((result) => {
        if (result.isConfirmed) {
            // Download Surat
            const link = document.createElement('a');
            link.href = suratUrl;
            link.setAttribute('download', '');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else if (result.isDenied) {
            // Lihat Surat
            window.open(suratUrl, '_blank');
        }
        // Cancel (Kembali) tidak perlu dihandle karena cuma nutup modal
    });
}

function normalizeWhatsapp(raw) {
    let wa = raw.replace(/\D/g, '');
    if (wa.startsWith('0')) return '62' + wa.slice(1);
    if (wa.startsWith('8')) return '62' + wa;
    if (!wa.startsWith('62')) return '62' + wa;
    return wa;
}

function handleStatusAction(status, nama, whatsapp, urlUpdate = '', ajuanId = null) {
    let wa = normalizeWhatsapp(whatsapp);
    let linkWA = `https://wa.me/${wa}`;

    if (status == 2) {
        Swal.fire({
            title: 'Batalkan Penerimaan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Batalkan',
            cancelButtonText: 'Kembali',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(linkWA, '_blank');
                setTimeout(() => {
                    window.location.href = urlUpdate;
                }, 500);
            }
        });
        return;
    }

    let btnText = status == 1 ? ['Terima Ajuan', 'Tolak Ajuan'] : ['Terima Reschedule', 'Tolak Reschedule'];

    Swal.fire({
        title: `Pilih opsi yang diinginkan :`,
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: btnText[0],
        denyButtonText: btnText[1],
        cancelButtonText: 'Kembali',
        confirmButtonColor: '#198754',
        denyButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed || result.isDenied) {
            window.open(linkWA, '_blank');

            let action = result.isConfirmed ? 'accept' : 'reject';

            fetch('/staff/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: ajuanId, action: action })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.new_status === 4) {
                        document.getElementById('row-' + ajuanId)?.remove();
                    } else {
                        location.reload();
                    }
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Tidak bisa menghubungi server.', 'error');
            });
        }
    });
}

// Pasang event listener tombol
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-handle-status').forEach(btn => {
        btn.addEventListener('click', () => {
            const status = parseInt(btn.dataset.status);
            const nama = btn.dataset.nama;
            const wa = btn.dataset.wa;
            const id = parseInt(btn.dataset.id);
            const urlUpdate = btn.dataset.url || '';

            handleStatusAction(status, nama, wa, urlUpdate, id);
        });
    });
});


</script>

</body>
</html>

