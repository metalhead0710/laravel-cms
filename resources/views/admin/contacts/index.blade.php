@extends('layouts.backend.default')
@section('title', 'Контакти')
@section('Stylesheets')
<style>
    .input-group {
        width: 100%;
    }
    .input-group-addon:first-child {
        width: 40px;
    }
</style>
@endsection
@section('content')
<section class="content-header">
	<div class="page-header">
		<h1>Контакти
			<small>тут можна змінити контакти</small>
		</h1>
	</div>
</section>
<section class="content">
	<div class="row">
		@include('layouts._partials.feedback')
        <form method="post" class="form form-horizontal">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                <label for="Email" class="control-label col-md-2">Email</label>
                <div class="col-md-10">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-envelope-o"></i>
                    </span>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="form-control" id="Email" name="email" placeholder="Email" type="email" value="{{ isset($contact->email) ? $contact->email : '' }}">
                    </div>
                </div>
                @if($errors->has('email'))
                <span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : ''}}">
                <label for="phone" class="control-label col-md-2">Телефон</label>
                <div class="col-md-10">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-phone"></i>
                    </span>
                        <input class="form-control" id="phone" name="phone" placeholder="Телефон" data-inputmask='"mask": "(999) 999-9999"' data-mask type="text" value="{{ isset($contact->phone) ? $contact->phone : '' }}">
                    </div>
                </div>
                @if($errors->has('phone'))
                <span class="help-block">{{$errors->first('phone')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('phone2') ? ' has-error' : ''}}">
                <label for="phone2" class="control-label col-md-2">Ще один телефон</label>
                <div class="col-md-10">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-mobile"></i>
                    </span>
                        <input class="form-control" id="phone2" name="phone2" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="Телефон мобільний" type="text" value="{{ isset($contact->phone2) ? $contact->phone2 : '' }}">
                    </div>
                </div>
                @if($errors->has('phone2'))
                <span class="help-block">{{$errors->first('phone2')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('vk') ? ' has-error' : ''}}">
                <label for="vk" class="control-label col-md-2">Посилання на сторінку ВК</label>
                <div class="col-md-10">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-vk"></i>
                    </span>
                        <input class="form-control" id="vk" name="vk" placeholder="vk" type="text" value="{{ isset($contact->vk) ? $contact->vk : ''}}">
                    </div>
                </div>
                @if($errors->has('vk'))
                <span class="help-block">{{$errors->first('vk')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('facebook') ? ' has-error' : ''}}">
                <label for="vk" class="control-label col-md-2">Посилання на сторінку Facebook</label>
                <div class="col-md-10">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-facebook"></i>
                    </span>
                        <input class="form-control" id="facebook" name="facebook" placeholder="facebook" type="text" value="{{ isset($contact->facebook) ? $contact->facebook : ''}}">
                    </div>
                </div>
                @if($errors->has('facebook'))
                <span class="help-block">{{$errors->first('facebook')}}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('youtube') ? ' has-error' : ''}}">
                <label for="youtube" class="control-label col-md-2">Посилання на канал YouTube</label>
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-youtube-play"></i>
                        </span>
                        <input class="form-control" id="youtube" name="youtube" placeholder="youtube" type="text" value="{{ isset($contact->youtube) ? $contact->youtube : ''}}">
                    </div>
                </div>
                @if($errors->has('youtube'))
                <span class="help-block">{{$errors->first('youtube')}}</span>
                @endif
            </div>
            <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
                    <button type="submit" name="submit" class="btn btn-primary">
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
	<script src="{{ URL::asset('assets/components/input-mask/jquery.inputmask.js') }}"></script>
	<script src="{{ URL::asset('assets/components/input-mask/jquery.inputmask.extensions.js') }}"></script>
	<script>
		$('[data-mask]').inputmask()
	</script>

@endsection