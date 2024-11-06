<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('backend/dist/images/logo.svg') }}">
        <span class="hidden xl:block text-white text-lg ml-3"> Rubick </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="side-menu {{ request()->is('dashboard') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="javascript:;" class="side-menu {{ request()->is('blogs*') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="edit"></i> </div>
                <div class="side-menu__title">
                    Posts
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->is('blogs*') ? 'side-menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('post.index') }}" class="side-menu {{ request()->is('blogs/post*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> All Post </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.index') }}" class="side-menu {{ request()->is('blogs/category*') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Categories </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
