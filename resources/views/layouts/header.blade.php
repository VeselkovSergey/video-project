<div style="height: 100%; display: flex; /*justify-content: center; align-items: center;*/">

{{--    <a class="text" style="color:white; font-size: 20px; padding: 10px;" href="{{route('home-page')}}">Главная</a>--}}

    <a class="text" style="color:white; font-size: 20px; padding: 10px;" href="{{route('all-video-page')}}">Все видео</a>

    @if(auth()->check())

    <a class="text" style="color:white; font-size: 20px; padding: 10px;" href="{{route('video-create-page')}}">Новое видео</a>

    <a class="text" style="color:white; font-size: 20px; padding: 10px;" href="{{route('management-logout')}}">Выйти</a>

    @endif

</div>
