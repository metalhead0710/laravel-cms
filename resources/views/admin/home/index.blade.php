@extends('layouts.backend.default')
@section('title', 'Статистика')
@section('Stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .chart-container{
        background-color: #ccc;
        margin: 5px;
        padding: 5px;
    }
    .loading {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0,0,0,0.5);
        z-index: 100;
        display: none;
    }
    .loading i {
        font-size: 72px;
        margin: 0 auto;
        text-align: center;
        display: block;
        position: relative;
        top: 44%;
        color: #CCC;
    }
</style>
@endsection
@section('content')
<div class="page-header">
	<h1>Статистика відвідувань сайту
		<small>тут можна переглянути статистику</small>
	</h1>
</div>
@include('layouts._partials.feedback')
<section class="content">
    <div class="loading"><i class="fa fa-spinner fa-spin"></i></div>
    <div class="actions pull-right mg-bt-15">
        <form method="post" id="period_form" class="form-inline">
            <div class="form-group">
                <label for="period"  class="control-label">Виберіть початок періоду</label>
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="period" id="period" class="form-control">
                </div>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
    <div class="note note-info">
        <p class="text-primary lead">
        Статистика тягнеться з аналітики гугла, і ця сторінка грузицця пиздець як довго, а так як вона є
        дефолтною після авторизації, то я єбав ждати і зробив завантаження статистики ручним. Якщо тобі больно нада, то кляцни
        кнопку, або вибери дату початку збору інфи.
        </p>
        <button class="btn btn-primary get-stats">
            <i class="fa fa-bar-chart-o"></i>
            Отримати статистику за сьогодні
        </button>
    </div>
    <div id="stats"></div>
</section>
@stop
@section('Scripts')
    <script src="{{ asset('assets/js/pages/admin/home/list.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.uk.min.js') }}"></script>
    <script type="text/javascript">
      App.Page.Dashboard({
        url: "{{route('admin.home.getData')}}",
        token: "{{csrf_token()}}"
      });
    </script>
@endsection
