<!DOCTYPE html>
<html lang="ru">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('meta')

        <title>{{ isset($title_page) ? $title_page : env('APP_NAME') }}</title>

        @include('assets.css.main-style')
        @include('assets.css.loader-style')

        @yield('css')

    </head>

    <body>

    <div class="modal hide-el">

        <div class="modal-flash-message hide-el">

            <div class="modal-flash-message-content">
            </div>

        </div>

        <div class="modal-container">
            <div class="window-modal">

                <div class="modal-close-button">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12.6365 13.3996L13.4001 12.636L7.76373 6.99961L13.4001 1.36325L12.6365 0.599609L7.0001 6.23597L1.36373 0.599609L0.600098 1.36325L6.23646 6.99961L0.600098 12.636L1.36373 13.3996L7.0001 7.76325L12.6365 13.3996Z"
                              fill="#000000"></path>
                    </svg>
                </div>

                <div class="modal-content">
                </div>

            </div>
        </div>

    </div>

        <header>
            @include('layouts.header')
        </header>

        <div class="flash-message flash-message-error hide-el">
1
        </div>

        <main>

            @yield('content')

        </main>

        @include('assets.js.main-script')

    @yield('js')

    </body>

</html>
