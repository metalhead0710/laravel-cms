@foreach($photos as $photo)
<a class="photo-item" href="{{ asset($folder . '/' . $photo->filename) }}">
    <img class="img-responsive" src="{{ asset($folder . '/thumbs/' . $photo->filename) }}" alt="" />
</a>
@endforeach