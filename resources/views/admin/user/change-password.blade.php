@extends('layouts.backend.default')
@section('title', 'Бунд!!!')
@section('content')
    <section class="content-header">
        <div class="page-header">
            <h1>Пароль на домінацію
                <small>тут можна змінити пароль для домінації</small>
            </h1>
        </div>
    </section>
    <section class="content">
        <div class="row">
            @include('layouts._partials.feedback')
            <form method="post" class="form form-horizontal">
                <div class="form-group{{ $errors->has('oldPassword') ? ' has-error' : ''}}">
                    <label for="oldPassword" class="control-label col-md-2">Старий пароль</label>
                    <div class="col-md-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword">
                        @if($errors->has('oldPassword'))
                            <span class="help-block">{{$errors->first('oldPassword')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : ''}}">
                    <label for="newPassword" class="control-label col-md-2">Новий пароль</label>
                    <div class="col-md-4">
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        @if($errors->has('newPassword'))
                            <span class="help-block">{{$errors->first('newPassword')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('newPasswordRepeat') ? ' has-error' : ''}}">
                    <label for="newPasswordRepeat" class="control-label col-md-2">Повторіть пароль</label>
                    <div class="col-md-4">
                        <input type="password" class="form-control" id="newPasswordRepeat" name="newPasswordRepeat">
                        @if($errors->has('newPasswordRepeat'))
                            <span class="help-block">{{$errors->first('newPasswordRepeat')}}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary save">
                            <i class="fa fa-check"></i>
                            Зберегти
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop