@extends('layouts.admin.app')

@section('content')
    <div class="py-4">
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
                <li class="breadcrumb-item"><a href="#">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit User</h1>
                <p class="mb-0">Form untuk mengedit data user beserta foto profil.</p>
            </div>
            <div>
                <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('user.update', $dataUser->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ $dataUser->name }}"
                                        id="name" class="form-control" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah password</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $dataUser->email }}" id="email"
                                        class="form-control" required>
                                </div>

                                <!-- Profile Picture -->
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Foto Profil Baru</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                                           accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <!-- Current Photo -->
                                <div class="mb-3 text-center">
                                    <label class="form-label">Foto Profil Saat Ini</label>
                                    <div class="mb-3">
                                        <img id="current-image" src="{{ getProfileImage($dataUser, 120) }}"
                                             class="rounded-circle"
                                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dee2e6;"
                                             alt="Current Profile Picture">
                                    </div>

                                    <!-- Preview for new image -->
                                    <img id="preview" src="#" alt="Preview" class="rounded-circle"
                                         style="width: 120px; height: 120px; object-fit: cover; display: none; border: 3px solid #28a745;">
                                </div>

                                <!-- Buttons -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                    <a href="{{ route('user.index') }}"
                                        class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function untuk preview gambar sebelum upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';

                    // Hide current image
                    var currentImage = document.getElementById('current-image');
                    var currentPlaceholder = document.getElementById('current-placeholder');
                    if (currentImage) currentImage.style.display = 'none';
                    if (currentPlaceholder) currentPlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                document.getElementById('preview').style.display = 'none';

                // Show current image again
                var currentImage = document.getElementById('current-image');
                var currentPlaceholder = document.getElementById('current-placeholder');
                if (currentImage) currentImage.style.display = 'block';
                if (currentPlaceholder) currentPlaceholder.style.display = 'flex';
            }
        }
    </script>
@endsection
