@extends('layouts.frontend.default')
@section('title', 'Послуги')
@section('Stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/pages/photos/list.css') }}">
@endsection
@section('content')
<div id="services" class="">
    <div class="container">
        <h1 class="text-center">Наші послуги</h1>
        <h4 class="text-center"> Індивідуальний підхід до кожного клієнта та професійне виконання його побажань</h4>
        <div class="semicircle-parent">
            @foreach($services as $service)
            <div class="sc-child">
                <div class="row">
                    <div class="col-md-2 vcenter">
                        <img src="{{ asset($service->pic) }}">
                    </div>
                    <div class="col-md-10 vcenter">
                        <h5>{{ $service->name }}</h5>
                        <p>{{ $service-> description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop
@section('Scripts')
<script type="text/javascript">
    $(document).ready(function() {
        if(document.documentElement.clientWidth > 1200) {
            var divs = $('.sc-child');
            var delta = Math.PI * 2 / divs.length;
            var angle = 0;

            for (var i = 0; i < divs.length; i++) {
                divs[i].style.left = 50 * Math.sin(angle/2) + '%';
                angle += delta;
            }
            $('.sc-child').animate({
                left: 'toggle'
            } , 1500);
        }
        else {
            $('.sc-child').show(1000);
        }
    });
</script>
@endsection