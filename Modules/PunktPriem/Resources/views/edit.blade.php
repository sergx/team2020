@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => [$template_data['module'].'.update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'PUT')}}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', $item->name, ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('address','Адрес')}}
      {{Form::text('address', '', ['class' => 'form-control','placeholder' => 'Адрес'])}}
    </div>

    <div class="form-group">
      {{Form::label('phone','Телефон')}}
      {{Form::text('phone', $item->phone, ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('email','Email')}}
      {{Form::text('email', $item->email, ['class' => 'form-control','placeholder' => 'Email'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Описание')}}
      {{Form::textarea('description', $item->description, ['class' => 'form-control','placeholder' => 'Описание', 'id' => 'article-ckeditor'])}}
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
