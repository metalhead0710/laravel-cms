@extends('layouts.backend.default')
@section('title', 'Редагувати людину')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Команда
            <small class="xs-hidden">тут можна додати людину</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section>
<form action="" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : ''}}">
        <label for="first_name" class="control-label col-md-2">Ім'я</label>
        <div class="col-md-10">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}">
            @if($errors->has('first_name'))
            <span class="help-block">{{$errors->first('first_name')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : ''}}">
        <label for="last_name" class="control-label col-md-2">Прізвище</label>
        <div class="col-md-10">
            <input class="form-control" id="last_name" name="last_name" value="{{old('last_name')}}">
            @if($errors->has('last_name'))
            <span class="help-block">{{$errors->first('last_name')}}</span>
            @endif
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
    <div class="form-group{{ $errors->has('position') ? ' has-error' : ''}}">
        <label for="position" class="control-label col-md-2">Посада</label>
        <div class="col-md-10">
            <input class="form-control" id="position" name="position" value="{{old('position')}}">
            @if($errors->has('position'))
            <span class="help-block">{{$errors->first('position')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('info') ? ' has-error' : ''}}">
        <label for="info" class="control-label col-md-2">Текст</label>
        <div class="col-md-10">
            <textarea class="form-control" id="info" name="info">{{old('info')}}</textarea>
            @if($errors->has('info'))
            <span class="help-block">{{$errors->first('info')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('vk') ? ' has-error' : ''}}">
        <label for="vk" class="control-label col-md-2">Vk</label>
        <div class="col-md-10">
            <input class="form-control" id="vk" name="vk" value="{{old('vk')}}">
            @if($errors->has('vk'))
            <span class="help-block">{{$errors->first('vk')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('facebook') ? ' has-error' : ''}}">
        <label for="position" class="control-label col-md-2">Facebook</label>
        <div class="col-md-10">
            <input class="form-control" id="facebook" name="facebook" value="{{old('facebook')}}">
            @if($errors->has('facebook'))
            <span class="help-block">{{$errors->first('facebook')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('skype') ? ' has-error' : ''}}">
        <label for="skype" class="control-label col-md-2">Skype</label>
        <div class="col-md-10">
            <input class="form-control" id="skype" name="skype" value="{{old('skype')}}">
            @if($errors->has('skype'))
            <span class="help-block">{{$errors->first('skype')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('twitter') ? ' has-error' : ''}}">
        <label for="twitter" class="control-label col-md-2">Twitter</label>
        <div class="col-md-10">
            <input class="form-control" id="twitter" name="twitter" value="{{old('twitter')}}">
            @if($errors->has('twitter'))
            <span class="help-block">{{$errors->first('twitter')}}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <button type="submit" name="submit" class="btn btn-primary save">
                <i class="fa fa-check"></i>
                Зберегти
            </button>
            <a href="{{route('admin.people')}}" class="btn btn-default">
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
        CKEDITOR.replace('info');
    })
</script>
@endsection