@extends('layouts.auth')
@section('title', 'Авторизація')
@section('StyleSheets')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/auth.css') }}"/>
@endsection

@section('content')
    <div class="content-form">
        <form class="form-vertical" role="form" method="post" action="{{ route('auth.login') }}">
            <h3 class="form-title">
                Авторизація
            </h3>
            @include('layouts._partials.feedback')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">
                <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-user"></i>
				</span>
                    <input class="form-control" id="username" name="username" placeholder="Логін" type="text"
                           value="{{ Request::old('username') }}">
                </div>
                @if($errors->has('username'))
                    <span class="help-block">{{$errors->first('username')}}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : ''}}">
                <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span>
                    <input class="form-control" id="password" name="password" placeholder="Пароль" type="password" value="">
                </div>
                @if($errors->has('password'))
                    <span class="help-block">{{$errors->first('password')}}</span>
                @endif
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Запам'ятати мене
                </label>
            </div>
            <div class="form-group">
                <a href="{{ route('auth.checkEmail') }}" class="btn btn-link link">Забув пароль, лох?</a>

                <button type="submit" class="btn btn-primary pull-right">Увійти</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
@stop