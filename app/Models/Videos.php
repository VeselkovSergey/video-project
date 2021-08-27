<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Videos extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'intro',
        'semanticURL',
        'finish',
        'parts',
        'answers',
        'fileVideoId',
        'fileVideoPosterId'
    ];

//    public function FileVideo()
//    {
//        return \App\Helpers\Files::GetFileById($this->fileVideoId);
//    }
//
//    public function FilePosterVideo()
//    {
//        return $this->hasOne(Files::class, 'id', 'fileVideoPosterId');
//        return \App\Helpers\Files::GetFileById($this->fileVideoPosterId);
//    }

    public function LinkFileVideo()
    {
        return \App\Helpers\Files::GetLinkFileById($this->fileVideoId);
    }

    public function LinkFilePosterVideo()
    {
        return \App\Helpers\Files::GetLinkFileById($this->fileVideoPosterId);
    }
}
