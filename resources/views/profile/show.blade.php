<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
        }
        .info-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Header Card -->
                <div class="card profile-card mb-4">
                    <div class="text-center">
                        <img src="{{ getProfileImage($user, 200) }}"
                             class="rounded-circle profile-img mb-3"
                             alt="Profile Picture">

                        <h2 class="mb-1">{{ $user ? $user->name : 'Guest User' }}</h2>
                        <p class="mb-3 opacity-75">
                            <i class="fas fa-envelope"></i>
                            {{ $user ? $user->email : 'guest@example.com' }}
                        </p>

                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                            @if($user && $user->profile_picture)
                                <form action="{{ route('profile.picture.delete') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-light btn-sm"
                                            onclick="return confirm('Yakin mau hapus foto profil?')">
                                        <i class="fas fa-trash"></i> Hapus Foto
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Information Card -->
                <div class="card info-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle text-primary"></i> Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <p class="form-control-plaintext">{{ $user ? $user->name : 'Guest User' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="form-control-plaintext">{{ $user ? $user->email : 'guest@example.com' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status Foto Profil</label>
                                    <p class="form-control-plaintext">
                                        @if($user && $user->profile_picture)
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Sudah Upload</span>
                                        @else
                                            <span class="badge bg-warning"><i class="fas fa-exclamation-triangle"></i> Belum Upload</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bergabung Sejak</label>
                                    <p class="form-control-plaintext">
                                        {{ $user ? $user->created_at->format('d M Y') : 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <h6 class="text-muted">Actions</h6>
                            <div class="btn-group" role="group">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-camera"></i> Upload/Edit Foto
                                </a>
                                <a href="{{ url('/') }}" class="btn btn-secondary">
                                    <i class="fas fa-home"></i> Kembali ke Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card info-card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-lightbulb text-warning"></i> Tips Upload Foto Profil</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-check text-success"></i> Gunakan foto dengan resolusi minimal 300x300 pixel</li>
                            <li><i class="fas fa-check text-success"></i> Format yang didukung: JPEG, PNG, JPG, GIF</li>
                            <li><i class="fas fa-check text-success"></i> Ukuran file maksimal 2MB</li>
                            <li><i class="fas fa-check text-success"></i> Pastikan foto menampilkan wajah dengan jelas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>
