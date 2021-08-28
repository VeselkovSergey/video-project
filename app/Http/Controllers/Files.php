<?php


namespace App\Http\Controllers;

use Illuminate\Http\FileHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
//            if (in_array($file->type, ['video/mp4', 'video/x-m4v', 'video/*', 'video/webm'])) {

                $stream = Storage::disk($file->disk)->readStream($file->path . '/' . $file->hash_name);
                $response_code = 200;
                $headers = ["Content-type" => $file->type];

                $size = $file->size;
                $range = $request->header('Range');
                if($range != null) {
                    $eqPos = strpos($range, "=");
                    $toPos = strpos($range, "-");
                    $unit = substr($range, 0, $eqPos);
                    $start = intval(substr($range, $eqPos+1, $toPos));
                    $success = fseek($stream, $start);
                    if($success === 0) {
                        $size = $file->size - $start;
                        $response_code = 206;
                        $headers["Accept-Ranges"] = $unit;
                        $headers["Content-Range"] = $unit . " " . $start . "-" . ($file->size-1) . "/" . $file->size;
                    }
                }

                $headers["Content-Length"] = $size;

                return response()->stream(function () use ($stream) {
                    fpassthru($stream);
                }, $response_code, $headers);
//            } else {
//                $filePath = Storage::disk($file->disk)->get($file->path . '/' . $file->hash_name);
//
//                return response($filePath)->withHeaders([
//                    'Content-type' => $file->type,
//                    'Content-Length' => $file->size,
//                    'Accept-Ranges' => 'bytes'
//                ]);
//            }

        }
        return abort(404);
    }
}
