<?php


namespace App\Models;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Files extends Model
{
    use Notifiable;

    protected $fillable = [
        'hash_name',
        'original_name',
        'extension',
        'size',
        'type',
        'disk',
        'path',
    ];

    public static function SaveFile(UploadedFile $file, string $path = 'files', string $disk = 'local')
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->extension();
        $type = $file->getMimeType();
        $size = $file->getSize();
        $hashFileName = pathinfo($file->hashName(), PATHINFO_FILENAME);
        $file->storeAs($path, $hashFileName, $disk);

        return self::query()->create([
            'hash_name' => $hashFileName,
            'original_name' => $originalFileName,
            'extension' => $extension,
            'size' => $size,
            'type' => $type,
            'disk' => $disk,
            'path' => $path,
        ]);
    }

    public static function DeleteFile($fileId)
    {
        $file = self::query()->find($fileId);
        if ($file) {
            $filePath = Storage::disk($file->disk)->delete($file->path . '/' . $file->hash_name);
            $file->delete();
            return true;
        }
        return false;
    }
}
