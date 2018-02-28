<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('admin.home') }}">
                    <i class="fa fa-dashboard fa-fw"></i>
                    Статистика
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news') }}">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Новини</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.people') }}">
                    <i class="fa fa-users"></i>
                    <span>Команда</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.photos') }}">
                    <i class="fa fa-image"></i>
                    <span>Фото</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.works') }}">
                    <i class="fa fa-bullhorn"></i>
                    <span>Роботи</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.services') }}">
                    <i class="fa fa-shopping-basket"></i>
                    <span>Послуги</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contacts.index') }}">
                    <i class="fa fa-link"></i>
                    <span>Контакти</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.messages') }}">
                    <i class="fa fa-envelope-o"></i>
                    <span>Повідомлення</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}">
                    <i class="fa fa-gear"></i>
                    <span>Налаштування</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>