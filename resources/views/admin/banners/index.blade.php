@extends('layouts.backend.default')
@section('title', 'Банери')
@section('content')
    <section class="content-header">
        <div class="page-header">
            <h1>Банери
                <small class="xs-hidden">тут можна керувати банерами</small>
            </h1>
        </div>
    </section>
    @include('layouts._partials.feedback')
    <div class="sort-popup"></div>
    <section class="content">
        <div class="actions pull-right mg-bt-15">
            <div class="btn-group">
                <a class="btn btn-primary" href="#create-modal" data-toggle="modal">Додати</a>
                <a href="#" class="btn btn-success save-order" style="display:none">
                    <i class="fa fa-sort"></i>
                    Зберегти порядок
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @if (!$banners->count())
                    <div class="note note-info text-center">
                        <h4>
                            Немає банерів, поки що...
                        </h4>
                    </div>
                @endif
                <ul class="banner-list">
                    @foreach ($banners as $banner)
                        <li class="col-md-3" data-id="{{ $banner->id }}" data-sort="{{ $banner->sort_order }}">
                            <img src="{{ asset($banner->thumb) }}" class="img-responsive" alt="" />
                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('admin.banners.delete', ['id' => $banner->id]) }}" class="btn btn-danger delete" >
                                <i class="fa fa-times"></i>
                                Видалити
                            </a>
                        </li>
                    @endforeach
                </ul>
                {{ $banners->render() }}
            </div>
        </div>
    </section>
    <div style="display: none;" class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header borderless">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Видалити банер?</h4>
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
    <div style="display: none;" class="modal fade" id="create-modal" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('admin.banners.create') }}" enctype="multipart/form-data" method="post">
                <div class="modal-content">
                    <div class="modal-header borderless">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                        </button>
                        <h4 class="modal-title">Додати банер</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="form-group{{ $errors->has('image') ? ' has-error' : ''}}">
                                    <label for="file" class="control-label col-md-2">Банер</label>
                                    <div class="col-md-10">
                                        {{ csrf_field() }}
                                        <input type="file" name="image" title="Вибрати файл">
                                        @if($errors->has('image'))
                                            <span class="help-block">{{$errors->first('image')}}</span>
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
    <script src="{{ asset('assets/components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/admin/carousel/list.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(function() {
        App.Page.Carousel({
            url: "{{ route('admin.banners.sortout') }}",
            token: "{{csrf_token()}}"
        });
      });
    </script>
@endsection