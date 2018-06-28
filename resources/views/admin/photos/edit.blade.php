@extends('layouts.backend.default')
@section('title', 'Список фото')
@section('content')
<section class="content-header">
    <div class="page-header">
        <h1>Список фото
            <small class="xs-hidden">Ви редагуєте каталог <strong>{{ $photocat->name }} </strong></small>
        </h1>
    </div>
</section>
@include('layouts._partials.feedback')
<div class="sort-popup"></div>
<section>
    <div class="btn-group pull-right">
        <a class="btn btn-default" href="{{ route('admin.photos')}}">
            <i class="fa fa-long-arrow-left"></i>
            Назад
        </a>
        <a href="#add-photos" data-toggle="modal" class="btn btn-primary ">
            <i class="fa fa-plus"></i>
            Додати фотографії
        </a>
        <button class="btn btn-danger pull-right submit-btn" type="submit" style="display:none">
            Видалити вибрані фото
        </button>
        <a href="#" class="btn btn-success save-order" style="display:none">
            <i class="fa fa-sort"></i>
            Зберегти порядок
        </a>
    </div>
    <div class="clearfix"></div>
    <div class="mg-tp-50 mg-bt-50">
        <form class="forma" method="post" action="{{ route('admin.photos.deletemassive', ['id' => $photocat->id]) }}">
            {{ csrf_field() }}
            <div class="box">
                @foreach ($photocat->photos as $photo)
                    <div class="box-item" data-id="{{ $photo->id }}">
                        <input type="checkbox" name="pic[]" value="{{ $photo->id }}" class="check" />
                        <img src="{{ asset($photo->thumb) }}" class="">
                        <div class="delete-link-wrapper">
                            <a href="#modal" class="delete-link text-danger" data-toggle="modal" data-deletelink = "{{ route('admin.photos.deleteOne' , ['categoryId' => $photocat->id, 'id'=>$photo->id]) }}">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
    <div style="display: none;" class="modal fade" id="modal" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header borderless">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Видалити фото?</h4>
                </div>
                <div class="modal-body">
                    <a href="#" class="btn btn-danger delete-one">
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
                        <input type="hidden" name="id" value="{{ $photocat->id }}"/>
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
</section>
@stop
@section('Scripts')
<script src="{{ asset('assets/components/b-file-input/bootstrap-filestyle.min.js') }}"></script>
<script src="{{ asset('assets/components/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/admin/photos/edit.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    App.Page.PhotoList({
      url: "{{ route('admin.photos.sortout') }}",
      popupUrl: "{{ route('admin.popup') }}",
      token: "{{csrf_token()}}"
    });
</script>
@endsection