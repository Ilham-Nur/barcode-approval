<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .detail-card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h4 i {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .detail-item {
            margin-bottom: 1.2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-item strong {
            color: #555;
            display: block;
            margin-bottom: 0.3rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-item p {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-approved {
            background-color: #e6f7ee;
            color: #28a745;
        }

        .status-pending {
            background-color: #fff8e6;
            color: #ffc107;
        }

        .status-rejected {
            background-color: #fee;
            color: #dc3545;
        }

        .status-default {
            background-color: #e9f5ff;
            color: #2575fc;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-header {
                padding: 1rem;
            }

            .card-header h4 {
                font-size: 1.25rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .detail-item {
                margin-bottom: 1rem;
                padding-bottom: 0.8rem;
            }

            .detail-item strong {
                font-size: 0.8rem;
            }

            .detail-item p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card detail-card">
                    <div class="card-header">
                        <h4>
                            <span><i class="fas fa-project-diagram me-2"></i> Project Details</span>
                            <i class="fas fa-ship"></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="detail-item">
                            <strong>Perusahaan</strong>
                            <p>{{ $project->nama_perusahaan }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Nama Kapal</strong>
                            <p>{{ $project->nama_kapal }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Lokasi</strong>
                            <p>{{ $project->lokasi }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Jenis Pekerjaan</strong>
                            <p>{{ $project->jenis_pekerjaan }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Tanggal Masuk</strong>
                            <p>{{ \Carbon\Carbon::parse($project->tanggal_masuk)->format('d/m/Y') }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Status</strong>
                            <div class="d-flex align-items-center">
                                @php
                                    $statusClass = 'status-default';
                                    $statusIcon = 'fa-circle-notch';
                                    if (isset($project->status->nama)) {
                                        if (strtolower($project->status->nama) == 'approved') {
                                            $statusClass = 'status-approved';
                                            $statusIcon = 'fa-check-circle';
                                        } elseif (strtolower($project->status->nama) == 'pending') {
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fa-clock';
                                        } elseif (strtolower($project->status->nama) == 'rejected') {
                                            $statusClass = 'status-rejected';
                                            $statusIcon = 'fa-times-circle';
                                        }
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }} me-2">
                                    <i class="fas {{ $statusIcon }} me-1"></i> {{ $project->status->nama ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
