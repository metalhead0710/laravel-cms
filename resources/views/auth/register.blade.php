@extends('layouts.auth')
@section('title', 'Реєстрація')
@section('StyleSheets')
	<link rel="stylesheet" href="{{ URL::asset('assets/css/auth.css') }}" />
@endsection

@section('content')
<div class="content-form">
    <form class="form-vertical" role="form" method="post" action="{{ url('/auth/register') }}">
    	<h3 class="form-title">
		    Зареєструватися
		</h3>
		@include('layouts._partials.feedback')
		<input type="hidden" name="_token" value="{{ Session::token() }}">
        <div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">			
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-user"></i>
				</span>
				<input class="form-control" id="username" name="username" placeholder="Логін" type="text" value="{{ Request::old('username') }}">
			</div>
			@if($errors->has('username'))
				<span class="help-block">{{$errors->first('username')}}</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">			
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-envelope-o"></i>
				</span>
				<input class="form-control" id="Email" name="email" placeholder="Email" type="text" value="{{ Request::old('email') }}">
			</div>
			@if($errors->has('email'))
				<span class="help-block">{{$errors->first('email')}}</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('lastName') ? ' has-error' : ''}}">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-address-book-o"></i>
				</span>
				<input class="form-control" id="lastName" name="lastName" placeholder="Прізвище" type="text" value="{{ Request::old('lastName') }}">
			</div>
			@if($errors->has('lastName'))
				<span class="help-block">{{$errors->first('lastName')}}</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('firstName') ? ' has-error' : ''}}">			
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-address-book"></i>
				</span>
				<input class="form-control" id="firstName" name="firstName" placeholder="Ім'я" type="text" value="{{ Request::old('firstName') }}">
			</div>
			@if($errors->has('firstName'))
				<span class="help-block">{{$errors->first('firstName')}}</span>
			@endif
		</div>
		<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">			
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
		<div class="form-group{{ $errors->has('password_repeat') ? ' has-error' : ''}}">			
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span>
				<input class="form-control" id="password_repeat" name="password_repeat" placeholder="Повторіть пароль" type="password" value="">
			</div>
			@if($errors->has('password_repeat'))
				<span class="help-block">{{$errors->first('password_repeat')}}</span>
			@endif
		</div>
		<div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Зареєструватися</button>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
@stop