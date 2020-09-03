@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('materialsklad.index'), 'title' => 'Материалы на складе'],
      ['href' => route('materialsklad.show', $item->id), 'title' => $item->name.", ".$item->volume]    
      ]])
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => [$template_data['module'].'.update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'PUT')}}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', $item->name, ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('volume','Кол-во')}}
      {{Form::text('volume', $item->volume, ['class' => 'form-control','placeholder' => 'Кол-во'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', $item->place, ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>
    {{--
    <div class="form-group">
      {{Form::label('seller_name','Продавец - имя / организация')}}
      {{Form::text('seller_name', $item->seller_name, ['class' => 'form-control','placeholder' => ' - имя / организация'])}}
    </div>
    --}}
    <div class="form-group">
      {{Form::label('contacts','Контакты')}}
      {{Form::text('contacts', $item->contacts, ['class' => 'form-control','placeholder' => 'Контакты'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', $item->description, ['class' => 'form-control','placeholder' => 'Комментарий', 'id' => 'article-ckeditor'])}}
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
