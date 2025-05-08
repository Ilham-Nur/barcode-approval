@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        #projectChart
        {
            height: 40%;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl-12 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Project Pending</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-warning">
                                                <i class="align-middle" data-feather="clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">7</h1>
                                    <div class="mb-0">
                                        <span class="text-muted">Menunggu approval</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Karyawan</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="user"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">124</h1>
                                    <div class="mb-0">
                                        <span class="text-muted">Total aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.w-100 -->
            </div> <!-- /.col -->
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Project Received This Year</h5>
                        <canvas id="projectChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('projectChart').getContext('2d');

            var projectChart = new Chart(ctx, {
                type: 'bar', // Ganti tipe chart menjadi 'bar'
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ], // Bulan
                    datasets: [{
                        label: 'Projects Received',
                        data: [5, 8, 10, 7, 12, 14, 11, 15, 13, 9, 6, 10], // Data dummy
                        backgroundColor: 'rgba(23, 75, 153, 0.7)', // Warna balok
                        borderColor: 'rgba(23, 75, 153, 1)', // Border balok
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(23, 75, 153, 1)', // Warna saat hover
                        hoverBorderColor: 'rgba(23, 75, 153, 1)',
                        barPercentage: 0.5, // Ukuran lebar bar (0-1)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 4, // Set aspect ratio untuk chart
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        }
                    }
                }
            });
        });
    </script>
@endsection
