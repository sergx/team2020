@extends('layouts.app')

@section('content')
<div class="container">
  @auth
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          Ваш уровень доступа — 
          @foreach ($user->roles as $role)
            {{__('common.role_'.$role->name)}}
          @endforeach
        </div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <ul class="list-group">
            @hasanyrole('admin')
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('user.index') }}">{{ __('common.user_title') }}</a>
            </li>
            @endhasanyrole
            @hasanyrole('page_renter|admin')
            <li class="list-group-item d-flex align-items-center">
              <a href="{{route('fastedit.show', $user->id)}}">Редактировать контакты и цены</a>
            </li>
            @endhasanyrole
            @hasanyrole('agent|admin|office_manager')
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('buyer.index') }}" class="mr-auto">{{ __('common.buyer_title') }}</a>
              <a href="{{ route('buyer.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('seller.index') }}" class="mr-auto">{{ __('common.seller_title') }}</a>
              <a href="{{ route('seller.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('materialsklad.index') }}" class="mr-auto">{{ __('common.materialsklad_title') }}</a>
              <a href="{{ route('materialsklad.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('materialrezerv.index') }}" class="mr-auto">{{ __('common.materialrezerv_title') }}</a>
              <a href="{{ route('materialrezerv.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('punktpriem.index') }}" class="mr-auto">{{ __('common.punktpriem_title') }}</a>
              <a href="{{ route('punktpriem.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <a href="{{ route('deal.index') }}" class="mr-auto">{{ __('common.deal_title') }}</a>
              <a href="{{ route('deal.create') }}" class="btn btn-sm btn-primary">+ {{ __('common.create') }}</a>
            </li>
            @endhasanyrole
            @hasanyrole('agent|admin|page_renter|office_manager')
            @else
              Ваша учетная запись ожидает подтверждения
            @endhasanyrole
          </ul>
        </div>
      </div>
    </div>
  </div> 
  @else
  <div class="row">
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Вход</h5>
          <div class="card-text">
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
    </div>

    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Регистрация нового пользователя</h5>
          <div class="card-text">
            <ul>
              <li><a href="{{ route('register') }}">Агент</a></li>
              <li><a href="{{ route('register') }}">Территориальный представитель</a></li>
              <li><a href="{{ route('register') }}">Аналитик торгового дома</a></li>
              <li><a href="{{ route('register') }}">Площадка-партнер (пункт приема)</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endauth
  
{{--
Дашборд / портал
Тут несколько блоков с навигацией - 
[...][...][...][...]
регистрация разных типов пользователей
переход к разным таблицам ( разные - для авторизированных и нет)
Презентация / контент для новых пользователей  
--}}
</div>
@endsection

{{--
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
      html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
      }

      .full-height {
        height: 100vh;
      }

      .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
      }

      .position-ref {
        position: relative;
      }

      .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
      }

      .content {
        text-align: center;
      }

      .title {
        font-size: 84px;
      }

      .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
      }

      .m-b-md {
        margin-bottom: 30px;
      }
    </style>
  </head>
  <body>
    <div class="flex-center position-ref full-height">
      @if (Route::has('login'))
        <div class="top-right links">
          @auth
            <a href="{{ url('/home') }}">Home</a>
          @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
              <a href="{{ route('register') }}">Register</a>
            @endif
          @endauth
        </div>
      @endif

      <div class="content">
        Дашборд / портал
        Тут несколько блоков с навигацией - 
        [...][...][...][...]
        регистрация разных типов пользователей
        переход к разным таблицам ( разные - для авторизированных и нет)
        Презентация / контент для новых пользователей
      </div>
    </div>
  </body>
</html>

--}}
