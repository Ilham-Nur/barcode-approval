@extends('layout.app')

@section('title', 'Project')

@section('content')
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
                                            @if ($project->status_id == 1)
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
@endsection

@section('script')
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
        });
    </script>
@endsection
