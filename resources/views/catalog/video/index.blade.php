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
    <style>

        .bezel {
            position: absolute;
            /*left: calc(50% - 20px);*/
            left: 50%;
            top: 50%;
            /*top: calc(50% - 34.14px);*/
            width: 52px;
            height: 52px;
            z-index: 19;
            margin-left: -26px;
            margin-top: -26px;
            background: rgba(0,0,0,0.5);
            border-radius: 26px;
            pointer-events: none;
        }

        /*.bezel[aria-label="Пауза"] {*/
        /*    left: 55%;*/
        /*}*/

        .bezel-icon {
            width: 40px;
            height: 40px;
            margin: 6px;
        }

        .large-play-button:hover .large-play-button-bg {
            /*-webkit-transition: fill .1s cubic-bezier(0, 0, 0.2, 1), fill-opacity .1s cubic-bezier(0, 0, 0.2, 1);*/
            /*transition: fill .1s cubic-bezier(0, 0, 0.2, 1), fill-opacity .1s cubic-bezier(0, 0, 0.2, 1);*/
            /*fill: #f00;*/
            /*fill-opacity: 1;*/
        }

        .large-play-button-bg {
            /*-webkit-transition: fill .1s cubic-bezier(0.4, 0, 1, 1), fill-opacity .1s cubic-bezier(0.4, 0, 1, 1);*/
            /*transition: fill .1s cubic-bezier(0.4, 0, 1, 1), fill-opacity .1s cubic-bezier(0.4, 0, 1, 1);*/
            /*fill: #212121;*/
            /*fill-opacity: .8;*/
        }
        .large-play-button.button {
            position: absolute;
            top: calc(50% - 34.14px);
            left: calc(50% - 50px);
            width: 100px;
            background-color: inherit;
            border: unset;
            cursor: pointer;
        }
        .bezel-text-hide {
            width: 100%;
            height: 100%;
        }
        .bezel {
            -webkit-animation: bezel-fadeout .1s linear 1 normal forwards;
            animation: bezel-fadeout .1s linear 1 normal forwards;
        }
        .videoContainer__manager ._pause,
        .videoContainer__manager ._play {
            top: 0;
            left: 0;
            opacity: 0;
            /*cursor: pointer;*/
        }
        @-webkit-keyframes bezel-fadeout {
            0% {
                opacity: 1
            }
            to {
                /*opacity: 0.5;*/
                -webkit-transform: scale(2);
                transform: scale(2)
            }
            /*to {*/
            /*    opacity: 1;*/
            /*}*/
        }

        @keyframes bezel-fadeout {
            0% {
                opacity: 1
            }
            to {
                /*opacity: 0.5;*/
                -webkit-transform: scale(2);
                transform: scale(2)
            }
            /*to {*/
            /*    opacity: 1;*/
            /*}*/
        }
    </style>
</head>
<body>
<div class="main-wrap">
    <main class="videoContainer">
        <div class="videoContainer__inner">
            <div class="videoContainer__video">
                <video src="{{$video->LinkFileVideo()}}" preload="metadata"
                       poster="{{$video->LinkFilePosterVideo()}}"></video>
                <div class="videoContainer__manager">
                    <div style="display: none;" class="bezel-text-hide _pause js--pause">
                        <div class="bezel" role="status" aria-label="Пауза">
                            <div class="bezel-icon">
                                <svg height="100%" viewBox="0 0 36 36" width="100%">
                                    <use class="svg-shadow" xlink:href="#id-86"></use>
                                    <path class="svg-fill" d="M 12,26 16,26 16,10 12,10 z M 21,26 25,26 25,10 21,10 z"
                                          id="id-86"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div style="/*display: none;*/ opacity: 1;" class="bezel-text-hide _play js--play">
                        <div class="bezel" role="status" aria-label="Смотреть">
                            <div class="bezel-icon">
                                <svg height="100%" version="1.1" viewBox="0 0 36 36" width="100%">
                                    <use class="svg-shadow" xlink:href="#id-89"></use>
                                    <path class="svg-fill" d="M 12,26 18.5,22 18.5,14 12,10 z M 18.5,22 25,18 25,18 18.5,14 z"
                                          id="id-89"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="container-for-icon-full-screen">
                        <div class="icon-full-screen">
                        </div>
                    </div>

{{--                    <button class="large-play-button button firstPlayButton" aria-label="Смотреть">--}}
{{--                        <svg height="100%" viewBox="0 0 68 48" width="100%">--}}
{{--                            <path class="large-play-button-bg"--}}
{{--                                  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"--}}
{{--                                  fill="#f00"></path>--}}
{{--                            <path d="M 45,24 27,14 27,34" fill="#fff"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
                </div>
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
</body>
</html>
