@extends('frontend.layouts.app')

@section('title')
    Beranda
@endsection

@push('css')
@endpush

@section('content')
    <section>
        <div class="header mt-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 copywriting align-self-center">
                        <h1 class="big-header mb-10">
                            Konter Digital, <br>
                            Solusi Segala <br>
                            Kebutuhan <br>
                            Usaha
                        </h1>
                        <p class="primary-copy mb-30">
                            Konter Digital adalah solusi segala kebutuhan Perjalanan
                            usaha Mitra dalam membuka Peluang baru
                        </p>
                        <a href="#" class="btn btn-cta mb-30">
                            <i class="fa-brands fa-google-play"></i>
                            Download Sekarang
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <img src="{{ asset('frontend/assets/images/images1.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section>
        <div class="produk mt-70">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <h3 class="medium-header mb-30">
                            Produk Unggulan
                        </h3>
                    </div>
                </div>
            </div>
            <div class="carousel mb-30">
                <div class="carousel-wrapper">
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_telkomsel.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_xl.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_axis.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_indosat.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_tri.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_dana.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_ovo.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_gopay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_shopeepay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_linkaja.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_telkomsel.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_xl.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_axis.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_indosat.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_tri.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_dana.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_ovo.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_gopay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_shopeepay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_linkaja.png') }}" class="ic-logos" alt="">
                    </div>
                </div>
            </div>
            <div class="carousel-left">
                <div class="carousel-wrapper-left">
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_telkomsel.png') }}" class="ic-logos"
                            alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_xl.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_axis.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_indosat.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_tri.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_dana.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_ovo.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_gopay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_shopeepay.png') }}" class="ic-logos"
                            alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_linkaja.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_telkomsel.png') }}" class="ic-logos"
                            alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_xl.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_axis.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_indosat.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_tri.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_dana.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_ovo.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_gopay.png') }}" class="ic-logos" alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_shopeepay.png') }}" class="ic-logos"
                            alt="">
                    </div>
                    <div class="mr-30">
                        <img src="{{ asset('frontend/assets/images/ic_linkaja.png') }}" class="ic-logos" alt="">
                    </div>
                </div>
            </div>
    </section> --}}

    <section>
        <div class="keunggulan mt-70">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <h3 class="medium-header mb-30">
                            Keunggulan Aplikasi Konter Digital
                        </h3>
                        <p class="primary-copy mb-30">
                            Beberapa Keunggulan Aplikas Konter Digital
                        </p>
                    </div>
                    <div class="row keunggulan-wrapper">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="big-keunggulan-card">
                                        <div class="icon mb-20">
                                            <img src="{{ asset('frontend/assets/images/icon_cs.png') }}" alt="">
                                        </div>
                                        <div class="copy">
                                            <h3 class="small-header mb-10">
                                                Customer Service
                                            </h3>
                                            <p class="primary-copy mb-20">
                                                Siap Melayani anda 24jam
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="big-keunggulan-card">
                                        <div class="icon mb-20">
                                            <img src="{{ asset('frontend/assets/images/icon_mitra.png') }}"
                                                alt="">
                                        </div>
                                        <div class="copy">
                                            <h3 class="small-header mb-10">
                                                Mitra Terdaftar
                                            </h3>
                                            <p class="primary-copy mb-20">
                                                Tersebar di seluruh penjuru Indonesia menggerakkan perekonomian sektor
                                                kecil
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="big-keunggulan-card">
                                        <div class="icon mb-20">
                                            <img src="{{ asset('frontend/assets/images/icon_reward.png') }}"
                                                alt="">
                                        </div>
                                        <div class="copy">
                                            <h3 class="small-header mb-10">
                                                Reward
                                            </h3>
                                            <p class="primary-copy mb-20">
                                                Banyak keuntungan yang anda dapatkan untuk menjadi bagian dari mitra
                                                Konter Digital
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="big-keunggulan-card">
                                        <div class="icon mb-20">
                                            <img src="{{ asset('frontend/assets/images/icon_produk.png') }}"
                                                alt="">
                                        </div>
                                        <div class="copy">
                                            <h3 class="small-header mb-10">
                                                Produk
                                            </h3>
                                            <p class="primary-copy mb-20">
                                                Anda bisa membeli / Menjual kembali, Beberapa Produk, Pulsa, Paket Data,
                                                Paket Tlpn, Voucher
                                                Game, E Money, Token PLN, dll
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="operasional mt-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="{{ asset('frontend/assets/images/illustration.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="col-lg-6 operational-copy">
                                <h3 class="medium-header mb-30">
                                    Operasional dan pengaturan aplikasi
                                    yang mudah dan praktis
                                </h3>
                                <p class="primary-copy mb-30">
                                    1. Registrasi (Download & Install Konter Digital dari Playstore) <br>
                                    2. Login dengan menggunakan nomor hp dan pin kamu <br>
                                    3. Masukan OTP dari Whatsapp yg dikirim oleh Konter Digital <br>
                                    4. Untuk dapat transaksi lakukan Topup deposit <br>
                                    5. Kembangkan jaringan downline jika anda ingin menjadikan Konter Digital
                                    menjadi sebuah aplikasi bisnis yang menguntungkan.
                                </p>
                                <a href="#" class="btn btn-cta">
                                    <i class="fa-brands fa-google-play"></i>
                                    Download Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-70">
            <div class="row col-lg-12">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <h3 class="medium-header mb-30">
                            BLOG
                        </h3>
                    </div>
                </div>
                @foreach ($posts as $post)
                    <div class="col-lg-4 mb-30">
                        <div class="card">
                            <img src="{{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION') . '/' . $post->thumbnail) }}"
                                class="card-img-top" alt="{{ $post->title }}">
                            <div class="card-body">
                                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                    class="card-title-blog">{{ $post->title }}</a>
                                <p class="card-text-blog">{{ $post->description }}</p>
                                <span class="date-blog">{{ $post->created_at->isoFormat('D MMMM Y') }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
