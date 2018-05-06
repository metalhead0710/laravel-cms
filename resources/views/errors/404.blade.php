@extends('layouts.frontend.default')
@section('title', 'Схоже, ви заблукали...')
@section('Stylesheets')
<link href="//fonts.googleapis.com/css?family=Ravi+Prakash" rel="stylesheet">
<style>
    .content-w3{
        background-size: cover;
        width: 62%;
        margin: 0 auto;
        min-height: 511px;
    }
    .content-w3 h1 {
        font-size: 200px;
        letter-spacing: 5px;
        text-align: center;
        font-weight: 700;
        color: #fff;
        font-family: 'Ravi Prakash', cursive;
        text-shadow:9px 9px 3px hsl(206, 15%, 40%);
    }
    .content-w3 h2{
        font-size:30px;
        letter-spacing:3px;
        text-align:center;
        color:#fff;
    }
    .content-w3 p {
        color: #fff;
        font-size: 16px;
        text-align: center;
        width: 50%;
        margin: 60px auto 0 auto;
        line-height: 30px;
    }
</style>
@endsection
@section('content')

<div class="content-w3">
    <h1>404</h1>
    <h2>Схоже, що ви заблукали...</h2>
    <p>Сторінку, яку Ви шукали не знайдено. Можливо її перемістили, видалили, або якась сволота дала Вам неправильне посилання. Не переживайте, карма покарає її</p>
</div>
@stop