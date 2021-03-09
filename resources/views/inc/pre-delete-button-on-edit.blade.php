<hr>
@if(auth()->user()->can('delete any '.$template_data['module']))
  {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Удалить', ['class' => 'btn btn-danger'])}}
  {!! Form::close() !!}
@elseif(auth()->user()->can('pre_delete any '.$template_data['module']))
  @if(!$item->pre_deleted)
  {!! Form::open(['route' => [$template_data['module'].'.pre-delete', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
  {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Удалить (с проверкой админа)', ['class' => 'btn btn-danger'])}}
  {!! Form::close() !!}
  @else
  <div class="alert alert-warning">
    Элемент будет удален после подтверждения администратором
  </div>
  @endif
@endif
