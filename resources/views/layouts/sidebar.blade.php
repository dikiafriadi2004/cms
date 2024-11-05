<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="side-menu {{ request()->routeIs('dashboard') ? 'side-menu--active' : '' }} ">
                <div class="side-menu__icon"> <i data-lucide="Home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs(['category.*', 'post.*']) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="edit"></i> </div>
                <div class="side-menu__title">
                    Posts 
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs(['category.*', 'post.*']) ? 'side-menu__sub-open' : '' }}">
                <li>
                    <a href="side-menu-light-crud-data-list.html" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> All Post </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.index') }}" class="side-menu {{ request()->is('category') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Categories </div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>