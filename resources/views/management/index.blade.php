@extends('app')

@section('content')

    <style>
        video {
            width: 100%;
        }
        a:active, /* активная/посещенная ссылка */
        a:hover,  /* при наведении */
        a {
            text-decoration: none;
            color: black;
        }
    </style>

    <div style="padding: 25px 0;">

        <h3>Все видео:</h3>

        <div style="display: flex; flex-wrap: wrap; width: 100%;">

            <a href="#" style="width: 25%; padding: 10px; display: flex; flex-wrap: wrap; flex-direction: column;">
                <video src="https://video.26-2.ru/video-2/img/222-720-50Mb.mp4" poster="https://video.26-2.ru/video-2/img/ZAZ_1.jpg"></video>
                <div style="width: 100%;">Название очень длинное</div>
            </a>

            @for($i = 0; $i < 13; $i++)

                <a href="#" style="width: 25%; padding: 10px; display: flex; flex-wrap: wrap;">
                    <video src="https://video.26-2.ru/video-2/img/222-720-50Mb.mp4" poster="https://video.26-2.ru/video-2/img/ZAZ_1.jpg"></video>
                    <div style="width: 100%;">Название очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень длинное</div>
                </a>

            @endfor

        </div>

    </div>



@stop

@section('js')

@stop
