@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', '', ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Описание')}}
      {{Form::textarea('description', 'Описание <strong>по-умолчанию!</strong>', ['class' => 'form-control','placeholder' => 'Описание', 'id' => 'article-ckeditor'])}}
    </div>
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection