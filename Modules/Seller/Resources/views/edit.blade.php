@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('seller.index'), 'title' => 'Продавцы'],
      ['href' => route('seller.show', $item->id), 'title' => $item->name],      
      ]])
    <h1>Продавец <strong>{{$item->name}}</strong> — {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => [$template_data['module'].'.update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'PUT')}}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', $item->name, ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', $item->place, ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий - Особенности, что покупал, насколько значим')}}
      {{Form::textarea('description', $item->description, ['class' => 'form-control','placeholder' => 'Комментарий общий'])}}
    </div>

    <div class="form-group">
      {{Form::label('description_material','Потребоность в материалах')}}
      {{Form::textarea('description_material', $item->description_material, ['class' => 'form-control','placeholder' => 'Комментарий по потребностям в материалах'])}}
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
