@extends('layout.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card" style="width: 28rem;">
        <div class="card-header">
            <h4>Detail Project</h4>
        </div>
        <div class="card-body">
            <p><strong>Perusahaan:</strong> {{ $project->nama_perusahaan }}</p>
            <p><strong>Nama Kapal:</strong> {{ $project->nama_kapal }}</p>
            <p><strong>Lokasi:</strong> {{ $project->lokasi }}</p>
            <p><strong>Jenis Pekerjaan:</strong> {{ $project->jenis_pekerjaan }}</p>
            <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($project->tanggal_masuk)->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ $project->status->nama ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection
