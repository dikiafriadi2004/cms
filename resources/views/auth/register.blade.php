@extends('auth.layouts.app')

@section('title')
    Register
@endsection

@section('content')
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div
            class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                Sign Up
            </h2>
            <div class="intro-x mt-2 text-slate-400 dark:text-slate-400 xl:hidden text-center">A few more clicks to sign in
                to your account. Manage all your e-commerce accounts in one place</div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="intro-x mt-8">
                    <input type="text" name="name"
                        class="intro-x login__input form-control py-3 px-4 block mt-4 @error('name') is-invalid @enderror"
                        placeholder="Name" required autofocus autocomplete="name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="email" name="email"
                        class="intro-x login__input form-control py-3 px-4 block mt-4 @error('email') is-invalid @enderror"
                        placeholder="Email" required autofocus autocomplete="email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="password" name="password"
                        class="intro-x login__input form-control py-3 px-4 block mt-4 @error('password') is-invalid @enderror"
                        placeholder="Password" required autofocus autocomplete="password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="password" name="password_confirmation"
                        class="intro-x login__input form-control py-3 px-4 block mt-4 @error('password_confirmation') is-invalid @enderror"
                        placeholder="Password Confirmation" required autofocus autocomplete="password_confirmation">
                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top">Register</button>
                </div>
            </form>
        </div>
    </div>
@endsection
