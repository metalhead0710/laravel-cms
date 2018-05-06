@extends('layouts.backend.default')
@section('title', 'Налаштування')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Налаштування
            <small>тут можна змінити налаштування</small>
        </h1>
    </div>
</section>
<section class="content">
    <div class="row">
        @include('layouts._partials.feedback')
        <form method="post" class="form form-horizontal" enctype="multipart/form-data">
            <div class="form-group{{ $errors->has('mainTitle') ? ' has-error' : ''}}">
                <label for="mainTitle" class="control-label col-md-2">Заголовок сайту</label>
                <div class="col-md-10">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input class="form-control" id="mainTitle" name="mainTitle" value="{{ isset($settings->mainTitle) ? $settings->mainTitle : old('mainTitle') }}">
                    @if($errors->has('mainTitle'))
                    <span class="help-block">{{$errors->first('mainTitle')}}</span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('subTitle') ? ' has-error' : ''}}">
                <label for="subTitle" class="control-label col-md-2">Слоган</label>
                <div class="col-md-10">
                    <input class="form-control" id="subTitle" name="subTitle" value="{{ isset($settings->subTitle) ? $settings->subTitle : old('subTitle') }}">
                    @if($errors->has('subTitle'))
                    <span class="help-block">{{$errors->first('subTitle')}}</span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : ''}}">
                <label for="meta_description" class="control-label col-md-2">Опис сайту</label>
                <div class="col-md-10">
                    <input class="form-control" id="meta_description" name="meta_description" value="{{ isset($settings->meta_description) ? $settings->meta_description : old('meta_description') }}">
                    @if($errors->has('meta_description'))
                    <span class="help-block">{{$errors->first('meta_description')}}</span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : ''}}">
                <label for="meta_keywords" class="control-label col-md-2">Ключові слова <small>пишіть через кому</small></label>
                <div class="col-md-10">
                    <input class="form-control" id="meta_keywords" name="meta_keywords" value="{{ isset($settings->meta_keywords) ? $settings->meta_keywords : old('meta_keywords') }}">
                    @if($errors->has('meta_keywords'))
                    <span class="help-block">{{$errors->first('meta_keywords')}}</span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('siteLogo') ? ' has-error' : ''}}">
                <label for="file" class="control-label col-md-2">Лого</label>
                <div class="col-md-10">
                    <input type="file" name="siteLogo" title="Вибрати файл">
                    @if($errors->has('siteLogo'))
                        <span class="help-block">{{$errors->first('siteLogo')}}</span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
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
@section('Scripts')

@endsection