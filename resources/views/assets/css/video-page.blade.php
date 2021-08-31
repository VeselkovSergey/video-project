<style>
    @font-face {
        /*font-family: "Montserrat";*/
        /*src: url("../fonts/Montserrat-SemiBold.eot");*/
        /*src: local("Montserrat SemiBold"), local("Montserrat-SemiBold"), url("../fonts/Montserrat-SemiBold.eot?#iefix") format("embedded-opentype"), url("../fonts/Montserrat-SemiBold.woff2") format("woff2"), url("../fonts/Montserrat-SemiBold.woff") format("woff"), url("../fonts/Montserrat-SemiBold.ttf") format("truetype");*/
        font-weight: 600;
        font-style: normal
    }

    body {
        max-width: 100%;
        color: #252525;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 0;
        margin: 0;
        /*font-family: Montserrat;*/
        font-size: 16px;
        font-weight: 400;
        line-height: 20px
    }

    body * {
        box-sizing: border-box
    }

    main {
        flex-grow: 1;
        overflow: hidden
    }

    svg,
    img {
        max-width: 100%;
        max-height: 100%
    }

    .main-wrap {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow: hidden
    }

    .main-wrap main {
        flex: 1 0 auto
    }

    .main-wrap .footer {
        flex: 0 0 auto
    }

    .container {
        width: 1200px;
        max-width: calc(100% - 30px);
        margin: 0 auto
    }

    .videoContainer {
        min-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .videoContainer__inner {
        width: 800px;
        position: relative
    }

    .videoContainer__video {
        max-width: 100%;
        position: relative;
    }

    .videoContainer__video video {
        max-width: 100%
    }

    .videoContainer__test {
        position: absolute;
        bottom: 60px;
        left: 60px;
        right: 60px;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .videoContainer__test button {
        margin: 15px;
        /*font-family: "Montserrat";*/
        font-weight: 600;
        font-size: 20px;
        letter-spacing: 0.6px;
        line-height: 27px;
        text-align: center;
        text-decoration: none;
        color: #ffffff !important;
        min-height: 59px;
        padding: 16px 45px;
        border-radius: 4px;
        background-color: #ff3b00;
        transition: 0.2s;
        border: none;
        cursor: pointer;
        display: inline-block;
        text-transform: uppercase
    }

    .videoContainer__test button:hover {
        background-color: #c40013
    }

    .videoContainer__manager {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
    }
    .videoContainer__manager ._play,
    .videoContainer__manager ._pause {
        /*background-color: #000;*/
        /*border-radius: 50%;*/
        position: absolute;
        left: 50%;
        top: 50%;
        /*width: 48px;*/
        /*height: 48px;*/
        /*fill: white*/
    }

    .videoContainer__way {
        display: flex;
        align-items: center;
        justify-content: space-around;
        position: relative;
        z-index: 1;
        line-height: 0
    }

    .videoContainer__way::before {
        z-index: -2;
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 10px;
        border-radius: 5px;
        background-color: #c4c4c4
    }

    .videoContainer__way .btn-way {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #C4C4C4;
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        position: relative;
        transform: scale(0.6);
        transition: 0.2s;
        cursor: pointer;
        outline: none;
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-size: auto 40%
    }

    .videoContainer__way .btn-way:hover {
        transform: scale(0.8) !important
    }

    .videoContainer__way .btn-way-wrap {
        flex: 1 1 40px;
        text-align: center;
        position: relative;
        z-index: 1
    }

    .videoContainer__way .btn-way-wrap::before {
        z-index: -2;
        content: "";
        position: absolute;
        left: 50%;
        width: 100%;
        top: calc(50% - 5px);
        height: 10px;
        border-radius: 5px;
        background-color: #31883F;
        transform: scaleX(0);
        transform-origin: 0 0;
        transition: 0.4s
    }

    .videoContainer__way .btn-way-wrap:last-child::before {
        width: 50%
    }

    .videoContainer__way .btn-way-wrap:first-child::after {
        z-index: -2;
        content: "";
        position: absolute;
        right: 50%;
        width: 50%;
        top: calc(50% - 5px);
        height: 10px;
        border-radius: 5px;
        background-color: #31883F
    }

    .videoContainer__way .btn-way-wrap._error .btn-way,
    .videoContainer__way .btn-way-wrap._error .btn-way,
    .videoContainer__way .btn-way-wrap._success .btn-way,
    .videoContainer__way .btn-way-wrap._success .btn-way {
        transform: scale(1)
    }

    .videoContainer__way .btn-way-wrap._error::before,
    .videoContainer__way .btn-way-wrap._success::before {
        transform: scale(1)
    }

    .videoContainer__way .btn-way-wrap._error .btn-way {
        background-color: #C4695E;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='23' height='23' fill='none' stroke='%23fff' stroke-width='5'%3E%3Cpath d='M2 21L21 2'/%3E%3Cpath d='M2 2l19 19'/%3E%3C/svg%3E")
    }

    .videoContainer__way .btn-way-wrap._success .btn-way {
        background-color: #58C069;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='26' height='19' fill='none'%3E%3Cpath d='M2 8.5L10.5 16L24 2' stroke='%23fff' stroke-width='4'/%3E%3C/svg%3E")
    }
</style>
