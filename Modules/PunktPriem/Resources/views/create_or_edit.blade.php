@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('punktpriem.index'), 'title' => 'Партнеры']    
    ]])

    @if (isset($item))
      <h1>Рекдактировать <a href="{{route('punktpriem.show', $item->id)}}">Партнера</a></h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{Form::hidden('_method', 'PUT')}}
    @else
      <h1>Добавить партнера</h1>
      {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif

    <div class="form-group">
      {{Form::label('name','Название')}}
      {{Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Название'])}}
    </div>

    <div class="form-group">
      {{Form::label('address','Адрес')}}
      {{Form::text('address', old('address'), ['class' => 'form-control','placeholder' => 'Адрес'])}}
    </div>
    
    {{--
    <div class="form-group">
      {{Form::label('phone','Телефон')}}
      {{Form::text('phone', old('phone'), ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('email','Email')}}
      {{Form::text('email', old('email'), ['class' => 'form-control','placeholder' => 'Email'])}}
    </div>
    --}}

    <div class="form-group">
      <div class="form-check">
        {{Form::radio('has_contract', 0, old('has_contract'), ['id' => 'has_contract_false','class' => 'form-check-input'])}}
        {{Form::label('has_contract_false','Договора нет')}}
      </div>

      <div class="form-check">
        {{Form::radio('has_contract', 1, old('has_contract'), ['id' => 'has_contract_true', 'class' => 'form-check-input'])}}
        {{Form::label('has_contract_true','Договор есть')}}
      </div>
    </div>

    <div class="form-group">
      {{Form::label('description','Описание')}}
      {{Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Описание', 'id' => 'article-ckeditor'])}}
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
