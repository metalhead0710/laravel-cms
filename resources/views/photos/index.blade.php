@extends('layouts.frontend.default')
@section('title', 'Фото')
@section('Stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/pages/photos/list.css') }}">
@endsection
@section('content')
<div id="photos">
    <div class="container">
        <h1 class="text-center">Наші фото</h1>
        @foreach($photocats as $photocat)
        <div class="col-sm-4 photocat-item">
            <div class="overlay">
                <a href="{{ route('photos.view', ['slug' => $photocat->slug]) }}" class="">
                    <div class="caption">
                        <h4 class="category-name">{{ $photocat->name }}</h4>
                    </div>
                    @if ($photocat->picture != '')
                        <img src="{{ asset($photocat->thumbUrl()) }}" alt="..." class=""> </a>
                    @else
                        <img src="http://www.placehold.it/350x250?text=:(" alt="..." class=""> </a>
                    @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop
@section('Scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.photocat-item').animate({
            opacity: 1
        } , 1500);
        $("[rel='tooltip']").tooltip();
        $('.overlay').hover(
            function(){
                $(this).find('.caption').slideUp(250);
            },
            function(){
                $(this).find('.caption').slideDown(250);
            }
        );
    });
</script>
@endsection