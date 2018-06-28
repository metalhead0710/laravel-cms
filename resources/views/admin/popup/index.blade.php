@if ($res)
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Успіх!</strong> {{$message}}
    </div>
@else
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Помилка!</strong> {{$message}}
    </div>
@endif
