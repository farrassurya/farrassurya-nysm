<!DOCTYPE html>
<html>
<head>
    <title>Test Upload Debug</title>
</head>
<body>
    <h2>Direct Upload Test</h2>
    
    @if(session('success'))
        <div style="color: green; padding: 10px; border: 1px solid green;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="color: red; padding: 10px; border: 1px solid red;">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="/pelanggan/1/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <p>Upload to Pelanggan ID: 1</p>
        <input type="file" name="files[]" multiple required>
        <button type="submit">Test Upload</button>
    </form>
    
    <hr>
    
    <h3>Database Records:</h3>
    @php
        $records = \App\Models\MultipleUpload::all();
    @endphp
    
    @if($records->count() > 0)
        <ul>
        @foreach($records as $record)
            <li>ID: {{ $record->id }} | Table: {{ $record->ref_table }} | Ref ID: {{ $record->ref_id }} | File: {{ $record->file_name }}</li>
        @endforeach
        </ul>
    @else
        <p>No records found</p>
    @endif
    
    <hr>
    
    <h3>Files in Storage:</h3>
    @php
        $files = \Storage::disk('public')->files('pelanggan_files');
    @endphp
    
    @if(count($files) > 0)
        <ul>
        @foreach($files as $file)
            <li>{{ $file }}</li>
        @endforeach
        </ul>
    @else
        <p>No files in storage</p>
    @endif
</body>
</html>