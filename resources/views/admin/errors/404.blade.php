@extends('layouts.backend.default')
@section('title', 'Схоже, ви заблукали...')
@section('Stylesheets')
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
            color: #333;
            text-shadow:9px 9px 3px hsl(206, 15%, 40%);
        }
        .content-w3 h2{
            font-size:30px;
            letter-spacing:3px;
            text-align:center;
            color:#333;
        }
        .content-w3 p {
            color: #333;
            font-size: 16px;
            text-align: center;
            width: 50%;
            margin: 60px auto 0 auto;
            line-height: 30px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="page-header">
            <h1>Помилка 404
                <small>тут ніфіга нема</small>
            </h1>
        </div>
    </section>
    <div class="content-w3">
        <h1>404</h1>
        <h2>Схоже, що ви заблукали...</h2>
        <p>Сторінку, яку Ви шукали не знайдено. Можливо її перемістили, видалили, або якась сволота дала Вам неправильне посилання. Не переживайте, карма покарає її анально</p>
    </div>
@stop