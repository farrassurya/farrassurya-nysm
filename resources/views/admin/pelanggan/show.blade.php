@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail Pelanggan</h1>
            <p class="mb-0">Informasi lengkap data pelanggan.</p>
        </div>
        <div>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Data Pelanggan -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h6><i class="fas fa-id-card text-primary"></i> ID Pelanggan</h6>
                            <p class="text-muted">{{ $dataPelanggan->pelanggan_id }}</p>

                            <h6><i class="fas fa-user text-primary"></i> Nama Lengkap</h6>
                            <p>{{ $dataPelanggan->first_name }} {{ $dataPelanggan->last_name }}</p>

                            <h6><i class="fas fa-envelope text-primary"></i> Email</h6>
                            <p>{{ $dataPelanggan->email }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6><i class="fas fa-phone text-primary"></i> Telepon</h6>
                            <p>{{ $dataPelanggan->phone ?? 'Tidak tersedia' }}</p>

                            <h6><i class="fas fa-calendar text-primary"></i> Tanggal Lahir</h6>
                            <p>{{ $dataPelanggan->birthday ? \Carbon\Carbon::parse($dataPelanggan->birthday)->format('d F Y') : 'Tidak tersedia' }}</p>

                            <h6><i class="fas fa-venus-mars text-primary"></i> Jenis Kelamin</h6>
                            <p>
                                @if($dataPelanggan->gender == 'Male')
                                    <span class="badge bg-info">{{ $dataPelanggan->gender }}</span>
                                @elseif($dataPelanggan->gender == 'Female')
                                    <span class="badge bg-danger">{{ $dataPelanggan->gender }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dataPelanggan->gender ?? 'Other' }}</span>
                                @endif
                            </p>

                            <h6><i class="fas fa-clock text-primary"></i> Tanggal Dibuat</h6>
                            <p>{{ $dataPelanggan->created_at ? $dataPelanggan->created_at->format('d M Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Pendukung -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-paperclip"></i> File Pendukung</h5>
                    <a href="{{ route('pelanggan.edit', $dataPelanggan->pelanggan_id) }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: 1px solid #28a745;">
                        <i class="fas fa-upload me-1 text-success"></i> Upload File Baru
                        <i class="fas fa-arrow-right ms-1 text-success"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row" id="filesList">
                        @if(isset($files) && $files->count() > 0)
                            @foreach($files as $file)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card border h-100">
                                    <div class="card-body text-center p-3">
                                        <!-- Preview -->
                                        @if(str_starts_with($file->file_type, 'image/'))
                                            <img src="{{ asset('storage/' . $file->file_path) }}"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px; object-fit: cover;">
                                        @else
                                            <div class="mb-2">
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            </div>
                                        @endif

                                        <!-- File Info -->
                                        <h6 class="card-title mb-1" title="{{ $file->file_name }}">
                                            {{ Str::limit($file->file_name, 18) }}
                                        </h6>
                                        <p class="card-text small text-muted mb-3">
                                            {{ number_format($file->file_size / 1024, 1) }} KB
                                        </p>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                               target="_blank" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                            <form action="{{ route('pelanggan.file.delete', $file->id) }}"
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin hapus file ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger w-100">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada file yang diupload</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
