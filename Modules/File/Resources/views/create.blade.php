@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>Загрузить файлы (к ...)</h1>
    
    {!! Form::open(['route' => [$template_data['module'].'.store', [ 'model' => $model, 'model_id' => $model_id]], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    
    <p>Добавить сразу несколько файлов</p>
    <div class="form-group">
      {{Form::file('files[]', ['multiple'])}}
    </div>

    {{Form::submit('Загрузить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
