<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/c85eac8d99.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">

    @vite('resources/scss/app.scss')
    @yield('customcss')
</head>
<body>
    <div id="app">
        <header class="w-full bg-primary py-3">
            <div class="grid xl:grid-cols-3 md:grid-cols-1 justify-items-center font-roboto items-center">
                <a href="{{ route('home') }}" class="font-roboto text-white uppercase text-2xl font-black">{{ config('app.name') }}</a>
                <form action="{{ route('search') }}" method="get" class="xl:w-full max-xl:justify-items-center search-form flex max-xl:mt-2">
                    <input type="text" class="w-full" name="query" id="query" placeholder="Название магазина">
                    <button type="submit" class="btn btn-white"><img class="max-w-[22px]" src="{{ asset('loupe.svg') }}" alt=""></button>
                </form>
                <button class="xl:hidden burger-btn" onclick="toggleMenu(this);"><i class="las la-bars"></i></button>
                <div class="flex max-xl:hidden max-xl:flex-col items-center w-full xl:justify-evenly" id="menu">
                    <header-shops></header-shops>
                    @auth
                    <notifications></notifications>
                    @endauth
                    <div class="grid xl:grid-cols-2 grid-cols-1 gap-2 max-lg:mt-2">
                        @auth
                            @role(['admin', 'moderator'])
                                <a class="btn btn-white" href="{{ route('dashboard.index') }}">Admin</a>
                            @endrole
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="btn btn-white w-full" type="submit">Выйти</button>
                            </form>
                        @else

                        <div class="flex xl:flex-col xl:space-x-0 xl:space-y-2 max-xl:space-x-2 max-xl:mt-2">
                            <login-modal></login-modal>
                            <register-modal></register-modal>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
        <footer>
            <div class="w-full bg-primary">
                <div class="container py-10 mx-auto">
                    <div class="footer-links flex gap-y-5 justify-between max-md:flex-col max-md:px-5">
                        <div class="footer-link space-y-3">
                            <h2 class="font-roboto text-white uppercase text-2xl font-black">{{ config('app.name') }}</h2>
                            <p class="font-roboto text-white text-lg"><span class="font-bold">Адрес:</span> <a href="https://goo.gl/maps/Ct3Bhs54D5fs1Wuq8?coh=178572&entry=tt">ул. Тарская, 2, Омск, Омская обл., 644099</a></p>
                            <p class="font-roboto text-white text-lg"><span class="font-bold">Телефон:</span> <a href="tel:+7 (913) 999-99-99">+7 (913) 999-99-99</a></p>
                            <p class="font-roboto text-white text-lg"><span class="font-bold">Email:</span> <a href="mailto:Promozone@mail.com">promozone@mail.com</a></p>
                        </div>
                        <ul class="footer-link space-y-3">
                            <li>
                                <h2 class="font-roboto text-white uppercase text-2xl font-black">Разделы сайта</h2>
                            </li>
                            <li>
                                <a class="font-roboto text-white text-lg" href="{{ route('home') }}">Главная</a>
                            </li>
                            <li>
                                <a class="font-roboto text-white text-lg" href="{{ route('search') }}">Магазины</a>
                            </li>
                            <li>
                                <a class="font-roboto text-white text-lg" href="{{ route('privacy') }}">Политика конфиденциальности</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @vite('resources/js/app.js')
    <script>
        function toggleMenu(e) {
            let menu = document.getElementById("menu");
            if(menu.classList.contains('max-xl:hidden')) {
                menu.classList.remove('max-xl:hidden')
                e.classList.add('active')
            }
            else {
                menu.classList.add('max-xl:hidden');
                e.classList.remove('active')
            }
        }
    </script>
</body>
</html>
