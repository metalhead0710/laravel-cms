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
            <div class="alert alert-info">
                <button class="close" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                Скидай свій пароль, муділа
            </div>
            <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : ''}}">
                {{ csrf_field() }}
                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Новий пароль">
                @if($errors->has('newPassword'))
                    <span class="help-block">{{$errors->first('newPassword')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('newPasswordRepeat') ? ' has-error' : ''}}">
                <input type="password" class="form-control" id="newPasswordRepeat" name="newPasswordRepeat" placeholder = "Повторіть пароль">
                @if($errors->has('newPasswordRepeat'))
                    <span class="help-block">{{$errors->first('newPasswordRepeat')}}</span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Скинути пароль</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
@stop