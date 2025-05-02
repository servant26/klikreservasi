@extends('admin.adminmaster')
@section('menu')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data @if($period == 'hari') Hari ini @elseif($period == 'minggu') Minggu ini @elseif($period == 'bulan') Bulan ini @elseif($period == 'semester') Semester ini @elseif($period == 'tahun') Tahun ini @else Semua waktu @endif:</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Dropdown for period selection -->
<form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3">
    <div class="form-group row">
        <label for="period" class="col-form-label col-sm-2">Filter Waktu:</label>
        <div class="col-sm-4">
            <select name="period" id="period" class="form-control" onchange="this.form.submit()">
                <option value="hari" {{ $period == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu" {{ $period == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ $period == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="semester" {{ $period == 'semester' ? 'selected' : '' }}>Semester Ini</option>
                <option value="tahun" {{ $period == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="semuanya" {{ $period == 'semuanya' ? 'selected' : '' }}>Semua Data</option>
            </select>
        </div>
    </div>
</form>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection



@section('content')
  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total ajuan</span>
                <span class="info-box-number">{{ $totalAjuan }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reservasi Aula</span>
                <span class="info-box-number">{{ $reservasi }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-4 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kunjungan Perpustakaan</span>
                <span class="info-box-number">{{ $kunjungan }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row --><br>
        <div class="row">
        </div>
        <div class="row justify-content-center">
<div class="col-lg-11">
  <div class="row">
      <div class="col-md-8">
        <canvas id="barChart"></canvas>
      </div>
      <div class="col-md-4 d-flex justify-content-center align-items-center">
        <canvas id="pieChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-lg-11">
        <h5 class="text-center">Line Chart</h5>
        <canvas id="lineChart"></canvas>
    </div>
</div>


        <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@section('js')
<script>
    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Reservasi', 'Kunjungan'],
            datasets: [{
                data: [{{ $chartData['reservasi'] }}, {{ $chartData['kunjungan'] }}],
                backgroundColor: ['#4CAF50', '#2196F3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Statistik berdasarkan pie chart' }
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['Reservasi', 'Kunjungan'],
        datasets: [{
            label: 'Jumlah',
            data: [{{ $reservasi }}, {{ $kunjungan }}],
            backgroundColor: ['#007bff', '#28a745']
        }]
    },
    options: {
        indexAxis: 'y', // inilah yang bikin horizontal
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Statistik berdasarkan bar chart'
            }
        },
        scales: {
            x: {
                beginAtZero: true
            }
        }
    }
});

    // const barCtx = document.getElementById('barChart').getContext('2d');
    // new Chart(barCtx, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Reservasi', 'Kunjungan'],
    //         datasets: [{
    //             label: 'Jumlah',
    //             data: [{{ $chartData['reservasi'] }}, {{ $chartData['kunjungan'] }}],
    //             backgroundColor: ['#4CAF50', '#2196F3']
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             title: { display: true, text: 'Statistik barchart per "{{ ucfirst($period) }}"' },
    //             legend: { display: false }
    //         },
    //         scales: {
    //             y: { beginAtZero: true }
    //         }
    //     }
    // });

    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($lineChart['labels']) !!},
            datasets: [
                {
                    label: 'Reservasi',
                    data: {!! json_encode($lineChart['reservasi']) !!},
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Kunjungan',
                    data: {!! json_encode($lineChart['kunjungan']) !!},
                    borderColor: '#2196F3',
                    backgroundColor: 'rgba(33, 150, 243, 0.2)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Statistik Tahunan: Reservasi vs Kunjungan' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection