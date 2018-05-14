@extends('layouts.backend.default')
@section('title', 'Соціальні мережі')
@section('content')
    <section class="content-header">
        <div class="page-header">
            <h1>Соціальні мережі
                <small class="xs-hidden">тут можна керувати соціальними мережами</small>
            </h1>
        </div>
    </section>
    @include('layouts._partials.feedback')
    <div class="sort-popup"></div>
    <section class="content">
        <div class="actions pull-right mg-bt-15">
            <div class="btn-group">
                <a class="btn btn-primary" href="#edit-modal" data-toggle="modal">Додати</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Дії</th>
                        <th>Зображення</th>
                        <th>Назва</th>
                        <th>Посилання</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($socials->count() == 0)
                        <tr>
                            <td colspan="4" class="cell-middle">
                                <div class="note note-info text-center">
                                    <h4>
                                        Немає соціалок, поки що...
                                    </h4>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach($socials as $social)
                        <tr data-id="{{ $social->id }}">
                            <td width="175">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Дії
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="#" class="edit-social">
                                                <i class="fa fa-edit">
                                                </i>
                                                Редагувати
                                            </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li class="evil">
                                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('admin.socials.delete', ['id' => $social->id]) }}" class="delete" >
                                                <i class="fa fa-times"></i>
                                                Видалити
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset($social->thumb) }}" class="img-responsive" />
                            </td>
                            <td>
                                {{$social->name}}
                            </td>
                            <td>
                                {{ $social->url }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <div style="display: none;" class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header borderless">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Видалити соціалку?</h4>
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
    <div style="display: none;" class="modal fade" id="edit-modal" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('admin.socials.edit') }}" id="edit-social-form" enctype="multipart/form-data" method="post">
                <div class="modal-content">
                    <div class="modal-header borderless">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                        </button>
                        <h4 class="modal-title">Редагувати соціалку</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                                    <label for="name" class="control-label col-md-2">Назва</label>
                                    <div class="col-md-10">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" class="id" />
                                        <input type="text" class="form-control name" name="name" placeholder="Назва" />
                                        @if($errors->has('name'))
                                            <span class="help-block">{{$errors->first('name')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('icon') ? ' has-error' : ''}}">
                                    <label for="file" class="control-label col-md-2">Іконка</label>
                                    <div class="col-md-10">
                                        <img class="icon" style="display:none" />
                                        <input type="file" name="icon" title="Вибрати файл">
                                        @if($errors->has('icon'))
                                            <span class="help-block">{{$errors->first('icon')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('url') ? ' has-error' : ''}}">
                                    <label for="url" class="control-label col-md-2">Посилання</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control url" name="url" />
                                        @if($errors->has('url'))
                                            <span class="help-block">{{$errors->first('url')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Зберегти
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                            Закрити
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
@section('Scripts')
    <script src="{{ asset('assets/components/b-file-input/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/admin/socials/list.js') }}"></script>

    <script type="text/javascript">
      App.Page.Socials({
        url: '{{ route('admin.socials.getOne') }}'
      });
    </script>
@endsection