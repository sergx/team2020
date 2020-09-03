<h3>{{ $title ?? 'Файлы' }} <a href="{{route('file.create', ['model' => $model, 'model_id' => $model_id])}}" class="btn btn-sm btn-primary">+ Добавить</a></h3>
@if (count($data))
  <ul>
    @foreach ($data as $elem)
      <li>
        <a href="{{$elem->path}}" target="_blank">{{$elem->filename}}</a>
        @if (!empty($removable))
          {!! Form::open(['route' => ['file.destroy', ['model' => $model, 'model_id' => $model_id, 'file_id' => $elem->id]], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'd-inline-block']) !!}
          {{Form::hidden('_method', 'DELETE')}}
          {{Form::submit('Х', ['class' => 'btn btn-danger btn-sm', 'style' => 'font-size: 0.5rem;	padding: 0.125rem 0.25rem;'])}}
          {!! Form::close() !!}
        @endif
      </li>
    @endforeach
  </ul>
@else
  n/a
@endif
