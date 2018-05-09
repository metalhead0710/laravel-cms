@extends('layouts.backend.default')
@section('title', 'Фото')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Фото
            <small class="xs-hidden">тут можна накидати фоток</small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<a href="{{ route('admin.photos.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Створити каталог</a>
<div class="clearfix"></div>
<div class="table-container">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Назва</th>
            <th>Фото</th>
            <th>К-сть</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        @if ($photocats->count() < 1)
        <tr>
            <td colspan="6" class="cell-middle">
                <div class="note note-info text-center">
                    <h4>
                        Немає ні одного каталогу, поки що...
                    </h4>
                </div>
            </td>
        </tr>
        @endif
        @foreach($photocats as $photocat)
            <tr>
                <td class="cell-middle">
                    {{ $photocat->name}}
                </td>
                <td class="cell-middle">
                    @if (!empty($photocat->picture))
                        <img src="{{ asset($photocat->thumb) }}" width="100" class="img-responsive" />
                    @else
                        <img src="http://placehold.it/100x70?text=:(" class="img-responsive" />
                    @endif
                </td>
                <td class="cell-middle">
                    {{ $photocat->photos->count() }}
                </td>
                <td class="cell-middle">
                    <div class="btn-group">
                        <a href ="#add-photos" data-toggle="modal" data-id="{{ $photocat->id }}" class="btn btn-primary add-photos" title="Додати фотографії"><i class="fa fa-plus"></i></a>
                        <a href ="{{ route('admin.photos.edit', ['slug' => $photocat->slug]) }}" class="btn btn-info" title="Редагувати список фото"><i class="fa fa-edit"></i></a>
                        <a href ="{{ route('admin.photos.update', ['slug' => $photocat->slug]) }}" class="btn btn-warning" title="Редагувати каталог">
                            <i class="fa fa-edit"></i>
                            Редагувати каталог
                        </a>
                        <a href="#modal" data-toggle='modal' data-link="{{ route('admin.photos.delete', ['id' => $photocat->id]) }}" class="btn btn-danger delete">
                            <i class="fa fa-times"></i>
                            Видалити каталог
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div style="display: none;" class="modal fade" id="modal" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header borderless">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Видалити каталог?</h4>
            </div>
            <div class="modal-body">
                <p class="text-danger">Видалення каталогу призведе до видалення всіх фотографій, що в ньому, к хуям собачим</p>
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
<div style="display: none;" class="modal fade" id="add-photos" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header borderless">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Додати фотографії</h4>
            </div>
            <div class="modal-body">
                <p class="text-info">Через цю форму можна додавати кілька файлів одночасно</p>
                <form action="{{ route('admin.photos.addPhotos') }}" method="post" enctype="multipart/form-data" class="add-photo-form">
                    {{ csrf_field() }}
                    <input type="hidden" class="photocat-id" name="id"/>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : ''}}">
                        <input type="file" name="photos[]" multiple="multiple"  title="Вибрати файл">
                        @if($errors->has('photo'))
                        <span class="help-block">{{$errors->first('photo')}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload"></i>
                        Завантажити
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                        Закрити
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('Scripts')
<script src="{{ asset('assets/components/b-file-input/bootstrap-filestyle.min.js') }}"></script>
<script>
    $(function() {
        $('.delete').on("click", function () {
            var link = $(this).closest("a.delete");
            var	url = link.data("link");
            $('.delete-confirm').attr("href", url);
        });
        $('.add-photos').on("click", function () {
            var id = $(this).data('id');
            $('.add-photo-form .photocat-id').attr('value', id);
        });
        $('input[type=file]').filestyle({
            text : 'Виберіть файл(и)',
            badge: true,
            buttonBefore : true,
            btnClass : 'btn-primary',
            htmlIcon : '<i class="fa fa-file-image-o"></i> '
        });
    });
</script>
@endsection