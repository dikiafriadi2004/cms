@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div
            class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                Sign In
            </h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account.
                    Manage all your e-commerce accounts in one place</div>
                <div class="intro-x mt-8">
                    <input type="text" name="email"
                        class="intro-x login__input form-control py-3 px-4 block @error('email') is-invalid @enderror"
                        placeholder="Email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="password" name="password"
                        class="intro-x login__input form-control py-3 px-4 block mt-4 @error('password') is-invalid @enderror"
                        placeholder="Password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                    </div>
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
