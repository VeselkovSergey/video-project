<!DOCTYPE html>
<html lang="ru">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Панель управления</title>

    </head>

    <body style="max-width: 100%;">

        <div style="background-color: white; display: flex; justify-content: center; align-items: center; padding: 25px; height: calc(100vh - 100px); flex-direction: column;">

            <div style="padding: 15px; font-size: 20px; font-weight: bold;">Вход в панель управления</div>

            <form style="width: 300px; display: flex; justify-content: center; align-items: center; flex-direction: column; border: 1px solid; border-radius: 5px;" action="{{route('management-login')}}" method="post">

                <input id="_token" name="_token" type="hidden" value="{{csrf_token()}}">

                <div style="padding: 10px;">
                    <label for="login" style="display: block;">Логин</label>
                    <input id="login" name="login" type="text" placeholder="Логин">
                </div>

                <div style="padding: 10px;">
                    <label for="password" style="display: block;">Пароль</label>
                    <input id="password" name="password" type="password" placeholder="Пароль">
                </div>

                <div style="padding: 10px;">

                    <button style="cursor: pointer;">Войти</button>

                </div>

                <a href="{{route('home-page')}}" style="cursor: pointer;">На главную</a>

            </form>


        </div>

    </body>

</html>
