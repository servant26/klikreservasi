@extends('admin.adminmaster')

@section('menu')
<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">
          Dashboard
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Admin</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div><br>
    <!-- Dropdown untuk memilih periode waktu -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3">
        <div class="form-group">
        <label for="filter">Filter Waktu:</label>
            <select name="period" id="period" class="form-control w-100" onchange="this.form.submit()">
                <option value="minggu" {{ $period == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ $period == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="semester" {{ $period == 'semester' ? 'selected' : '' }}>Semester Ini</option>
                <option value="tahun" {{ $period == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="semuanya" {{ $period == 'semuanya' ? 'selected' : '' }}>Semua Data</option>
            </select>
        </div>
    </form>
  </div>
</div>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">

    <!-- Info Boxes -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-4 mb-0">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="far fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Ajuan</span>
            <span class="info-box-number">{{ $totalAjuan }}</span>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-4 mb-0">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fas fa-building"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Reservasi Aula</span>
            <span class="info-box-number">{{ $reservasi }}</span>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-4 mb-0">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Kunjungan Perpustakaan</span>
            <span class="info-box-number">{{ $kunjungan }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="row justify-content-center">
      <div class="col-12 col-lg-11">
        <div class="row">

          <!-- Bar Chart -->
          <div class="col-12 col-md-8 mb-4">
            <div class="w-100">
              <canvas id="barChart" style="max-width: 100%; height: auto;"></canvas>
            </div>
            <div class="d-flex justify-content-center mt-2">
              <button onclick="downloadChart('barChart', 'barchart.png')" class="btn btn-sm btn-primary">Download Bar Chart</button>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-12 col-md-4 d-flex flex-column justify-content-center align-items-center mb-4">
            <div class="w-100" style="max-width: 300px;">
              <canvas id="pieChart" style="max-width: 100%; height: auto;"></canvas>
            </div>
            <div class="d-flex justify-content-center mt-2">
              <button onclick="downloadChart('pieChart', 'piechart.png')" class="btn btn-sm btn-primary">Download Pie Chart</button>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Line Chart -->
    <div class="row justify-content-center mt-3">
      <div class="col-12 col-lg-11">
        <div class="w-100">
          <canvas id="lineChart" style="max-width: 100%; height: auto;"></canvas>
        </div>
        <div class="d-flex justify-content-center mt-2 mb-5">
          <button onclick="downloadChart('lineChart', 'linechart.png')" class="btn btn-sm btn-primary">
            Download Line Chart
          </button>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection


@section('js')
  <script>
    // Hitung total untuk pie chart
    const reservasi = {{ $chartData['reservasi'] }};
    const kunjungan = {{ $chartData['kunjungan'] }};
    const totalPie = reservasi + kunjungan;

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Reservasi', 'Kunjungan'],
        datasets: [{
          data: [reservasi, kunjungan],
          backgroundColor: ['#c82333', '#28a745']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: { display: true, text: 'Statistik berdasarkan Pie Chart' },
          datalabels: {
            color: '#fff',
            formatter: (value) => {
              const percentage = ((value / totalPie) * 100).toFixed(0);
              return `${percentage}% (${value} Reservasi)`;
            }
          }
        }
      },
      plugins: [ChartDataLabels]
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: [''],  // label kosong karena data horizontal cuma 1 bar per dataset
        datasets: [
          {
            label: 'Reservasi',
            data: [reservasi],  // 1 data di bar chart
            backgroundColor: '#c82333',
            minBarLength: 30
          },
          {
            label: 'Kunjungan',
            data: [kunjungan],
            backgroundColor: '#28a745',
            minBarLength: 30
          }
        ]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: { display: true }, // aktifkan legend supaya bisa klik toggle
          title: {
            display: true,
            text: 'Statistik berdasarkan Bar Chart'
          },
          datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: { weight: 'bold' },
            formatter: (value, context) => {
              return `${value} ${context.dataset.label}`;
            }
          }
        },
        scales: {
          x: { beginAtZero: true },
          y: { ticks: { display: false } }  // sembunyikan label y karena cuma 1 bar
        }
      },
      plugins: [ChartDataLabels]
    });

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
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.2)',
            tension: 0.4
          },
          {
            label: 'Kunjungan',
            data: {!! json_encode($lineChart['kunjungan']) !!},
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Statistik berdasarkan Line Chart'  // title statis, gak ngikut filter waktu
          }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Download Chart Function
    function downloadChart(chartId, filename) {
      const canvas = document.getElementById(chartId);
      const link = document.createElement('a');
      link.href = canvas.toDataURL('image/png', 1.0);
      link.download = filename;
      link.click();
    }
  </script>
@endsection
