@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('seller.index'), 'title' => 'Продавцы']    
    ]])
    <h1>Добавить продавца</h1>
    {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', '', ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', '', ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий - Особенности, что покупал, насколько значим')}}
      {{Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Комментарий общий', 'id' => 'article-ckeditor'])}}
    </div>

    <div class="form-group">
      {{Form::label('description_material','Потребоность в материалах')}}
      {{Form::textarea('description_material', '', ['class' => 'form-control','placeholder' => 'Комментарий по потребностям в материалах', 'id' => 'article-ckeditor'])}}
    </div>
    {{Form::submit('Создать и добавить контакты/файлы', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
