@extends('layout.app')

@section('title', 'Project')

@section('content')

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1055;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5);
            padding-right: 0 !important;
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 1.75rem auto;
            pointer-events: none;
            max-width: 500px;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            animation: fadeInDown 0.3s ease-out;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1rem;
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0.75rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
            gap: 0.5rem;
        }

    </style>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Project List</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Data Project</h5>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">+ Tambah Project</a>
                    </div>
                    <div class="card-body">
                        <table id="projects-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Perusahaan</th>
                                    <th>Kapal</th>
                                    <th>Lokasi</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Tgl Masuk</th>
                                    <th>Tgl Inspeksi</th>
                                    <th>Tgl Selesai</th>
                                    <th>Status</th>
                                    <th>PDF</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $userRole = Auth::user()->role_id;
                                @endphp
                                @foreach ($projects as $index => $project)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $project->nama_perusahaan }}</td>
                                        <td>{{ $project->nama_kapal }}</td>
                                        <td>{{ $project->lokasi }}</td>
                                        <td>{{ $project->jenis_pekerjaan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($project->tanggal_masuk)->format('d/m/Y') }}</td>
                                        <td>{{ $project->tanggal_inspeksi ? \Carbon\Carbon::parse($project->tanggal_inspeksi)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $project->tanggal_selesai ? \Carbon\Carbon::parse($project->tanggal_selesai)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $statusId = $project->status_id;
                                                $statusName = $project->status->nama ?? '-';
                                                $badgeClass = match ($statusId) {
                                                    1 => 'badge bg-warning', // Pending
                                                    2 => 'badge bg-success', // Approve
                                                    3 => 'badge bg-danger', // Reject
                                                    default => 'badge bg-secondary',
                                                };
                                            @endphp
                                            <span class="{{ $badgeClass }}">{{ $statusName }}</span>
                                        </td>
                                        <td>
                                            @if ($project->pdf_path)
                                                <a href="{{ asset('storage/' . $project->pdf_path) }}"
                                                    target="_blank">Lihat PDF</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->status_id == 1 && in_array($userRole, [1, 3]))
                                                {{-- Approve --}}
                                                <button class="btn p-1 btn-sm btn-success btnApprove"
                                                    data-id="{{ $project->id }}" title="Approve">
                                                    <i data-feather="check"></i>
                                                </button>

                                                {{-- Reject --}}
                                                <button class="btn p-1 btn-sm btn-secondary btnReject"
                                                    data-id="{{ $project->id }}" title="Reject">
                                                    <i data-feather="x"></i>
                                                </button>
                                            @endif

                                            @if ($project->status_id == 2)
                                                <button class="btn p-1 btn-secondary btnGenerateBarcode"
                                                    data-id="{{ $project->id }}" title="Generate Barcode">
                                                    barcode
                                                </button>
                                            @endif

                                            {{-- Edit --}}
                                            <a href="{{ route('projects.edit', $project->id) }}"
                                                class="btn p-1 btn-sm btn-warning" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn p-1 btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus?')" title="Hapus">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="barcodeModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tampilan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="barcodeLoader">Generating...</div>
                    <div id="barcodeContainer" class="d-none">
                        <img id="barcodeImage" src="" alt="QR Code" class="img-fluid mb-3"
                            style="max-width: 300px;">
                        <a id="barcodeDownload" href="#" class="btn btn-primary" download>Download QR Code</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalButtons = document.querySelectorAll('.btnGenerateBarcode');
            const modal = document.getElementById('barcodeModal');

            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    modal.classList.add('show');
                    modal.style.display = 'block';
                });
            });

            // Close modal saat tombol close diklik atau backdrop diklik
            modal.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal') || e.target.classList.contains('btn-close')) {
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#projects-table').DataTable();

            $('.btnApprove').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin Approve Project?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Approve!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/projects/${id}/approve`,
                            type: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Sukses', res.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                            }
                        });
                    }
                });
            });

            // Reject
            $('.btnReject').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin Reject Project?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Reject!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/projects/${id}/reject`,
                            type: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Ditolak', res.message, 'success').then(
                                    () => {
                                        location.reload();
                                    });
                            },
                            error: function() {
                                Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                            }
                        });
                    }
                });
            });

            $('.btnGenerateBarcode').on('click', function() {
                const id = $(this).data('id');

                $('#barcodeContainer').addClass('d-none');
                $('#barcodeLoader').text('Loading...').removeClass('d-none');
                $('#barcodeModal').modal('show');

                $.ajax({
                    url: '{{ route('projects.generate-barcode') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        $('#barcodeImage').attr('src', response.path);
                        $('#barcodeDownload').attr('href', response.path);
                        $('#barcodeLoader').addClass('d-none');
                        $('#barcodeContainer').removeClass('d-none');
                    },
                    error: function() {
                        $('#barcodeLoader').text('Gagal generate barcode');
                    }
                });
            });
        });
    </script>
@endsection
