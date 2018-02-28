@extends('layouts.frontend.default')
@section('title', 'Новини')
@section('content')
<div id="news" style="display: none;">
    <div class="container">
        <h1 class="text-center">Новини</h1>
        <div class="newstiles">
            @if($news->count() == 0)
                <h4 class="text-center text-muted">
                    Немає новин, поки що...
                </h4>
            @endif
            @foreach($news as $new)
            <div class="post">
                <h4 class="title text-left">{{ $new->title }}</h4>
                <div class="mg-10-px">
                    <span class="date"> Опубліковано {{ $new->created_at->format( 'j.m.Y' )}}</span> o <span class= "time">{{ $new->created_at->format ( 'H:i' )}}</span>
                </div>
                @if($new->url() != '')
				<img class="img-responsive post-img mg-10-px" src="{{ asset($new->url()) }}" />
                @endif
                <div class="newstext">{!! $new->text !!}</div>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            {{ $news->render()}}
        </div>
    </div>
</div>
@stop
@section('Scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#news').slideDown(1000);
    });
</script>
@endsection