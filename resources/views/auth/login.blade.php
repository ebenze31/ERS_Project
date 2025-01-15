@extends('layouts.theme')

@section('content')
<div class="container mx-auto">

    <div class="w-100 h-[calc(100dvh-96px)] mt-[48px] flex justify-center items-center h-100">

        <div class="block max-w-[528px] shadow-lg w-full p-6 bg-white border border-gray-200 rounded-[12px] shadow  white:bg-gray-800 white:border-gray-700 mx-3">
            <p class="text-[47px] font-extrabold header-text">เข้าสู่ระบบ</p>
            <form method="POST" action="{{ route('login') }}" class="mt-2">
                @csrf

                <div class="form-group row">
                    
                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __(' รหัสผู้ใช้') }}</label>
                    <input type="username" id="username" class=" bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="username" required autocomplete="username" autofocus/>
                </div>
                <div class="form-group row mt-4">
                    
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่าน') }}</label>
                    <input type="password" id="password" class=" bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 " name="password" required autocomplete="password" autofocus/>
                </div>

         
                <div class="flex w-100 my-2 mt-5">
                    <button type="submit" class="btn rounded-full bg-slate-950 w-full text-white p-2 button ">เข้าสู่ระบบ</button>
                </div>
            </form>

        </div>
    </div>

    <!-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection