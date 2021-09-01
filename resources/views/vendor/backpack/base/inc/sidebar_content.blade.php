<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<style>
    .text-reserved {
        color: #57a283 !important;
        display: flex !important;
        align-items: center;
        gap: 10px;
    }
    .reserved-icon {
        display: inline-block;
        transform: scale(.8);
    }
    .reserved-rounded {
        border-radius: 20px;
    }
    .sidebar.sidebar-pills .nav-link.active, .sidebar.sidebar-pills .nav-link:hover {
        background: rgba(87,162,131,.15) !important;
    }
</style>
@if(backpack_user()->role === \App\Domain\Contracts\MainContract::TRANSLATE[\App\Domain\Contracts\MainContract::ADMINISTRATOR])

    <li class='nav-item'>
        <a class='nav-link' href='{{ backpack_url('organizationrequest') }}'>
            <i class='nav-icon lab la-wpforms'></i> Запросы
        </a>
    </li>
    <li class='nav-item'>
        <a class='nav-link' href='{{ backpack_url('user') }}'>
            <i class='nav-icon la la-users'></i> Пользователи
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link' href='{{ backpack_url('category') }}'>
            <i class='nav-icon las la-bars'></i> Категории
        </a>
    </li>

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle font-weight-normal" href="#">
            <i class='nav-icon las la-globe'></i> Местоположение
        </a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('country') }}'>
                    <i class='nav-icon las la-flag'></i> Страны
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('city') }}'>
                    <i class='nav-icon las la-map-marker'></i> Города
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('languages') }}'>
                    <i class='nav-icon las la-language'></i> Языки
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item nav-dropdown">

        <a class="nav-link nav-dropdown-toggle font-weight-normal" href="#">
            <i class="las la-id-card"></i> Контакты
        </a>

        <ul class="nav-dropdown-items">

            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('contracts') }}'>
                    <i class="las la-address-card"></i> Договор оферты
                </a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('privacy') }}'>
                    <i class="las la-id-card-alt"></i> Политика конфиденциальности
                </a>
            </li>

        </ul>
    </li>

    <li class='nav-item'>
        <a class='nav-link' href='{{ backpack_url('booking') }}'>
            <i class='nav-icon las la-sort'></i> Бронирование
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link' href='{{ backpack_url('review') }}'>
            <i class='nav-icon las la-comment'></i> Отзывы
        </a>
    </li>


    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle font-weight-normal" href="#">
            <i class='nav-icon las la-building'></i> Организации
        </a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('organization') }}'>
                    <i class='nav-icon las la-building'></i> Организации</a>
            </li>
        </ul>
    </li>

@else

    <li class="nav-item">
        <a class="nav-link text-reserved" style="color: #57a283 !important;" href="{{ backpack_url('dashboard') }}">
            <img src="/img/logo/reception.png" class="reserved-icon" width="24" height="24"> Резервы
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('booking') }}'>
            <img src="/img/logo/calendar.png" class="reserved-icon" width="24" height="24"> Бронирование
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('review') }}'>
            <img src="/img/logo/chat.png" class="reserved-icon" width="24" height="24"> Отзывы
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('statistics') }}'>
            <img src="/img/logo/pie-chart.png" class="reserved-icon" width="24" height="24"> Статистика
        </a>
    </li>

    <li class="nav-title">
        <span class="color-reserved">Основное</span>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('entity') }}'>
            <img src="/favicon/favicon-32x32.png" class="reserved-icon" width="24" height="24"> Заведение
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('room') }}'>
            <img src="/img/logo/wedding-dinner.png" class="reserved-icon" width="24" height="24"> Комнаты и столы
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('photos') }}'>
            <img src="/img/logo/gallery.png" class="reserved-icon" width="24" height="24"> Фото
        </a>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('menus') }}'>
            <img src="/img/logo/hot-food.png" class="reserved-icon" width="24" height="24"> Меню
        </a>
    </li>

    <li class="nav-title">
        <span class="color-reserved">Сервисы</span>
    </li>

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle font-weight-normal text-reserved" style="color: #57a283 !important;">
            <img src="/img/logo/iiko.ico" class="reserved-icon reserved-rounded" width="24" height="24"> Iiko
        </a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('iiko') }}'>
                    <i class='nav-icon las la-cogs'></i> Iiko
                </a>
            </li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('iikotables') }}'>
                    <i class='nav-icon las la-cogs'></i> Iiko комнаты
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('iikotablelist') }}'>
                    <i class='nav-icon las la-cogs'></i> Iiko столы
                </a>
            </li>
        </ul>
    </li>

    <li class='nav-item'>
        <a class='nav-link text-reserved' style="color: #57a283 !important;" href='{{ backpack_url('telegram') }}'>
            <img src="/img/logo/telegram.png" class="reserved-icon" width="24" height="24"> Телеграм
        </a>
    </li>
@endif


