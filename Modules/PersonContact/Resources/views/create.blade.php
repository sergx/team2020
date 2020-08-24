@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>
    
    {!! Form::open(['route' => [$template_data['module'].'.store', [ 'model' => $model, 'model_id' => $model_id]], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('name','Имя')}}
      {{Form::text('name', '', ['class' => 'form-control','placeholder' => 'Имя'])}}
    </div>

    <div class="form-group">
      {{Form::label('phone','Телефон')}}
      {{Form::text('phone', '', ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('email','Email')}}
      {{Form::text('email', '', ['class' => 'form-control','placeholder' => 'Email'])}}
    </div>

    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
