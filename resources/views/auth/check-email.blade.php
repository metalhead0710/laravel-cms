@extends('layouts.auth')
@section('title', 'Відновлення доступу')
@section('StyleSheets')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/auth.css') }}"/>
@endsection

@section('content')
    <div class="content-form">
        <form class="form-vertical" role="form" method="post">
            <h3 class="form-title">
                Відновлення доступу
            </h3>
            @include('layouts._partials.feedback')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-envelope"></i>
				</span>
                    <input class="form-control" id="email" name="email" placeholder="E-mail" type="text"
                           value="{{ Request::old('email') }}">
                </div>
                @if($errors->has('email'))
                    <span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Скинути пароль</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
@stop