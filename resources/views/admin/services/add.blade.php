@extends('layouts.backend.default')
@section('title', 'Додати послугу')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Послуги
            <small class="xs-hidden">тут можна додати послугу</small>
        </h1>
    </div>
</section>
<section>
    <form action="{{ route('admin.services.edit') }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
            <label for="name" class="control-label col-md-2">Назва</label>
            <div class="col-md-10">
                {{ csrf_field() }}
                <input class="form-control" id="name" name="name" placeholder="Назва" value="{{old('name')}}">
                @if($errors->has('name'))
                <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('pic') ? ' has-error' : ''}}">
            <label for="name" class="control-label col-md-2">Картинка</label>
            <div class="col-md-10">
                <input type="file" name="pic" title="Вибрати файл">
                @if($errors->has('pic'))
                <span class="help-block">{{$errors->first('pic')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('customCss') ? ' has-error' : ''}}">
            <label for="customCss" class="control-label col-md-2">CSS</label>
            <div class="col-md-10">
                <textarea class="form-control" id="customCss" name="customCss" placeholder="Стилізуй тут щось, якщо вмієш...">{{old('customCss')}}</textarea>
                @if($errors->has('customCss'))
                <span class="help-block">{{$errors->first('customCss')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('customJs') ? ' has-error' : ''}}">
            <label for="customJs" class="control-label col-md-2">JS</label>
            <div class="col-md-10">
                <textarea class="form-control" id="customJs" name="customJs" placeholder="Заскриптуй тут щось, якщо вмієш...">{{old('customJs')}}</textarea>
                @if($errors->has('customJs'))
                    <span class="help-block">{{$errors->first('customJs')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('content') ? ' has-error' : ''}}">
            <label for="content" class="control-label col-md-2">Сторінка</label>
            <div class="col-md-10">
                <textarea class="form-control" id="content" name="content" placeholder="Тут контент сторінки послуги...">{{old('content')}}</textarea>
                @if($errors->has('content'))
                    <span class="help-block">{{$errors->first('content')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-primary save">
                    <i class="fa fa-check"></i>
                    Зберегти
                </button>
                <a href="{{route('admin.services')}}" class="btn btn-default">
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
<script src="{{ asset('assets/plugins/editarea/edit_area/edit_area_full.js') }}"></script>
<script src="{{ asset('assets/components/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/pages/admin/services/edit.js') }}"></script>
<script type="text/javascript">
  $(function() {
    App.Page.Service();
  });
</script>
@endsection