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
      {{Form::label('address','Адрес')}}
      {{Form::text('address', '', ['class' => 'form-control','placeholder' => 'Адрес'])}}
    </div>

    <div class="form-group">
      {{Form::label('phone','Телефон')}}
      {{Form::text('phone', '', ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('email','Email')}}
      {{Form::text('email', '', ['class' => 'form-control','placeholder' => 'Email'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Описание')}}
      {{Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Описание', 'id' => 'article-ckeditor'])}}
    </div>
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
