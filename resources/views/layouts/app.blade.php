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
        <header class="w-full bg-[#4B5A93] py-3">
            <div class="grid xl:grid-cols-3 md:grid-cols-1 justify-items-center font-roboto items-center">
                <a href="{{ route('home') }}"><img src="{{ asset('logo.svg') }}" alt=""></a>
                <form action="{{ route('search') }}" method="get" class="xl:w-full max-xl:justify-items-center search-form flex max-xl:mt-2">
                    <input type="text" class="w-full" name="search" id="search">
                    <button type="submit" class="btn btn-white"><img src="{{ asset('loupe.svg') }}" alt=""></button>
                </form>
                <button class="xl:hidden burger-btn" onclick="toggleMenu(this);"><i class="las la-bars"></i></button>
                <div class="flex max-xl:hidden max-xl:flex-col items-center" id="menu">
                    @auth
                    <notifications></notifications>
                    @endauth
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 max-lg:mt-2">
                        @auth
                            @role(['admin'])
                                <a class="btn btn-white" href="{{ route('admin') }}">Admin</a>
                            @endrole
                            @role(['admin', 'moderator'])
                                <a class="btn btn-white" href="{{ route('moderate') }}">Moderate</a>
                            @endrole
                            <a href="{{ route('suggest')  }}" class="btn btn-white">???????????????????? ??????</a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="btn btn-white w-full" type="submit">??????????</button>
                            </form>
                        @endauth

                        @guest
                        <div class="flex lg:flex-col lg:space-x-0 lg:space-y-2 max-lg:space-x-2 max-lg:mt-2">
                            <login-modal></login-modal>
                            <register-modal></register-modal>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
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
