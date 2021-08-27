<style>
    /* Указываем box sizing */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* Убираем внутренние отступы */
    ul[class],
    ol[class] {
        padding: 0;
    }

    /* Убираем внешние отступы */
    body,
    h1,
    h2,
    h3,
    h4,
    p,
    ul[class],
    ol[class],
    li,
    figure,
    figcaption,
    blockquote,
    dl,
    dd {
        margin: 0;
    }

    /* Выставляем основные настройки по-умолчанию для body */
    body {
        min-height: 100vh;
        scroll-behavior: smooth;
        text-rendering: optimizeSpeed;
        line-height: 1.5;
        max-width: 100%;
    }

    /* Удаляем стандартную стилизацию для всех ul и il, у которых есть атрибут class*/
    ul[class],
    ol[class] {
        list-style: none;
    }

    /* Элементы a, у которых нет класса, сбрасываем до дефолтных стилей */
    a:not([class]) {
        text-decoration-skip-ink: auto;
    }

    /* Элементы a, у которых есть класс text, сбрасываем оформление */
    a.text:active, /* активная/посещенная ссылка */
    a.text:hover,  /* при наведении */
    a.text {
        text-decoration: none;
        color: black;
    }

    /* Упрощаем работу с изображениями */
    img {
        max-width: 100%;
        display: block;
    }

    /* Указываем понятную периодичность в потоке данных у article*/
    article > * + * {
        margin-top: 1em;
    }

    /* Наследуем шрифты для инпутов и кнопок */
    input,
    button,
    textarea,
    select {
        font: inherit;
    }

    /* Удаляем все анимации и переходы для людей, которые предпочитай их не использовать */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
    input {
        outline:none;
    }

</style>

<style>
    .show-el {
        display: block;
    }
    .hide-el {
        display: none;
    }

    ::-webkit-scrollbar {
        width: 12px;               /* width of the entire scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #a4a4a4;        /* color of the tracking area */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #606060;    /* color of the scroll thumb */
    }
    ::-webkit-scrollbar-thumb:hover {
        background-color: #818181;    /* color of the scroll thumb */
    }
</style>

<style>

    .cp {
        cursor: pointer;
    }

    .flash-message {
        text-align: center;
        padding: 5px;
        position: fixed;
        width: 100%;
        /*display: none;*/
    }

    .flash-message.show-el {
        display: block;
    }

    .flash-message-error{
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .flash-message-info{
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    .flash-message-success{
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .modal {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }
    .modal.show-el {
        display: flex;
    }
    .modal-close-button {
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
    }
    .modal-container {
        /* position: fixed; */
        /* top: 10%; */
        width: 100%;
        margin: auto;
        display: flex;
    }
    .modal-flash-message {
        position: absolute;
        width: 100%;
        cursor: pointer;
        text-align: center;
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    .window-modal {
        margin: auto;
        /* background-color: white; */
        max-height: 90vh;
        overflow: auto;
        position: relative;
    }

    header {
        /*height: 100px;*/
        background-color: #5a6675;
        position: sticky;
        top: 0;
        z-index: 5;
        box-shadow: 0 3px 10px rgb(0 0 0);
        color: white;
        /*width: 100vw;*/
        width: 100%;
    }

    main {
        min-height: calc(100vh - 200px);
        margin: 25px 15% 0 15%;
    }

    input.need-validate.highlight {
        border: 1px solid red;
    }
</style>

{{-- style edit video page --}}

<style>
    label {
        display: block;
    }

    label[for="videoFileInput"],
    label[for="posterVideoFileInput"] {
        max-width: 640px;
        max-height: 360px;
        width: 640px;
        height: 360px;
        border: 1px solid black;
        text-align: center;
        line-height: 360px;
        cursor: pointer;
        margin: auto;
        background-size: contain;
    }
    #videoFileInput,
    #posterVideoFileInput {
        display: none;
    }

    #nameVideo,
    #semanticUrlVideo {
        width: 100%;
    }

    .answer-container {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .part-container {
        display: flex;
        flex-wrap: wrap;
        border: 1px solid black;
    }

    .videoFileInputContainer,
    .posterVideoFileInputContainer {
        width: 50%;
    }

    @media (max-width: 1860px) {
        .videoFileInputContainer,
        .posterVideoFileInputContainer {
            width: 100%;
        }
    }
</style>
