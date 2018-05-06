@extends('layouts.frontend.default')
@section('title', 'Контакти')
@section('content')
<div id="contacts" style="display: none;">
    <div class="container">
        <h1 class="text-center">Контакти</h1>
        <div class="block-content">
            <div class="row">
                <div class="col-md-offset-2 col-md-4">
                    @if (isset($contacts->phone) && $contacts->phone != '')
                    <h4>
                        <span class="fa-stack">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-phone fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                        </span>&nbsp;&nbsp;<a class="contact-link" href="tel:{{ $contacts->phone1 }}">{{ $contacts->phone }}</a>
                    </h4>
                    @endif
                    @if (isset($contacts->phone2) && $contacts->phone2 != '')
                    <h4>
                        <span class="fa-stack">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-mobile fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                        </span>&nbsp;&nbsp;<a class="contact-link" href="tel:{{ $contacts->phone2 }}">{{ $contacts->phone2 }}</a>
                    </h4>
                    @endif
                    @if (isset($contacts->email) && $contacts->email != '')
                    <h4>
                        <span class="fa-stack">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-envelope fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                        </span>&nbsp;&nbsp;<a class="contact-link" href="mailto:{{ $contacts->email }}">{{ $contacts->email }}</a>
                    </h4>
                    @endif
                    @if ($contacts->vk != '' || $contacts->facebook != '' || $contacts->youtube != '')
                    <h3>Ми у соціальних мережах</h3>

                    <p class="soc" style="font-size:18px;">
                        @if(isset($contacts->vk) && $contacts->vk != '')
                        <a href="{{ $contacts->vk }}">
                            <span class="fa-stack">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-vk fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                            </span>
                        </a>
                        @endif
                        @if(isset($contacts->facebook) && $contacts->facebook != '')
                        <a href="{{ $contacts->facebook }}">
                            <span class="fa-stack">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-facebook fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                            </span>
                        </a>
                        @endif
                        @if(isset($contacts->youtube) && $contacts->youtube != '')
                        <a href="{{ $contacts->youtube }}">
                            <span class="fa-stack">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-youtube-play fa-stack-1x fa-inverse faa-wrench animated-hover"></i>
                            </span>
                        </a>
                        @endif
                    </p>
                    @endif

                </div>
                <div class="col-md-4">
                    @include('layouts._partials.feedback')
                    <form id="contact-form" method="post">
                        <div class="form-group{{ $errors->has('sendname') ? ' has-error' : ''}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                            <input class="form-control" name="sendname" placeholder="Вашe ім'я" type="text" value="{{ Request::old('sendname') }}">
                            @if($errors->has('sendname'))
                            <span class="help-block">{{$errors->first('sendname')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                            <input class="form-control" name="email" placeholder="Ваш Email" class="email" type="text" value="{{ Request::old('email') }}">
                            @if($errors->has('email'))
                            <span class="help-block">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                            <textarea class="form-control" cols="20" class="content" data-val="true" name="content" placeholder="Текст повідомлення" rows="5">{{ Request::old('content') }}</textarea>
                            @if($errors->has('content'))
                            <span class="help-block">{{$errors->first('content')}}</span>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn">
                                Відправити
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#contacts').show(1000);
    });
</script>
@endsection
