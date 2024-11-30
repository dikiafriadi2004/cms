<nav class="navbar navbar-expand-lg bg-white">
    <div class="container main-navbar">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('frontend/assets/images/logo.png') }}" class="logo" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('home.index')) ? 'active' : '' }}" href="{{ route('home.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ (request()->routeIs('blog.*')) ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tentang Kami</a>
                </li>
            </ul>
        </div>
    </div>
</nav>