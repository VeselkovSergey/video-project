@php

    $intro = unserialize($video->intro);
    $finish = unserialize($video->finish);
    $parts = unserialize($video->parts);
    $answers = unserialize($video->answers);

    $rightAnswer = \Illuminate\Support\Facades\Hash::make('true');
    $wrongAnswer = \Illuminate\Support\Facades\Hash::make('false');

@endphp

    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{$video->name}}</title>
    @include('assets.css.video-page')
</head>
<body>
<div class="main-wrap">
    <main class="videoContainer">
        <div class="videoContainer__inner">
            <div class="videoContainer__video">
                <video src="{{$video->LinkFileVideo()}}" preload="metadata"
                       poster="{{$video->LinkFilePosterVideo()}}"></video>
            </div>
            <div class="videoContainer__test">
                @foreach($parts['start'] as $partKey => $part)

                    <div class="videoContainer__step step{{$partKey + 1}}" style="display: none">
                        @foreach($answers['start'][$partKey] as $answerKey => $answer)
                            <button
                                value="{{$answers['right'][$partKey][$answerKey] === 'true' ? $rightAnswer : $wrongAnswer}}"
                                data-answer-id="{{$answerKey}}">{{$answers['text'][$partKey][$answerKey]}}</button>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="videoContainer__manager">
                <div class="_play js--play">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M256 0C114.617 0 0 114.615 0 256s114.617 256 256 256 256-114.615 256-256S397.383 0 256 0zm88.48 269.57l-128 80A16.01 16.01 0 0 1 208 352a15.95 15.95 0 0 1-7.758-2.008C195.156 347.172 192 341.82 192 336V176c0-5.82 3.156-11.172 8.242-13.992 5.086-2.836 11.305-2.664 16.238.422l128 80A16.02 16.02 0 0 1 352 256c0 5.515-2.844 10.641-7.52 13.57z"/>
                    </svg>
                </div>
                <div class="_pause js--pause" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 409.6">
                        <path
                            d="M204.8 0C91.648 0 0 91.648 0 204.8s91.648 204.8 204.8 204.8 204.8-91.648 204.8-204.8S317.952 0 204.8 0zm-22.528 256c0 12.8-10.24 22.528-22.528 22.528-12.8 0-22.528-10.24-22.528-22.528V153.6c-.512-12.288 9.728-22.528 22.016-22.528 12.8 0 23.04 10.24 23.04 22.528V256zm90.624 0c0 12.8-10.24 22.528-22.528 22.528-12.8 0-22.528-10.24-22.528-22.528V153.6c-.512-12.288 9.728-22.528 22.016-22.528 12.8 0 23.04 10.24 23.04 22.528V256z"/>
                    </svg>
                </div>
            </div>

            <div class="videoContainer__way">
                @foreach($parts['start'] as $partKey => $part)
                    <div class="btn-way-wrap">
                        <button class="btn-way" data-step="{{$partKey + 1}}"></button>
                    </div>
                @endforeach
            </div>

        </div>
    </main>
</div>
@include('assets.js.video-page')

<script>
    let req = new XMLHttpRequest();
    req.open('GET', '{{$video->LinkFileVideo()}}', true);
    req.responseType = 'blob';

    req.onload = function() {
        // Onload is triggered even on 404
        // so we need to check the status code
        if (this.status === 200) {
            let videoBlob = this.response;
            let vid = URL.createObjectURL(videoBlob); // IE10+
            // Video is now downloaded
            // and we can set it as source on the video element
            let blobVideo = document.body.querySelector('video');
            let currentTime = blobVideo.currentTime;
            blobVideo.src = vid;
            blobVideo.currentTime = currentTime;
            blobVideo.play();
        }
    }
    req.onerror = function() {
        // Error
    }

    req.send();
</script>
</body>
</html>
