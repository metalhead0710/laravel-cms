@extends('layouts.frontend.default')
@section('title', 'Про нас')
@section('Stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/miniAudioPlayer/css/jquery.mb.miniAudioPlayer1.css') }}" />
@endsection
@section('content')
<div id="about" class="container" style="display:none;">
    <h1 class="text-center">Про нас</h1>
    <div class="about pd">
        <p class="text-center">До колективу продюсерського центру МіК входить велика кількість професіоналів та спеціалістів, які допоможуть Вам розкрити та розвинути Ваші таланти! МіК – розширює можливості!</p>
        <div class="row">
            @foreach($people as $person)
            @if($people->count() %4 == 0)
            <div class="col-md-3 col-sm-3 col-xs-12 mg-bt-60">
            @else
            <div class="col-md-4 col-sm-4 col-xs-12 mg-bt-60">
            @endif
                <img class="img-responsive team-image" src="{{ asset($person->thumbUrl) }}"/>
                <div class="team-desc">
                    <h3 class="text-center">{{ $person->name() }}</h3>
                    <h4 class="text-center"> {{ $person->position }} </h4>
                    {!! $person->info !!}
                </div>
                <div class="team-socials text-center">
                    @if(!empty($person->vk))
                    <a href="{{ $person->vk }}" class="socials">
                        <i class="fa fa-vk"></i>
                    </a>
                    @endif
                    @if (!empty($person->facebook))
                    <a href="{{ $person->facebook }}" class="socials">
                        <i class="fa fa-facebook"></i>
                    </a>
                    @endif
                    @if (!empty($person->skype))
                    <a href="tel:{{ $person->skype }}" class="socials">
                        <i class="fa fa-skype"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if ($works->count() != 0)
    <h1 class="text-center">Наші роботи</h1>
    <div class="works-container">
        @foreach ($works as $work)
        <div class="work-item">
            <h4 class="title">{{ $work->title}}</h4>
            <div class="mg-10-px">
                @if($work->typeId === 100)
                <a class='audio' data-toggle='tooltip' title="{{ $work->author .' - '. $work->songname}}" href="{{ asset($work->songUrl) }}">{{ $work->author .' - '. $work->songname}}</a>
                @elseif($work->typeId === 200)
                <iframe  src="https://www.youtube.com/embed/{{ $work->video }}" frameborder="0" allowfullscreen></iframe>
                @endif
            </div>
            <div class="newtext"> {!! $work->text !!}</div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@stop
@section('Scripts')
<script type="text/javascript" src="{{ asset('assets/plugins/miniAudioPlayer/js/jquery.mb.miniAudioPlayer.js') }}" ></script>
<script>
    $(document).ready(function() {
        $('#about').slideDown(1000);
        if(document.documentElement.clientWidth > 1200) {
            var maxHeight = Math.max.apply(null, $(".team-desc").map(function ()
            {
                return $(this).height();
            }).get());
            console.log(maxHeight);
            $('.team-desc').css('height', maxHeight + 50);
        }
        var player = $(".audio").mb_miniPlayer({
            width: 240,
            inLine: true,
            showControls: true,
            id3: true,
            showRew: false
        });
    });
</script>
@endsection