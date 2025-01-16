<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('backend/assets/images/logo.svg') }}">
        <span class="hidden xl:block text-white text-lg ml-3"> Rubick </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('dashboard.index') }}"
                class="side-menu {{ request()->routeIs('dashboard.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
        @can('Admin CMS')
        <li>
            <a href="{{ route('admin.cms.index') }}"
                class="side-menu {{ request()->routeIs('admin.cms.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title"> CMS </div>
            </a>
        </li>
        @endcan

        @can('Admin Menu')
        <li>
            <a href="{{ route('admin.menu.index') }}"
                class="side-menu {{ request()->routeIs('admin.menu.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title"> Menu </div>
            </a>
        </li>

        @endcan
        <li>
            <a href="javascript:;" class="side-menu {{ request()->is('admin/blog*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title">
                    Blog
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->is('admin/blog*') ? 'side-menu__sub-open' : '' }}">
                @can('Admin Posts')
                    <li>
                        <a href="{{ route('posts.index') }}"
                            class="side-menu {{ request()->routeIs('posts.*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Posts </div>
                        </a>
                    </li>
                @endcan

                @can('Admin Categories')
                    <li>
                        <a href="{{ route('categories.index') }}"
                            class="side-menu {{ request()->routeIs('categories.*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> Categories </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @can('Admin Pages')
            <li>
                <a href="{{ route('pages.index') }}"
                    class="side-menu {{ request()->routeIs('pages.index') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="layout"></i> </div>
                    <div class="side-menu__title"> Pages </div>
                </a>
            </li>
        @endcan

        @can('Admin Users')
            <li>
                <a href="{{ route('users.index') }}"
                    class="side-menu {{ request()->routeIs('users.*') ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title"> Users </div>
                </a>
            </li>
        @endcan
    </ul>
</nav>
