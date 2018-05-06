@extends('layouts.backend.default')
@section('title', 'Редагувати послугу')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Послуги
            <small class="xs-hidden">ви редагуєте <b>{{ $service->name }}</b></small>
        </h1>
    </div>
</section>
<section>
    <form action="{{ route('admin.services.edit', ['id' => $service->id]) }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
            <label for="name" class="control-label col-md-2">Назва</label>
            <div class="col-md-10">
                {{ csrf_field() }}
                <input class="form-control" id="name" name="name" placeholder="Назва" value="{{ $service->name }}">
                @if($errors->has('name'))
                <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <img src="{{ asset($service->pic) }}" />
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
        <div class="form-group{{ $errors->has('description') ? ' has-error' : ''}}">
            <label for="description" class="control-label col-md-2">Текст</label>
            <div class="col-md-10">
                <textarea class="form-control" id="description" name="description" placeholder="Напишіть щось...">{{ $service->description }}</textarea>
                @if($errors->has('description'))
                <span class="help-block">{{$errors->first('description')}}</span>
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
<script type="text/javascript">
    $(function() {
        $('input[type=file]').filestyle({
            text : 'Виберіть файл',
            badge: true,
            buttonBefore : true,
            btnClass : 'btn-primary',
            htmlIcon : '<i class="fa fa-file-image-o"></i> '
        });
    })
</script>
@endsection