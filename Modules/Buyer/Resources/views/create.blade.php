@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('buyer.index'), 'title' => 'Покупатели']    
    ]])
    <h1>Добавить покупателя</h1>

    {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('name','Имя / Компания')}}
      {{Form::text('name', '', ['class' => 'form-control','placeholder' => 'Имя / Компания'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', '', ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Комментарий'])}}
    </div>
    {{Form::submit('Создать и добавить контакты/файлы', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
