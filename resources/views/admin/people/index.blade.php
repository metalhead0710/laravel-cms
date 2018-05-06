@extends('layouts.backend.default')
@section('title', 'Команда')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Команда
            <small class="xs-hidden">тут можна керувати командою</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section class="content">
    <div class="actions pull-right mg-bt-15">
        <a class="btn btn-primary" href="{{ route('admin.people.add') }}">Додати</a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="product-table" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Дії</th>
                            <th>Фото</th>
                            <th>Ім'я</th>
                            <th>Посада</th>
                            <th>Опис</th>
                            <th>VK</th>
                            <th>FB</th>
                            <th>Skype</th>
                            <th>Twitter</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($people->count() == 0)
                        <tr>
                            <td colspan="9" class="cell-middle">
                                <div class="note note-info text-center">
                                    <h4>
                                        Немає людей, поки що...
                                    </h4>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @foreach($people as $person)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Дії
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="{{ route('admin.people.update', ['id' => $person->id ])}}">
                                                <i class="fa fa-edit">
                                                </i>
                                                Редагувати
                                            </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li class="evil">
                                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('admin.people.delete', ['id' => $person->id]) }}" class="delete" >
                                                <i class="fa fa-times"></i>
                                                Видалити
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset($person->thumbUrl) }}" class="img-responsive" width="150"/>
                            </td>
                            <td>
                                {{$person->first_name . ' ' . $person->last_name}}
                            </td>
                            <td>
                                {{$person->position}}
                            </td>
                            <td>
                                {{ str_limit(strip_tags($person->info), 300, '...') }}
                            </td>
                            <td>
                                <a class="btn {{ !empty($person->vk) ? 'btn-primary' : 'btn-danger'}}" href="{{ $person->vk }}">
                                    <i class="fa fa-vk"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn {{ $person->facebook !='' ? 'btn-primary' : 'btn-danger'}}" href="{{ $person->facebook }}">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn {{ $person->skype !='' ? 'btn-primary' : 'btn-danger'}}" href="tel:{{ $person->skype }}">
                                    <i class="fa fa-skype"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn {{ $person->twitter !='' ? 'btn-primary' : 'btn-danger'}}" href="{{ $person->twitter }}">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<div style="display: none;" class="modal fade" id="delete-modal" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header borderless">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Видалити людину?</h4>
            </div>
            <div class="modal-body">
                <a class="btn btn-danger delete-confirm">
                    Так
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                    Ні
                </button>
            </div>
        </div>
    </div>
</div>

@stop
@section('Scripts')
<script type="text/javascript">
    $(function() {
        $('.delete').on("click", function () {
            var link = $(this).closest("a.delete");
            var	url = link.data("link");
            $('.delete-confirm').attr("href", url);
        });
    });
</script>
@endsection