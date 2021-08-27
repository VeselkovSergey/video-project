<?php

namespace App\Http\Controllers\Catalog;

use App\Helpers\ArrayHelper;
use App\Helpers\Files;
use App\Helpers\ResultGenerate;
use App\Models\Videos;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VideoController
{
    public $storagePath = 'video';
    public $storageDriver = 'local';

    public function __construct()
    {
        ini_set('post_max_size', '500M');
        ini_set('upload_max_filesize', '400M');
        ini_set('max_execution_time', '3000');
        ini_set('max_input_time', '6000');
        set_time_limit(86400);
        ini_set('memory_limit', '-1');
    }

    public function Index()
    {
        $allVideos = Videos::all();
        return view('catalog.video.all', [
            'allVideos' => $allVideos
        ]);
    }

    public function VideoPage(Request $request)
    {
        $video = Videos::where('semanticURL', $request->semanticUrlVideo)->first();
        return view('catalog.video.index', [
            'video' => $video
        ]);
    }

    public function CreateOrEdit(Request $request)
    {
        $video = Videos::find($request->videoId);
        return view('catalog.video.createOrEdit', [
            'video' => $video
        ]);
    }

    public function ChangeSave(Request $request)
    {
        $videoFind = null;
        if (empty($request->videoId) === false) {
            $videoFind = Videos::find($request->videoId);
        }

        if (empty($request->nameVideo) === true) {
            return ResultGenerate::Error('Ошибка! Нет имени видео!');
        } else {
            $nameVideo = $request->nameVideo;
        }

        if (empty($request->semanticUrlVideo) === true) {
            return ResultGenerate::Error('Ошибка! Нет семантической ссылки!');
        } else {
            $semanticUrlVideo = $request->semanticUrlVideo;
            if (!empty(Videos::query()->where('semanticURL', $semanticUrlVideo)->first())) {
                if (empty($request->videoId) === true || $videoFind->semanticURL !== $semanticUrlVideo) {
                    return ResultGenerate::Error('Ошибка! Ссылка должна быть уникальной!');
                }
            }
        }

        if (empty($request->introVideoStarts) === true && $request->introVideoStarts !== '0') {
            return ResultGenerate::Error('Ошибка! Нет времени начала вступления!');
        } else {
            $introVideoStarts = $request->introVideoStarts;
        }

        if (empty($request->introVideoEnds) === true && $request->introVideoEnds !== '0') {
            return ResultGenerate::Error('Ошибка! Нет времени конца вступления!');
        } else {
            $introVideoEnds = $request->introVideoEnds;
        }

        if (empty($request->finishVideoStarts) === true && $request->finishVideoStarts !== '0') {
            return ResultGenerate::Error('Ошибка! Нет времени начала заключения!');
        } else {
            $finishVideoStarts = $request->finishVideoStarts;
        }

        if (empty($request->finishVideoEnds) === true && $request->finishVideoEnds !== '0') {
            return ResultGenerate::Error('Ошибка! Нет времени конца заключения!');
        } else {
            $finishVideoEnds = $request->finishVideoEnds;
        }

        if (empty($request->partsVideoStarts) === true) {
            return ResultGenerate::Error('Ошибка! Нет частей видео!');
        } else {
            $partsVideoStarts = $request->partsVideoStarts;
        }

        if (empty($request->partsVideoEnds) === true) {
            return ResultGenerate::Error('Ошибка! Нет частей видео!');
        } else {
            $partsVideoEnds = $request->partsVideoEnds;
        }

        if (empty($request->answerTextButton) === true) {
            return ResultGenerate::Error('Ошибка! Нет текста с ответом!');
        } else {
            $answerTextButton = $request->answerTextButton;
        }

        if (empty($request->answerVideoStarts) === true) {
            return ResultGenerate::Error('Ошибка! Нет времени начала ответа!');
        } else {
            $answerVideoStarts = $request->answerVideoStarts;
        }

        if (empty($request->answerVideoEnds) === true) {
            return ResultGenerate::Error('Ошибка! Нет времени конца ответа!');
        } else {
            $answerVideoEnds = $request->answerVideoEnds;
        }

        if (empty($request->answerTrue) === true) {
            return ResultGenerate::Error('Ошибка! Нет ни одного правильного ответа');
        } else {
            $answerTrue = $request->answerTrue;
        }

        if (empty($request->file('posterVideoFileInput-0')) === true && empty($request->videoId) === true) {
            return ResultGenerate::Error('Ошибка! Нет постера для видео');
        } else {
            $posterVideoFileInput = $request->file('posterVideoFileInput-0');
        }

        if (empty($request->file('videoFileInput-0')) === true  && empty($request->videoId) === true) {
            return ResultGenerate::Error('Ошибка! Нет видео файла');
        } else {
            $videoFileInput = $request->file('videoFileInput-0');
        }

        $introVideoStarts = str_replace(',', '.', $introVideoStarts);
        $introVideoEnds = str_replace(',', '.', $introVideoEnds);

        $introVideoStarts = str_replace(' ', '', $introVideoStarts);
        $introVideoEnds = str_replace(' ', '', $introVideoEnds);

        $answerTextButton = ArrayHelper::ResetKey($answerTextButton);
        $answerVideoStarts = ArrayHelper::ResetKey($answerVideoStarts);
        $answerVideoEnds = ArrayHelper::ResetKey($answerVideoEnds);
        $answerTrue = ArrayHelper::ResetKey($answerTrue);

        $answerVideoStarts = ArrayHelper::ReplaceChar($answerVideoStarts, ',', '.');
        $answerVideoEnds = ArrayHelper::ReplaceChar($answerVideoEnds, ',', '.');

        $answerVideoStarts = ArrayHelper::ReplaceChar($answerVideoStarts, ' ', '');
        $answerVideoEnds = ArrayHelper::ReplaceChar($answerVideoEnds, ' ', '');

        $partsVideoStarts = ArrayHelper::ReplaceChar($partsVideoStarts, ',', '.');
        $partsVideoEnds = ArrayHelper::ReplaceChar($partsVideoEnds, ',', '.');

        $partsVideoStarts = ArrayHelper::ReplaceChar($partsVideoStarts, ' ', '');
        $partsVideoEnds = ArrayHelper::ReplaceChar($partsVideoEnds, ' ', '');



        $intro = [
            'start' => $introVideoStarts,
            'end' => $introVideoEnds,
        ];

        $finish = [
            'start' => $finishVideoStarts,
            'end' => $finishVideoEnds,
        ];

        $parts = [
            'start' => array_values($partsVideoStarts),
            'end' => array_values($partsVideoEnds),
        ];

        $answer = [
            'text' => $answerTextButton,
            'start' => $answerVideoStarts,
            'end' => $answerVideoEnds,
            'right' => $answerTrue,
        ];

        if ((empty($request->file('posterVideoFileInput-0')) === false && empty($request->videoId) === true) || (empty($request->file('posterVideoFileInput-0')) === false && empty($request->videoId) === false)) {
            if (in_array($posterVideoFileInput->getMimeType(), ['image/jpeg', 'image/png', 'image/bmp'])) {
                if (empty($request->videoId) === false) {
                    Files::DeleteFile($videoFind->fileVideoPosterId);
                }
                $posterVideoDB = Files::SaveFile($posterVideoFileInput, $this->storagePath . '/' . 'poster', $this->storageDriver);
            } else {
                return ResultGenerate::Error('Ошибка! Загрузки файла постера!');
            }
        } else {
            $posterVideoDB = (object)[
                'id' =>   $videoFind->fileVideoPosterId,
            ];
        }

        if ((empty($request->file('videoFileInput-0')) === false && empty($request->videoId) === true) || (empty($request->file('videoFileInput-0')) === false && empty($request->videoId) === false)) {
            if (in_array($videoFileInput->getMimeType(), ['video/mp4', 'video/x-m4v', 'video/*'])) {
                if (empty($request->videoId) === false) {
                    Files::DeleteFile($videoFind->fileVideoId);
                }
                $videoFileDB = Files::SaveFile($videoFileInput, $this->storagePath, $this->storageDriver);
            } else {
                return ResultGenerate::Error('Ошибка! Загрузки файла видео!');
            }
        } else {
            $videoFileDB = (object)[
              'id' =>   $videoFind->fileVideoId,
            ];
        }



        $fields['name'] = $nameVideo;
        $fields['semanticURL'] = $semanticUrlVideo;
        $fields['intro'] = serialize($intro);
        $fields['finish'] = serialize($finish);
        $fields['parts'] = serialize($parts);
        $fields['answers'] = serialize($answer);
        $fields['fileVideoId'] = $videoFileDB->id;
        $fields['fileVideoPosterId'] = $posterVideoDB->id;

        if (empty($request->videoId) === false) {
            if ($videoFind) {
                $videoUpdate = $videoFind->update($fields);
                if ($videoUpdate) {
                    return ResultGenerate::Success('Видео обновлено успешно!');
                }
                return ResultGenerate::Error('Ошибка обновления видео!');
            }
        } else {
            $videoCreated = Videos::create($fields);
            if ($videoCreated) {
                return ResultGenerate::Success('Видео создано успешно!');
            }
            return ResultGenerate::Error('Ошибка создания видео!');
        }

        return ResultGenerate::Error('Непредвиденная ошибка. Попробуйте позже или обратитесь в поддержку!');
    }

    public function Delete(Request $request)
    {
        $videoFind = Videos::query()->find($request->videoId);
        if ($videoFind) {
            if (empty($request->videoId) === false) {
                Files::DeleteFile($videoFind->fileVideoId);
            }
            if (empty($request->videoId) === false) {
                Files::DeleteFile($videoFind->fileVideoPosterId);
            }
            $videoFind->delete();
            return ResultGenerate::Success();
        }
        return ResultGenerate::Error();
    }
}
