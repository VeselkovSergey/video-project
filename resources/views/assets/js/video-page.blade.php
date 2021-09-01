<script>
    document.addEventListener('DOMContentLoaded', function () {

        let video = document.querySelector('.videoContainer__video video');
        let buttonPlay = document.querySelector('.js--play');
        let firstPlayButton = document.querySelector('.firstPlayButton');
        let buttonPause = document.querySelector('.js--pause');
        // let buttonFullScreen = document.querySelector('.icon-full-screen');
        // let videoContainer = document.querySelector('.videoContainer');
        // let videoContainerInner = document.querySelector('.videoContainer__inner');
        let currentTime = 0;
        let videoMap = [
            {
                intro: {
                    start: {{$intro['start']}},
                    end: {{$intro['end']}}
                },  //  вступление
            },
                @foreach($parts['start'] as $partKey => $part)
            {
                question: {
                    start: {{$parts['start'][$partKey]}},
                    end: {{$parts['end'][$partKey]}}
                },  //  вопрос
                @foreach($answers['start'][$partKey] as $answerKey => $answer)
                    {{$answerKey}}: {
                    start: {{$answers['start'][$partKey][$answerKey]}},
                    end: {{$answers['end'][$partKey][$answerKey]}}
                },  //  ответ
                @endforeach

            },
                @endforeach
            {
                finish: {
                    start: {{$finish['start']}},
                    end: {{$finish['end']}}
                },      //  заключение
            },
        ];
        let videoMapSize = videoMap.length - 1;
        let waitAnswer = false;
        let showsAnswer = false;
        let step = 0;
        let stopTime = videoMap[step]['intro'].end;
        let nextQuestionStartTime = videoMap[step]['intro'].start;
        let nextQuestionStopTime = videoMap[step]['intro'].end;
        let videoIsPlaying = false;
        // let fullScreen = false;

        buttonPlay.addEventListener('click', () => {
            PlayVideo();
        });

        // buttonFullScreen.addEventListener('click', () => {
        //     if (fullScreen === false) {
        //         videoContainer.requestFullscreen();
        //     } else {
        //         document.exitFullscreen();
        //     }
        // });

        // document.addEventListener('fullscreenchange', (event) => {
        //     if (fullScreen === false) {
        //         videoContainerInner.style.width = '80%';
        //         fullScreen = true;
        //     } else {
        //         fullScreen = false;
        //         videoContainerInner.style.width = '800px';
        //
        //     }
        // })

        // firstPlayButton.addEventListener('click', () => {
        //     firstPlayButton.style.display = 'none';
        //     PlayVideo();
        // });

        buttonPause.addEventListener('click', () => {
            PauseVideo(true);
        });

        video.addEventListener('ended', () => {
            PauseVideo(true);
            ResetVideo();
        });

        function ResetVideo() {
            step = 0;
            stopTime = videoMap[0]['intro'].end;
            video.currentTime = videoMap[0]['intro'].start;
            nextQuestionStopTime = videoMap[0]['intro'].end;
        }

        video.addEventListener('timeupdate', () => {
            currentTime = video.currentTime;
            let difference = stopTime - currentTime;
            if (difference < 0.1) {
                if (step === 0) {
                    step++;
                    stopTime = videoMap[step]['question'].end;
                    video.currentTime = videoMap[step]['question'].start;
                } else {
                    if (waitAnswer === false && showsAnswer === false) {
                        PauseVideo(videoMapSize === step);
                        if (videoMapSize > step) {
                            waitAnswer = true;
                            document.body.querySelector('.step' + (step)).style.display = '';
                        } else {
                            ResetVideo();
                        }
                    } else if (showsAnswer === true) {
                        showsAnswer = false;
                        stopTime = nextQuestionStopTime;
                        video.currentTime = nextQuestionStartTime;
                    }
                }
            }
        });

        function PlayVideo() {
            if (!waitAnswer) {
                video.play();
                videoIsPlaying = true;

                buttonPause.style.display = '';
                buttonPlay.style.display = 'none';
            }
        }

        function PauseVideo(manualPause) {
            if (!waitAnswer) {
                video.pause();
                videoIsPlaying = false;
                buttonPlay.style.display = '';
                buttonPause.style.display = 'none';

                if (manualPause) {
                    buttonPlay.style.opacity = '1';
                } else {
                    buttonPlay.style.opacity = '0';
                }
            }
        }

        function AnswerCheck(value) {
            if (value === "{{$rightAnswer}}") {
                return true
            } else if (value === "{{$wrongAnswer}}") {
                return false
            }
        }

        document.body.querySelectorAll('.videoContainer__test button').forEach((element) => {
            element.addEventListener('click', (event) => {

                let answerId = event.target.dataset.answerId;
                let result = AnswerCheck(event.target.value);

                document.body.querySelector('.step' + (step)).style.display = 'none';

                let answerStartTime = videoMap[step][answerId].start;
                let answerEndTime = videoMap[step][answerId].end;

                if (result) {
                    document.body.querySelector('[data-step="' + (step) + '"]').parentNode.classList.remove('_error');
                    document.body.querySelector('[data-step="' + (step) + '"]').parentNode.classList.add('_success');
                } else {
                    document.body.querySelector('[data-step="' + (step) + '"]').parentNode.classList.remove('_success');
                    document.body.querySelector('[data-step="' + (step) + '"]').parentNode.classList.add('_error');
                }

                stopTime = answerEndTime;
                step++;
                if (videoMapSize > step) {
                    nextQuestionStartTime = videoMap[step]['question'].start
                    nextQuestionStopTime = videoMap[step]['question'].end
                } else {
                    nextQuestionStartTime = videoMap[step]['finish'].start
                    nextQuestionStopTime = videoMap[step]['finish'].end
                }

                video.currentTime = answerStartTime;

                waitAnswer = false;
                showsAnswer = true;

                PlayVideo();
            });
        });

        document.body.querySelectorAll('[data-step]').forEach((element) => {
            element.addEventListener('click', (event) => {
                waitAnswer = false;
                showsAnswer = false;
                step = event.target.dataset.step;
                stopTime = videoMap[step].question.end;
                video.currentTime = videoMap[step].question.start;
                document.body.querySelectorAll('.videoContainer__step').forEach((element) => {
                    element.style.display = 'none';
                });
                PlayVideo();
            });
        });

        {{--let req = new XMLHttpRequest();--}}
        {{--req.open('GET', '{{$video->LinkFileVideo()}}', true);--}}
        {{--req.responseType = 'blob';--}}
        {{--req.onload = function() {--}}
        {{--    // Onload is triggered even on 404--}}
        {{--    // so we need to check the status code--}}
        {{--    if (this.status === 200) {--}}
        {{--        let videoBlob = this.response;--}}
        {{--        let vid = URL.createObjectURL(videoBlob); // IE10+--}}
        {{--        // Video is now downloaded--}}
        {{--        // and we can set it as source on the video element--}}
        {{--        let blobVideo = document.body.querySelector('video');--}}
        {{--        let currentTime = blobVideo.currentTime;--}}
        {{--        blobVideo.src = vid;--}}
        {{--        blobVideo.currentTime = currentTime;--}}
        {{--        if (videoIsPlaying === true) {--}}
        {{--            blobVideo.play();--}}
        {{--        }--}}
        {{--    }--}}
        {{--}--}}
        {{--req.onerror = function() {--}}
        {{--    // Error--}}
        {{--}--}}

        {{--req.send();--}}

    });
</script>
