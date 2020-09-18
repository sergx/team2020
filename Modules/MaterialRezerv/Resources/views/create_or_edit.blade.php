@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('materialrezerv.index'), 'title' => 'Материалы в резерве']
      ]])

    @if (isset($item))
      <h1><a href="{{route('materialrezerv.show', $item->id)}}">{{__("common.".$template_data['module']."_title")}}</a> - {{__("common.".$template_data['template'])}}</h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{Form::hidden('_method', 'PUT')}}
    @else
      <h1>Добавить материал на складе</h1>
      {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif

    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('volume','Кол-во')}}
      {{Form::text('volume', old('volume'), ['class' => 'form-control','placeholder' => 'Кол-во'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', old('place'), ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_id','Продавец')}}
      <a href="{{route('seller.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить нового</a>
      {{Form::select('seller_id', $seller, old('seller_id'), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Комментарий', 'id' => 'article-ckeditor'])}}
    </div>

    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    
    @if (isset($item))
      <hr>
      {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
      {{Form::hidden('_method', 'DELETE')}}
      {{Form::submit('Удалить', ['class' => 'btn btn-danger'])}}
      {!! Form::close() !!}
    @endif
  </div>
@endsection
