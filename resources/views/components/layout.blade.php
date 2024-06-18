<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preper</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-bgc">
    <nav class="bg-accent flex justify-end px-5 text-bgc text-center py-7 gap-4 items-center">
        <a href="{{ route('home') }}"><p>BERANDA</p></a>
        <a href="{{ route('about') }}"><p>TENTANG KAMI</p></a>
        @auth
            <div class="relative">
                <button id="dropdownButton" class="inline-flex items-center px-3 border rounded-xl py-2">
                    <div>{{ Auth::user()->UserName }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
                <div id="dropdownMenu" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0 hidden">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"><p>LOGIN</p></a>
            <a href="{{ route('register') }}"><p>REGISTER</p></a>
        @endauth
    </nav>

    {{ $slot }}

    <footer class="bg-accent flex flex-col gap-y-2 text-bgc text-center p-5">
        <div class="flex justify-center">
            <span>
                <a href="#">
                    <img src="{{ Vite::asset('resources/assets/logo.svg')}}" alt="Logo">
                </a>
            </span>
        </div>
        <p>Copyright Ⓒ 2024 Preper Project Authors. All Right Reserved</p>
        <p><a href="{{ route('about') }}"><u>Tentang Kami</u></a> | <a href="#" target='_blank'><u>Hubungi Kami</u></a></p>
    </footer>

    <script>
        $(document).ready(function(){
            $("#dropdownButton").click(function(){
                $("#dropdownMenu").toggle();
            });

            $(document).click(function(event) {
                var $target = $(event.target);
                if(!$target.closest('#dropdownButton').length &&
                $('#dropdownMenu').is(":visible")) {
                    $('#dropdownMenu').hide();
                }
            });
        });
    </script>
</body>
</html>
