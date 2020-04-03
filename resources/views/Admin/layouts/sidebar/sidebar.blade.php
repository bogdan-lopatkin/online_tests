
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(route('admin.category.index'))  ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}" > {{-- todo Нормальную подсветку--}}
                            Панель управления <span class="sr-only"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(route('admin.category.index'))  ? 'active' : ''}}"  href="{{ route('admin.category.index') }}">
                            Категории
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(route('admin.category.index'))  ? 'active' : '' }}" href="{{ route('admin.test.index') }}">
                            Тесты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(route('admin.category.index'))  ? 'active' : '' }}" href="{{ route('admin.question.index') }}">
                            Вопросы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(route('admin.category.index'))  ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                            Пользователи
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
