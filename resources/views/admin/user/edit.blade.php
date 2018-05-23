@extends('layouts.backend.default')
@section('title', 'Бунд!!!')
@section('content')
    <section class="content-header">
        <div class="page-header">
            <h1>Главний дамінатор
                <small>тут можна змінити домінатора цього розпиздатого сайту</small>
            </h1>
        </div>
    </section>
    <section class="content">
        <div class="row">
            @include('layouts._partials.feedback')
            <form method="post" class="form form-horizontal" enctype="multipart/form-data">
                <div class="form-group{{ $errors->has('firstName') ? ' has-error' : ''}}">
                    <label for="firstName" class="control-label col-md-2">Ім'я</label>
                    <div class="col-md-10">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="form-control" id="firstName" name="firstName" value="{{ isset($user->firstName) ? $user->firstName : old('firstName') }}">
                        @if($errors->has('firstName'))
                            <span class="help-block">{{$errors->first('firstName')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('lastName') ? ' has-error' : ''}}">
                    <label for="lastName" class="control-label col-md-2">Прізвище</label>
                    <div class="col-md-10">
                        <input class="form-control" id="lastName" name="lastName" value="{{ isset($user->lastName) ? $user->lastName : old('lastName') }}">
                        @if($errors->has('lastName'))
                            <span class="help-block">{{$errors->first('lastName')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">
                    <label for="username" class="control-label col-md-2">Логін</label>
                    <div class="col-md-10">
                        <input class="form-control" id="username" name="username" value="{{ isset($user->username) ? $user->username : old('username') }}">
                        @if($errors->has('username'))
                            <span class="help-block">{{$errors->first('username')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                    <label for="email" class="control-label col-md-2">Пошта</label>
                    <div class="col-md-10">
                        <input class="form-control" id="email" name="email" value="{{ isset($user->email) ? $user->email : old('email') }}">
                        @if($errors->has('email'))
                            <span class="help-block">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('photo') ? ' has-error' : ''}}">
                    <label for="file" class="control-label col-md-2">Фото</label>
                    <div class="col-md-10">
                        @if (!empty($user->thumb))
                            <img src="{{ asset($user->thumb) }}" />
                            <input type="checkbox" name="deletePhoto"/>Видалити фотку
                        @endif
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
                    </div>
                </div>
            </form>
        </div>
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