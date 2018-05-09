@extends('layouts.backend.default')
@section('title', 'Редагувати каталог')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Каталог
            <small class="xs-hidden">Ви редагуєте каталог <strong>{{ $photocat->name }} </strong></small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section>
    <form action="{{ route('admin.photos.postUpdate', ['slug' => $photocat->slug]) }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
            <label for="name" class="control-label col-md-2">Назва</label>
            <div class="col-md-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control" id="name" name="name" value="{{  $photocat->name }}">
                @if($errors->has('name'))
                <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <img src="{{ asset($photocat->thumb)}}" alt=""/>
            </div>
        </div>
        <div class="form-group{{ $errors->has('photo') ? ' has-error' : ''}}">
            <label for="file" class="control-label col-md-2">Фото</label>
            <div class="col-md-10">
                <input type="file" name="photo" title="Вибрати файл">
                @if($errors->has('photo'))
                <span class="help-block">{{$errors->first('photo')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-primary save">
                    <i class="fa fa-check"></i>
                    Зберегти
                </button>
                <a href="{{route('admin.photos')}}" class="btn btn-default">
                    <i class="fa fa-long-arrow-left"></i>
                    Назад
                </a>
            </div>
        </div>
    </form>
</section>
@stop
@section('Scripts')
<script src="{{ asset('assets/components/b-file-input/bootstrap-filestyle.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/admin/common-index-functions/list.js') }}"></script>
<script type="text/javascript">
    App.Page.CommonIndexFunctions();
</script>
@endsection