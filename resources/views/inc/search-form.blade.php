{{ Form::open(['route' => $route, 'method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'form-inline']) }}
<div class="form-group mb-2 mr-2">
  {{Form::text('q', $q, ['class' => 'form-control','placeholder' => 'Поиск по всем полям'])}}
</div>
{{Form::submit('Найти', ['class' => 'btn btn-primary mb-2'])}}
{!! Form::close() !!}
