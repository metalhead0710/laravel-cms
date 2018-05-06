@extends('layouts.frontend.default')
@section('title', 'Головна')
@section('content')
<div id="start" class="mg-tp-15v">
    <div class="container">
        <h4 class="text-center"  style="display:none;"> {{ $settings->subTitle }}</h4>
        <h1 class="text-center"  style="display:none;">{{ $settings->mainTitle }}</h1>
        <div class="bottom-stuff mg-tp-10v">
            <div class="parent-block"   style="display:none;">
                <div class="tiles">
                    <ul>
                        @foreach($services as $service)
                        <li class="tile">
                            <a href="#{{ $service->html_id }}" data-toggle="tab">
                                <img class="tile-img" src="{{ asset($service->pic) }}">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div style="clear: both;"></div>
                <div class="texts">
                    <div class="tab-content">
                        @foreach($services as $key=>$service)
                        <div id="{{ $service->html_id }}" class="tab-pane{{ $key == 0 ? ' active' : '' }}">
                            <h5>{{ $service->name }}</h5>
                            <p>{{ $service->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
@section('Scripts')
<script type="text/javascript" src="{{ asset('assets/js/pages/home/home.js') }}"></script>
<script>
    $(function() {
        App.Page.Home({
            test: "{{ uniqid('bodyyyy') }}"
        });
    })
</script>
@endsection