@extends('layouts.backend.default')
@section('title', 'Редагувати новину')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Редагувати новину
            <small class="xs-hidden">ви редагуєте <strong>{{$new->title}}</strong></small>
        </h1>
    </div>
</section>
<section>
    <form action="{{ route('admin.news.postUpdate', ['id' => $new->id])}}" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : ''}}">
            <label for="title" class="control-label col-md-2">Заголовок</label>
            <div class="col-md-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $new->title }}">
                @if($errors->has('title'))
                <span class="help-block">{{$errors->first('title')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                @if(!empty($new->thumbUrl))
                    <img src="{{ asset($new->thumbUrl) }}">
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('image') ? ' has-error' : ''}}">
            <label for="file" class="control-label col-md-2">Картинка</label>
            <div class="col-md-10">
                <input type="file" name="image" title="Вибрати файл">
                @if($errors->has('image'))
                <span class="help-block">{{$errors->first('image')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('text') ? ' has-error' : ''}}">
            <label for="text" class="control-label col-md-2">Текст</label>
            <div class="col-md-10">
                <textarea type="decimal" class="form-control" id="text" name="text" placeholder="Напишіть щось...">{{ $new->text }}</textarea>
                @if($errors->has('text'))
                <span class="help-block">{{$errors->first('text')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-primary save">
                    <i class="fa fa-check"></i>
                    Зберегти
                </button>
                <a href="{{route('admin.news')}}" class="btn btn-default">
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
<script src="{{ asset('assets/components/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('input[type=file]').filestyle({
            text : 'Виберіть файл',
            badge: true,
            buttonBefore : true,
            btnClass : 'btn-primary',
            htmlIcon : '<i class="fa fa-file-image-o"></i> '
        });
        CKEDITOR.replace('text');
    })
</script>
@endsection