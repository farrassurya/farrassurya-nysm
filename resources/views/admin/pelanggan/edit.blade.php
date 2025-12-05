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
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk mengedit data pelanggan.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" name="first_name" value="{{ $dataPelanggan->first_name }}"
                                        id="first_name" class="form-control" required>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" name="last_name" value="{{ $dataPelanggan->last_name }}"
                                        id="last_name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday" value="{{ $dataPelanggan->birthday }}"
                                        id="birthday" class="form-control">
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option selected>Gender</option>
                                        <option value="Male" {{ $dataPelanggan->gender == 'Male' ? 'Selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $dataPelanggan->gender == 'Female' ? 'Selected' : '' }}>
                                            Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" value="{{ $dataPelanggan->email }}" id="email"
                                        class="form-control" required>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ $dataPelanggan->phone }}" id="phone"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Upload File Section -->
                    <div class="row justify-content-end mt-3">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="font-size: 0.9rem;">Upload File Pendukung</label>
                                <form action="{{ route('pelanggan.upload', $dataPelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="file" name="files[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf" required style="font-size: 0.875rem; padding: 0.375rem 0.75rem;">
                                        <button type="submit" class="btn btn-success" style="font-size: 0.875rem; padding: 0.375rem 0.75rem; white-space: nowrap;">
                                            Upload
                                        </button>
                                    </div>
                                    <div class="form-text mt-1" style="font-size: 0.75rem;">Format: JPG, PNG, PDF. Max 5MB/file.</div>
                                </form>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-3">
                                <button type="submit" form="editForm" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('pelanggan.index') }}"
                                    class="btn btn-outline-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
