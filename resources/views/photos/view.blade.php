@extends('layouts.frontend.default')
@section('title', $photocat->name)
@section('Stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/pages/photos/view.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/lightbox/simplelightbox.css') }}">
@endsection
@section('content')
<div id="photos">
    <div class="container">
        <h1 class="text-center">{{ $photocat->name }}</h1>
        <div class="photo-container gallery">
            @if($photocat->photos->count() === 0)
            <h4 class="text-center">
                В цьому альбомі немає фотографій. Поки що...
            </h4>
            @endif
            @foreach($photocat->photos as $photo)
                <a class="photo-item" href="{{ asset($photo->photo) }}">
                    <img class="img-responsive" src="{{ asset($photo->thumb) }}" alt="" />
                </a>
            @endforeach
        </div>

        <div class="photo-action text-center">
            <a href="{{ route('photos') }}" class="btn btn-link" >
               <i class="fa fa-long-arrow-left"></i>
               Назад
            </a>
            <a href="#" class="btn btn-default button-more" >
                Показати ще
            </a>
        </div>
        <div id="imgLoad"><i class="fa fa-spinner fa-spin"></i></div>
    </div>
</div>
@stop
@section('Scripts')
<script type="text/javascript" src="{{ asset('assets/plugins/lightbox/simple-lightbox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/photos/view.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var num = 12;
        var count = {{ $count }} - 12;
        checkData(count);
        function checkData(count) {
            if (count <= 0 ){
                $('.button-more').hide();
            }
        }
        $(function() {
            $(".button-more").click(function(e){
                $("#imgLoad").show();
                $.ajax({
                    url: "/photos/loadmore/{{ $photocat->id }}/"+num,
                    type: "get",
                    success: function(data){
                        if(data == 0){
                            $(".button-more").hide();
                            console.log("Більш нема фоток");
                        }else{
                            $(".gallery").append(data);
                            num = num + 12;
                            count = count - 12;
                            checkData(count);
                            $("#imgLoad").hide();
                            $('.photo-item').simpleLightbox();
                        }
                    }
                });
                e.preventDefault();
            });
        });
    });
</script>
@endsection