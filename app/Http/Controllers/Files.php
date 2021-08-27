<?php


namespace App\Http\Controllers;

use Illuminate\Http\FileHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Models\Files as FilesDB;
use Illuminate\Support\Facades\Storage;

class Files
{
    public static function GetFile(Request $request)
    {
        return self::GetFileById($request->file_id);
    }

    public static function GetFileById($fileId)
    {
        $file = FilesDB::find($fileId);
        if ($file) {
            $filePath = Storage::disk($file->disk)->get($file->path . '/' . $file->hash_name);
            return response($filePath)->withHeaders([
                'Content-type' => $file->type,
                'Content-Length' => $file->size,
                'Accept-Ranges' => 'bytes'
            ]);
        }
        return abort(404);
    }

    public static function GetLinkFileById($fileId)
    {
        $file = FilesDB::find($fileId);
        if ($file) {
            return url('file/' . $file->hash_name);
        }
        return abort(404);
    }

    public function GetFileByHash(Request $request) {
        $file = FilesDB::where('hash_name', $request->hashFile)->first();
        if ($file) {
            $filePath = Storage::disk($file->disk)->get($file->path . '/' . $file->hash_name);
            return response($filePath)->withHeaders([
                'Content-type' => $file->type,
                'Content-Length' => $file->size,
                'Accept-Ranges' => 'bytes'
            ]);
        }
        return abort(404);
    }
}
