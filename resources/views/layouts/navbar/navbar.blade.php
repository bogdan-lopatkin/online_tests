<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('OnlineTests', 'OnlineTests') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggl er-icon"><img src="https://www.freelogodesign.org/file/app/client/thumb/a4cabbc8-6cff-4505-af62-53eaafd55866_200x200.png?1585223309929"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Бесплатные тесты
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <ul>
                            <li class="dropdown-item flex-column"><a href="{{ route('tests') }}">Все доступные тесты</a></li>
                            @foreach($categories as $category)
                                <li class="dropdown-item d-flex flex-column">
                                    <a href="{{ route('tests.category',$category['id']) }}">{{ $category['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Тесты для учеников
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <ul>
                            <li class="dropdown-item flex-column"><a href="">Все доступные тесты</a></li>
                            @foreach($categories as $category)
                                <li class="dropdown-item d-flex flex-column">
                                    <a href="">{{ $category['name'] }}</a>
                                <!--  <span>Сложность тестов</span>
                                    <div class="difficulty">
                                       @for($difficulty=5;$difficulty>=1;$difficulty--)
                                    <a href="">☆</a>
                                        @endfor
                                    </div>-->
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Экзамены
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <ul>
                            <li class="dropdown-item flex-column"><a href="">Все доступные экзамены</a></li>
                            @foreach($categories as $category)
                                <li class="dropdown-item d-flex flex-column">
                                    <a href="">{{ $category['name'] }}</a>
                                <!--  <span>Сложность тестов</span>
                                    <div class="difficulty">
                                       @for($difficulty=5;$difficulty>=1;$difficulty--)
                                    <a href="">☆</a>
                                        @endfor
                                    </div>-->
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Сообщество</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Учебные материалы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Премиум подписка</a>
                </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}">Личный кабинет</a>
                            <a class="dropdown-item" href="{{ route('home.settings') }}">Изменить аккаунт</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
