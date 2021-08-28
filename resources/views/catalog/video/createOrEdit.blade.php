@extends('app')

@section('content')

    <div style="display: flex; justify-content: space-between;">
        <h3>Новое видео</h3>
        <div>
            <button class="saveVideo">Сохранить</button>
            @if(empty($video) === false)
                <button class="deleteVideo">Удалить</button>
            @endif
        </div>
    </div>

    <div>

        <div class="container-video-situation">

            @php

                $nameVideo = '';
                $semanticUrlVideo = '';
                $introStarts = '';
                $introEnds = '';
                $finishStarts = '';
                $finishEnds = '';
                $linkFileVideo = '';
                $linkFilePosterVideo = '';

            @endphp

            @if(empty($video) === false)
                <input id="videoId" name="videoId" type="hidden" class="need-validate" value="{{$video->id}}">

                @php

                $nameVideo = $video->name;
                $semanticUrlVideo = $video->semanticURL;
                $intro = unserialize($video->intro);
                $introStarts = $intro['start'];
                $introEnds = $intro['end'];
                $finish = unserialize($video->finish);
                $finishStarts = $finish['start'];
                $finishEnds = $finish['end'];

                $linkFileVideo = $video->LinkFileVideo();
                $linkFilePosterVideo = $video->LinkFilePosterVideo();

                @endphp

            @endif


            <div style="padding: 10px; width: 100%;">
                <label for="nameVideo">Название</label>
                <input id="nameVideo" name="nameVideo" type="text" class="need-validate" value="{{$nameVideo}}">
            </div>

            <div style="padding: 10px; width: 100%;">
                <label for="semanticUrlVideo">Семантическая ссылка</label>
                <input id="semanticUrlVideo" name="nameVideo" type="text" class="need-validate" value="{{$semanticUrlVideo}}">
            </div>

            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <div style="padding: 10px;" class="videoFileInputContainer">
                    <label for="videoFileInput" style="">{{empty($linkFileVideo) ? 'Загрузите видео' : 'Загрузите для изменения видео'}}</label>
                    <input id="videoFileInput" name="videoFileInput" type="file" accept="video/mp4,video/x-m4v,video/*" class="">
                </div>

                <div style="padding: 10px;" class="posterVideoFileInputContainer">
                    <label for="posterVideoFileInput" style="background-image: url('{{$linkFilePosterVideo}}')">{{empty($linkFilePosterVideo) ? 'Загрузите постер' : ''}}</label>
                    <input id="posterVideoFileInput" name="posterVideoFileInput" type="file" accept="image/jpeg, image/png, image/bmp" class="">
                </div>
            </div>

            <div style="display: flex;">

                <div style="display: flex; flex-wrap: wrap; width: 50%;">

                    <div style="width: 100%; text-align: center;">Вступление</div>

                    <div style="padding: 10px; width: 50%;">
                        <label for="introVideoStarts">С</label>
                        <input class="need-validate" id="introVideoStarts" name="introVideoStarts" type="text" style="width: 100%;" value="{{$introStarts}}">
                    </div>

                    <div style="padding: 10px; width: 50%;">
                        <label for="introVideoEnds">По</label>
                        <input class="need-validate" id="introVideoEnds" name="introVideoEnds" type="text" style="width: 100%;" value="{{$introEnds}}">
                    </div>

                </div>

                <div style="display: flex; flex-wrap: wrap; width: 50%;">

                    <div style="width: 100%; text-align: center;">Завершение</div>

                    <div style="padding: 10px; width: 50%;">
                        <label for="finishVideoStarts">С</label>
                        <input class="need-validate" id="finishVideoStarts" name="finishVideoStarts" type="text" style="width: 100%;" value="{{$finishStarts}}">
                    </div>

                    <div style="padding: 10px; width: 50%;">
                        <label for="finishVideoEnds">По</label>
                        <input class="need-validate" id="finishVideoEnds" name="finishVideoEnds" type="text" style="width: 100%;" value="{{$finishEnds}}">
                    </div>

                </div>

            </div>

            <div class="parts-container">

            </div>

            <div style="margin: 30px auto;">
                <button class="add-parts" style="width: 100%;">Добавить отрывок</button>
            </div>

        </div>

    </div>

@stop

@section('js')

    @include('catalog.video.js')

    @if(empty($video) === false)

        @php

        $parts = unserialize($video->parts);
        $answers = unserialize($video->answers);

        @endphp
        <script>
        @foreach($parts['start'] as $partKey => $part)

            AddPart(true, {{$parts['start'][$partKey]}}, {{$parts['end'][$partKey]}});

            @foreach($answers['start'][$partKey] as $answerKey => $answer)

            let buttonAddAnswerManualCall_{{$partKey}}_{{$answerKey}} = document.body.querySelector('button[data-part-id="' + (partId - 1) + '"]');
            AddAnswer(buttonAddAnswerManualCall_{{$partKey}}_{{$answerKey}}, {{$answers['right'][$partKey][$answerKey]}}, "{{$answers['text'][$partKey][$answerKey]}}", "{{$answers['start'][$partKey][$answerKey]}}", "{{$answers['end'][$partKey][$answerKey]}}");

            @endforeach

        @endforeach

            document.body.querySelector('.deleteVideo').addEventListener('click', (event) => {

                event.target.parentNode.classList.add('hide-el');

                ShowLoader();

                Ajax("{{route('video-delete', $video->id)}}", 'post', {}).then((response) => {
                    ShowFlashMessage(response.message);
                    if (response.status) {
                        setTimeout(() => {
                            location.href = "{{route('all-video-page')}}";
                        }, 1500);
                    } else {
                        event.target.parentNode.classList.remove('hide-el');
                    }
                    HideLoader();
                });
            });
        </script>

    @endif

@stop
