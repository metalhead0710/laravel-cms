@extends('layouts.backend.default')
@section('title', 'Новини')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Новини
            <small class="xs-hidden">тут можна керувати новинами</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<section class="content">
    <div class="actions pull-right mg-bt-15">
        <a class="btn btn-primary" href="{{ route('admin.news.add') }}">Додати</a>
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
                            <th>Зображення</th>
                            <th>Заголовок</th>
                            <th>Текст</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($news->count() == 0)
                        <tr>
                            <td colspan="4" class="cell-middle">
                                <div class="note note-info text-center">
                                    <h4>
                                        Немає новин, поки що...
                                    </h4>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @foreach($news as $new)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Дії
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="{{ route('admin.news.update', ['id' => $new->id ])}}">
                                                <i class="fa fa-edit">
                                                </i>
                                                Редагувати
                                            </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li class="evil">
                                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('admin.news.delete', ['id' => $new->id]) }}" class="delete" >
                                                <i class="fa fa-times"></i>
                                                Видалити
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset($new->thumbUrl) }}" class="img-responsive" />
                            </td>
                            <td>
                                {{$new->title}}
                            </td>
                            <td>
                                {!! str_limit( strip_tags($new->text), 300, '...') !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center">
                                    {{ $news->render() }}
                                </td>
                            </tr>
                        </tfoot>
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
                <h4 class="modal-title">Видалити новину?</h4>
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