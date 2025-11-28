<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleUpload extends Model
{
    protected $table = 'multipleuploads';

    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    /**
     * Get files for specific table and ID
     */
    public static function getFiles($table, $id)
    {
        return self::where('ref_table', $table)
                  ->where('ref_id', $id)
                  ->orderBy('created_at', 'desc')
                  ->get();
    }

    /**
     * Delete files for specific table and ID
     */
    public static function deleteFiles($table, $id)
    {
        $files = self::where('ref_table', $table)
                    ->where('ref_id', $id)
                    ->get();

        foreach ($files as $file) {
            // Hapus file fisik
            if (\Storage::disk('public')->exists($file->file_path)) {
                \Storage::disk('public')->delete($file->file_path);
            }
            // Hapus record database
            $file->delete();
        }
    }
}
