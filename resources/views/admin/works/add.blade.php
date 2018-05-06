@extends('layouts.backend.default')
@section('title', 'Додати роботу')
@section('Stylesheets')
<style>
    .music, .video{
        display: none;
    }
</style>
@endsection
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Роботи
            <small class="xs-hidden">тут можна додати роботу</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section>
    <form action="" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : ''}}">
            <label for="title" class="control-label col-md-2">Заголовок</label>
            <div class="col-md-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control" id="title" name="title" placeholder="Заголовок" value="{{old('title')}}">
                @if($errors->has('title'))
                <span class="help-block">{{$errors->first('title')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('typeId') ? ' has-error' : ''}}">
            <label for="typeId" class="control-label col-md-2">Тип</label>
            <div class="col-md-10">
                <select class="form-control" id="typeId" name="typeId" value="{{old('typeId')}}">
                    <option value="" selected disabled hidden>Виберіть тип</option>
                    <option value="100" {{ old('typeId') == 100 ? 'selected' : null}}>Музика</option>
                    <option value="200" {{ old('typeId') == 200 ? 'selected' : null }}>Відео</option>
                </select>
                @if($errors->has('typeId'))
                <span class="help-block">{{$errors->first('typeId')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('author') ? ' has-error' : ''}}">
            <label for="author" class="control-label col-md-2">Автор</label>
            <div class="col-md-10">
                <input class="form-control" id="author" name="author"  value="{{old('author')}}">
                @if($errors->has('author'))
                <span class="help-block">{{$errors->first('author')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('songname') ? ' has-error' : ''}}">
            <label for="songname" class="control-label col-md-2">Назва твору</label>
            <div class="col-md-10">
                <input class="form-control" id="songname" name="songname" value="{{old('songname')}}">
                @if($errors->has('songname'))
                <span class="help-block">{{$errors->first('songname')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group music{{ $errors->has('song') ? ' has-error' : ''}}">
            <label for="song" class="control-label col-md-2">Файл</label>
            <div class="col-md-10">
                <input type="file" name="song" title="Вибрати файл">
                @if($errors->has('song'))
                <span class="help-block">{{$errors->first('song')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group video{{ $errors->has('video') ? ' has-error' : ''}}">
            <label for="video" class="control-label col-md-2">Ід відео Youtube</label>
            <div class="col-md-10">
                <img src="{{ asset('assets/img/yt.png') }}">
                <input class="form-control" id="video" name="video" placeholder="Введіть ідентифікатор як показано на картинці" value="{{old('video')}}">
                @if($errors->has('video'))
                <span class="help-block">{{$errors->first('video')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('text') ? ' has-error' : ''}}">
            <label for="text" class="control-label col-md-2">Текст</label>
            <div class="col-md-10">
                <textarea class="form-control" id="text" name="text" placeholder="Напишіть щось...">{{old('text')}}</textarea>
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
                <a href="{{route('admin.works')}}" class="btn btn-default">
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
        var check = function() {
            var type = $('#typeId').val();
            if(type == 100)
            {
                $('.video').slideUp(300);
                $('.music').slideDown(300);
            }
            else if (type == 200)
            {
                $('.music').slideUp(300);
                $('.video').slideDown(300);
            }
        }
        check();
        $('#typeId').change(function () {
            check();
        });

    })
</script>
@endsection