<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai/Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
        .data-item {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 5px solid #007bff;
            background-color: #e9f7ff;
            border-radius: 4px;
        }
        .data-item strong {
            display: inline-block;
            width: 150px;
            color: #333;
        }
        .status-message {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            background-color: {{ $current_semester > 3 ? '#ffdddd' : '#d4edda' }}; /* Warna kondisional */
            color: {{ $current_semester > 3 ? '#721c24' : '#155724' }};
            border: 1px solid {{ $current_semester > 3 ? '#f5c6cb' : '#c3e6cb' }};
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Data Mahasiswa/Pegawai</h1>

        <div class="data-item">
            <strong>Nama:</strong> {{ $name }}
        </div>
        <div class="data-item">
            <strong>Umur:</strong> {{ $my_age }} tahun
        </div>
        <div class="data-item">
            <strong>Semester:</strong> {{ $current_semester }}
        </div>
        <div class="data-item">
            <strong>Tanggal Wisuda:</strong> {{ $tgl_harus_wisuda }}
        </div>
        <div class="data-item">
            <strong>Sisa Hari Belajar:</strong> {{ $time_to_study_left }} hari
        </div>
        <div class="data-item">
            <strong>Hobi:</strong> {{ implode(', ', $hobbies) }}
        </div>
        <div class="data-item">
            <strong>Cita-cita:</strong> {{ $future_goal }}
        </div>

        <div class="status-message">
            {{ $info_semester_status }}
        </div>
    </div>
</body>
</html>
