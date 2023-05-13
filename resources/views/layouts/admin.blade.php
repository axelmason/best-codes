<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://kit.fontawesome.com/c85eac8d99.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">

    <title>Панель управления - @yield('title')</title>

    @vite('resources/scss/app.scss')
    @yield('customcss')
    <style lang="scss">
        li.active {
            background: rgb(55, 65, 81)!important;
        }
    </style>
</head>
<body class="h-[100vh] overflow-y-hidden">
<div class="flex flex-col h-full">
    <header class="bg-gray-900 shadow-md text-primary flex items-center pl-10">
        <div class="text-lg font-bold mr-4 py-4">My Admin Panel</div>
    </header>
    <div class="h-full flex flex-1">
        <aside class="w-64 bg-gray-800 text-white flex flex-col justify-between">
            <nav>
                <ul>
                    @role(['admin'])
                    <li class="{{ strpos(Route::currentRouteName(), 'codes.adminPage') ? 'active' : null }}">
                        <a href="{{ route('dashboard.codes.adminPage') }}" class="block py-2 px-10 hover:bg-gray-700 w-full rounded-md">Коды</a>
                    </li>
                    <li class="{{ strpos(Route::currentRouteName(), 'shops.adminPage') ? 'active' : null }}">
                        <a href="{{ route('dashboard.shops.adminPage') }}" class="block py-2 px-10 hover:bg-gray-700 w-full rounded-md">Магазины</a>
                    </li>
                    <li class="{{ strpos(Route::currentRouteName(), 'employees.adminPage') ? 'active' : null }}">
                        <a href="{{ route('dashboard.employees.adminPage') }}" class="block py-2 px-10 hover:bg-gray-700 w-full rounded-md">Модераторы</a>
                    </li>
                    <hr>
                    @endrole
                    @role(['admin','moderator'])
                    <li class="{{ strpos(Route::currentRouteName(), 'codes.moderatePage') ? 'active' : null }}">
                        <a href="{{ route('dashboard.codes.moderatePage') }}" class="block py-2 px-10 hover:bg-gray-700 w-full rounded-md">Модерация</a>
                    </li>
                    @endrole
                </ul>
            </nav>
            <a class="block py-2 px-10 hover:bg-gray-700 w-full rounded-md" href="{{ route('home') }}">Вернуться на сайт</a>
        </aside>
        <div class="flex-1 overflow-y-scroll p-10" id="app">
            <main>@yield('content')</main>
        </div>
    </div>
</div>

@vite('resources/js/app.js')

</body>
</html>
