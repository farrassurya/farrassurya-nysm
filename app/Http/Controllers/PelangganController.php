<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\MultipleUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name','last_name','email', 'phone']; //sesuai kolom Pelanggan

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10);

        return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data termasuk multiple files
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggan,email',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'phone' => 'nullable|string|max:20',
            'files.*' => 'nullable|file|max:10240' // max 10MB per file
        ]);

        // Simpan data pelanggan
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone
        ];

        $pelanggan = Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        $data['files'] = MultipleUpload::getFiles('pelanggan', $id);
        return view('admin.pelanggan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggan,email,'.$id.',pelanggan_id',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'phone' => 'nullable|string|max:20'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        // Update data pelanggan
        $pelanggan->first_name = $request->first_name;
        $pelanggan->last_name = $request->last_name;
        $pelanggan->birthday = $request->birthday;
        $pelanggan->gender = $request->gender;
        $pelanggan->email = $request->email;
        $pelanggan->phone = $request->phone;
        $pelanggan->save();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus!');
    }

    /**
     * Handle file upload for pelanggan
     */
    public function uploadFiles(Request $request, $id)
    {
        // Cek apakah ada file
        if (!$request->hasFile('files')) {
            return redirect()->route('pelanggan.edit', $id)->with('error', 'Tidak ada file yang dipilih!');
        }

        try {
            // Validasi file
            $request->validate([
                'files' => 'required',
                'files.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf'
            ], [
                'files.required' => 'Pilih minimal 1 file!',
                'files.*.max' => 'Ukuran file maksimal 5MB!',
                'files.*.mimes' => 'Format file harus JPG, PNG, atau PDF!'
            ]);

            $uploadCount = 0;
            $files = $request->file('files');
            
            foreach ($files as $file) {
                if ($file->isValid()) {
                    // Generate unique filename
                    $originalName = $file->getClientOriginalName();
                    $fileName = time() . '_' . $originalName;
                    
                    // Store file
                    $path = $file->storeAs('pelanggan_files', $fileName, 'public');

                    // Save to database
                    MultipleUpload::create([
                        'ref_table' => 'pelanggan',
                        'ref_id' => $id,
                        'file_path' => $path,
                        'file_name' => $originalName,
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                    
                    $uploadCount++;
                }
            }

            return redirect()->route('pelanggan.show', $id)->with('success', $uploadCount . ' file berhasil diupload!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('pelanggan.edit', $id)->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.edit', $id)->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }

    /**
     * Delete specific file
     */
    public function deleteFile($fileId)
    {
        $file = MultipleUpload::findOrFail($fileId);

        // Hapus file fisik
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Hapus record database
        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
