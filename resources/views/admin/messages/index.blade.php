@extends('layouts.backend.default')
@section('title', 'Повідомлення')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Повідомлення
            <small class="xs-hidden">тутка тойво, центр повідомлень</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section class="content">
    <div class="btn-group pull-right  mg-bt-20" style="display:none">
        <button class="btn btn-info mark-as-read" data-url="{{ route('admin.messages.markAsRead') }}" type="submit" >
            Позначити як прочитані
        </button>
        <button class="btn btn-danger pull-right delete" data-url="{{ route('admin.messages.delete') }}" type="submit">
            Видалити вибрані повідомлення
        </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="{{route('admin.messages')}}">Нові</a></li>
                    <li><a href="{{route('admin.messages.read')}}">Прочитані</a></li>
                    <li><a href="{{route('admin.messages.all')}}">Всі</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <table class="table table-hover">
                    @if($newMessages->count() < 1)
                    <tr>
                        <td colspan="4">
                            <div class="note note-info text-center">
                                <h4>
                                    У цій категорії немає повідомлень
                                </h4>
                            </div>
                        </td>
                    </tr>
                    @endif
                    <form method="post" class="form-messages">
                        {{ csrf_field() }}
                        @foreach($newMessages as $message)
                        <tr data-id="{{ $message->id }}" data-toggle="tooltip" data-placement="top" title="Натисніть на повідомлення, щоб переглянути його">
                            <td class="cell-middle">
                                <input type="checkbox" class="ids" name="ids[]" value="{{ $message->id }}"/>
                            </td>
                            <td>
                                {{ $message->sendname}} <br>
                                <small>{{ $message->email}}</small>
                            </td>
                            <td>
                                {{ str_limit($message->content, 150, '...') }}
                            </td>
                            <td class="cell-middle">
                                {{ $message->created_at->format( 'j.m.Y' ) }}
                            </td>
                        </tr>
                        @endforeach
                    </form>
                    <tfoot>
                    <tr>
                        <td class="text-center" colspan="4">{{ $newMessages->render() }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>
<div style="display: none;" class="modal fade" id="message-modal" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header borderless">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Переглянути повідомлення</h4>
            </div>
            <div class="modal-body">
                <h4>Від: <strong class="sendname"></strong>
                    <small class="email"></small></h4>
                <p>Отримано: <strong class="time"></strong></p>
                <p class="content"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                    Закрити
                </button>
            </div>
        </div>
    </div>
</div>
@stop
@section('Scripts')
<script type="text/javascript" src="{{ asset('assets/js/pages/admin/messages/list.js') }}"></script>
<script type="text/javascript">
  App.Page.Messages({
    newMsgUrl: '{{route('admin.messages')}}'
  });
</script>
@endsection