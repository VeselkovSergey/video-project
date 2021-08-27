@extends('app')

@section('content')

    <style>
        video {
            width: 100%;
        }
    </style>

    <div>

        <h3>Все видео:</h3>

        <div style="display: flex; flex-wrap: wrap; width: 100%;">
            @if(sizeof($allVideos))
                @foreach($allVideos as $video)
                    <div style="width: 25%; padding: 10px; display: flex; flex-wrap: wrap; flex-direction: column;">
                        <a class="text" href="{{route('video-page', $video->semanticURL)}}" style="">
{{--                            <video src="{{$video->LinkFileVideo()}}" poster="{{$video->LinkFilePosterVideo()}}"></video>--}}
                            <img src="{{$video->LinkFilePosterVideo()}}" alt="{{$video->name}}">
                            <div style="width: 100%;">{{$video->name}}</div>
                        </a>
                        @if(auth()->check())
                            <a href="{{route('video-edit-page', $video->id)}}">Редактировать</a>
                        @endif
                    </div>
                @endforeach
            @else
                <h4>Нет видео</h4>
            @endif

        </div>

    </div>

@stop

@section('js')

@stop
