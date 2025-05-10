@extends('layout.app')

@section('title', 'Tambah Project')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Tambah Project</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" name="nama_perusahaan" required>
                </div>

                <div class="mb-3">
                    <label for="nama_kapal" class="form-label">Nama Kapal</label>
                    <input type="text" class="form-control" name="nama_kapal" required>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" name="lokasi" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                    <input type="text" class="form-control" name="jenis_pekerjaan" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_inspeksi" class="form-label">Tanggal Inspeksi</label>
                    <input type="date" class="form-control" name="tanggal_inspeksi">
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tanggal_selesai">
                </div>

                <div class="mb-3">
                    <label for="pdf_file" class="form-label">Upload PDF</label>
                    <input type="file" class="form-control" name="pdf_file" accept=".pdf">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
