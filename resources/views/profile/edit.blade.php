<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS untuk styling yang bagus -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #dee2e6;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h4>
                    </div>
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Kolom untuk preview gambar -->
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    <img src="{{ getProfileImage(Auth::user(), 150) }}"
                                         class="rounded-circle profile-img"
                                         alt="Profile Picture" id="preview-image">
                                </div>

                                @if(Auth::user() && Auth::user()->profile_picture)
                                    <form action="{{ route('profile.picture.delete') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin mau hapus foto profil?')">
                                            <i class="fas fa-trash"></i> Hapus Foto
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Kolom untuk form -->
                            <div class="col-md-8">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">
                                            <i class="fas fa-camera"></i> Foto Profil Baru
                                        </label>
                                        <input type="file"
                                               class="form-control @error('profile_picture') is-invalid @enderror"
                                               id="profile_picture"
                                               name="profile_picture"
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        @error('profile_picture')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Format yang diterima: JPEG, PNG, JPG, GIF. Maksimal ukuran: 2MB
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name"
                                               value="{{ Auth::user() ? Auth::user()->name : 'User' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                               value="{{ Auth::user() ? Auth::user()->email : 'user@example.com' }}" readonly>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Foto Profil
                                        </button>
                                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Profil
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function untuk preview gambar sebelum upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('preview-image');
                    var placeholder = document.getElementById('preview-placeholder');

                    if (preview) {
                        preview.src = e.target.result;
                    } else if (placeholder) {
                        // Ganti placeholder dengan gambar
                        placeholder.outerHTML = '<img src="' + e.target.result + '" class="rounded-circle profile-img" alt="Preview" id="preview-image">';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>

@if($user->profile_picture)
    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile Picture" width="200">
    <br><br>
    <form action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Profile Picture</button>
    </form>
@endif
