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
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', $item->place, ['class' => 'form-control','placeholder' => 'Местоположение'])}}
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
    <!--
      $table->bigInteger('user_id')->nullable();
      $table->string('name')->nullable();
      $table->string('description')->nullable();
      $table->string('place')->nullable();
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
    <div class="form-group">
      {{Form::file('images')}}
    </div>
    -->
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Удалить', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}
  </div>
@endsection
