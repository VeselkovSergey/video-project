<script>
    document.body.querySelector('#posterVideoFileInput').addEventListener('input', (event) => {
        let fileReader = new FileReader();
        fileReader.addEventListener("load", () => {
            let labelProductImg = document.querySelector('label[for="posterVideoFileInput"]');
            labelProductImg.innerHTML = '';
            labelProductImg.style.border = '';
            labelProductImg.style.backgroundImage = "url(" + fileReader.result + ")";
        }, false);
        fileReader.readAsDataURL(event.target.files[0]);
    });

    document.body.querySelector('#videoFileInput').addEventListener('input', (event) => {
        let fileReader = new FileReader();
        fileReader.addEventListener("load", () => {
            let labelProductImg = document.querySelector('label[for="videoFileInput"]');
            labelProductImg.innerHTML = 'Видео готово к загрузке!';
        }, false);
        fileReader.readAsDataURL(event.target.files[0]);
    });

    document.body.querySelector('.saveVideo').addEventListener('click', (event) => {
        let dataForm = getDataFormContainer('container-video-situation', true);

        if (dataForm === false) {
            ShowFlashMessage('Не все обязательные поля заполнены!');
            return;
        }

        event.target.parentNode.classList.add('hide-el');

        ShowLoader();

        Ajax("{{route('video-save', !empty($video) ? $video->id : '')}}", 'post', dataForm).then((response) => {
            ShowFlashMessage(response.message);
            if (response.status) {
                setTimeout(() => {
                    location.href = "{{route('all-video-page')}}";
                }, 1500);
            } else {
                event.target.parentNode.classList.remove('hide-el');
            }
            HideLoader();
        }).catch(() => {
            event.target.parentNode.classList.remove('hide-el');
            HideLoader();
        });
    });

    document.body.querySelector('#nameVideo').addEventListener('input', (event) => {
        document.body.querySelector('#semanticUrlVideo').value = SemanticURL(event.target.value);
    });

    document.body.querySelector('#semanticUrlVideo').addEventListener('input', (event) => {
        document.body.querySelector('#semanticUrlVideo').value = SemanticURL(event.target.value);
    });

    document.body.querySelector('.add-parts').addEventListener('click', () => {
        AddPart();
    });

    let partId = 1;
    function AddPart(manualCall = false, valuePartsVideoStarts = '', valuePartsVideoEnds = '') {
        let partText = GeneratePart(partId, valuePartsVideoStarts, valuePartsVideoEnds);

        let part = document.createElement("div");
        part.className = 'part-container';
        part.innerHTML = partText;
        part.dataset.partId = '' + partId + '';

        let partsContainer = document.body.querySelector('.parts-container');
        partsContainer.append(part);
        partId++;

        let buttonAddAnswer = document.body.querySelector('button[data-part-id="' + (partId - 1) + '"]');
        buttonAddAnswer.addEventListener('click', (event) => {
            AddAnswer(event.target);
        });

        if (manualCall === false) {
            let event = new Event("click");
            buttonAddAnswer.dispatchEvent(event);
        }
    }

    function GeneratePart(partId, valuePartsVideoStarts = '', valuePartsVideoEnds = '') {
        return  '<div style="display: flex; flex-wrap: wrap; width: 100%;">'+
            '<div style="width: 100%; text-align: center;">Отрывок ' + partId + '</div>'+
            '<div style="padding: 10px; width: 50%;">'+
            '<label for="partsVideoStarts[' + partId + ']">С</label>'+
            '<input class="need-validate" id="partsVideoStarts[' + partId + ']" name="partsVideoStarts[' + partId + ']" value="' + valuePartsVideoStarts + '" type="text" style="width: 100%;">'+
            '</div>'+
            '<div style="padding: 10px; width: 50%;">'+
            '<label for="partsVideoEnds[' + partId + ']">По</label>'+
            '<input class="need-validate" id="partsVideoEnds[' + partId + ']" name="partsVideoEnds[' + partId + ']" value="' + valuePartsVideoEnds + '" type="text" style="width: 100%;">'+
            '</div>'+
            '</div>'+
            '<div class="answers-container" style="display: flex; flex-wrap: wrap; width: 100%;" data-part-id="' + partId + '" data-answer-id="1">'+
            //GenerateAnswer(partId, 1) +
            '</div>'+
            '<div style="padding: 10px;">'+
            '<div style="margin: 10px auto; width: 100%;">'+
            // '<button onclick="AddAnswer(this);" data-answer-id="0" data-part-id="' + partId + '">Добавить кнопку ответа</button>'+
            '<button data-answer-id="0" data-part-id="' + partId + '">Добавить кнопку ответа</button>'+
            '</div>'+
            '<div style="margin: 10px auto; width: 100%;">'+
            '<button  onclick="RemoveAnswer(this);" data-part-id="' + partId + '" style="background-color: #721c24; border: 1px solid #721c24; color: white;">Удалить кнопку ответа</button>'+
            '</div>'+
            '<div style="margin: 10px auto; width: 100%;">'+
            '<button onclick="RemovePart(' + partId + ');" data-part-id="' + partId + '" style="background-color: #721c24; border: 1px solid #721c24; color: white;">Удалить отрывок</button>'+
            '</div>'+
            '</div>';
    }

    function GenerateAnswer(partId, answerId, valueAnswerTrue = '', valueAnswerTextButton = '', valueAnswerVideoStarts = '', valueAnswerVideoEnds = '') {
        if (valueAnswerTrue === true) {
            valueAnswerTrue = 'checked';
        } else {
            valueAnswerTrue = ''
        }

        return  '<div style="width: 100%; text-align: center;">Ответ ' + answerId + '</div>'+
            '<div style="padding: 10px; width: 100%;">'+
            '<label for="answerTrue[' + partId + '][' + answerId + ']">Верный ответ</label>'+
            '<input class="need-validate" id="answerTrue[' + partId + '][' + answerId + ']" name="answerTrue[' + partId + '][' + answerId + ']" type="checkbox" ' + valueAnswerTrue + ' >'+
            '</div>'+
            '<div style="padding: 10px; width: 100%;">'+
            '<label for="answerTextButton[' + partId + '][' + answerId + ']">Текст ответа</label>'+
            '<input class="need-validate" id="answerTextButton[' + partId + '][' + answerId + ']" name="answerTextButton[' + partId + '][' + answerId + ']" value="' + valueAnswerTextButton + '" type="text" style="width: 100%;">'+
            '</div>'+
            '<div style="padding: 10px; width: 50%;">'+
            '<label for="answerVideoStarts[' + partId + '][' + answerId + ']">С</label>'+
            '<input class="need-validate" id="answerVideoStarts[' + partId + '][' + answerId + ']" name="answerVideoStarts[' + partId + '][' + answerId + ']" value="' + valueAnswerVideoStarts + '" type="text" style="width: 100%;">'+
            '</div>'+
            '<div style="padding: 10px; width: 50%;">'+
            '<label for="answerVideoEnds[' + partId + '][' + answerId + ']">По</label>'+
            '<input class="need-validate" id="answerVideoEnds[' + partId + '][' + answerId + ']" name="answerVideoEnds[' + partId + '][' + answerId + ']" value="' + valueAnswerVideoEnds + '" type="text" style="width: 100%;">'+
            '</div>';
    }

    function RemovePart(partId) {
        document.body.querySelector('div[data-part-id="' + partId + '"]').remove();
    }

    function AddAnswer(button, valueAnswerTrue = '', valueAnswerTextButton = '', valueAnswerVideoStarts = '', valueAnswerVideoEnds = '') {
        let answerId = button.dataset.answerId;
        let partId = button.dataset.partId;
        answerId++;
        button.dataset.answerId = answerId;
        let resultGenerateAnswer = GenerateAnswer(partId, answerId, valueAnswerTrue, valueAnswerTextButton, valueAnswerVideoStarts, valueAnswerVideoEnds);

        let answerContainer = document.createElement("div");
        answerContainer.className = 'answer-container';
        answerContainer.innerHTML = resultGenerateAnswer;
        answerContainer.dataset.partId = partId;
        answerContainer.dataset.answerId = answerId;

        let answersContainer = document.body.querySelector('.answers-container[data-part-id="' + partId + '"]');
        answersContainer.dataset.answerId = answerId;
        answersContainer.append(answerContainer);
    }

    function RemoveAnswer(button) {
        let partId = button.dataset.partId;
        let answersContainer = document.body.querySelector('.answers-container[data-part-id="' + partId + '"]');
        let answerId = parseInt(answersContainer.dataset.answerId);
        if (answerId > 1) {
            document.body.querySelector('.answer-container[data-part-id="' + partId + '"][data-answer-id="' + answerId + '"]').remove();
            let newAnswerId = answerId - 1;
            answersContainer.dataset.answerId = '' + newAnswerId + '';
        }
    }

    function SemanticURL(string){
        string = string + '';
        let converter = {
            'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
            'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
            'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
            'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
            'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
            'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
            'э': 'e',    'ю': 'yu',   'я': 'ya'
        };

        string = string.toLowerCase();

        let answer = '';
        for (let i = 0; i < string.length; ++i ) {
            if (converter[string[i]] === undefined){
                answer += string[i];
            } else {
                answer += converter[string[i]];
            }
        }

        answer = answer.replace(/[^-0-9a-z]/g, '-');
        answer = answer.replace(/[-]+/g, '-');
        answer = answer.replace(/^-|-$/g, '');
        return answer;
    }

</script>
