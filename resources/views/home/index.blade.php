@extends('layouts.frontend.default')
@section('title', 'Головна')
@section('content')
<div id="start" class="mg-tp-15v">
    <div class="container">
        <h4 class="text-center"  style="display:none;"> {{ $settings->subTitle }}</h4>
        <h1 class="text-center"  style="display:none;">{{ $settings->mainTitle }}</h1>

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