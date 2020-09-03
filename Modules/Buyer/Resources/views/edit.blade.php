@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>Редактировать покупателя</h1>
    
    {!! Form::open(['route' => [$template_data['module'].'.update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'PUT')}}
    <div class="form-group">
      {{Form::label('name','Имя / Компания')}}
      {{Form::text('name', $item->name, ['class' => 'form-control','placeholder' => 'Имя / Компания'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', $item->place, ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', $item->description, ['class' => 'form-control','placeholder' => 'Комментарий'])}}
    </div>

    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Удалить', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}
  </div>
@endsection
