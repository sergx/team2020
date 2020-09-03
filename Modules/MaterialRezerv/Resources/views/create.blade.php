@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('materialrezerv.index'), 'title' => 'Материалы в резерве']    
      ]])
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', '', ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('volume','Кол-во')}}
      {{Form::text('volume', '', ['class' => 'form-control','placeholder' => 'Кол-во'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', '', ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_id','Продавец')}}
      <a href="{{route('seller.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить нового</a>
      {{Form::select('seller_id', $seller, null, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Комментарий', 'id' => 'article-ckeditor'])}}
    </div>
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
