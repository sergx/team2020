@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('punktpriem.index'), 'title' => 'Партнеры']    
    ]])

    @if (isset($item))
      <h1>Редактировать <a href="{{route('punktpriem.show', $item->id)}}">Партнера</a></h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{Form::hidden('_method', 'PUT')}}
    @else
      <h1>Добавить партнера</h1>
      {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('name','Название')}}
          {{Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Название организации'])}}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('city_id','Город')}}
          {{Form::select('city_id', $cites, old('city_id'), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('address','Адрес')}}
          {{Form::text('address', old('address'), ['class' => 'form-control','placeholder' => 'Адрес'])}}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('coords','Координаты на карте')}}
          {{Form::text('coords', old('coords'), ['class' => 'form-control','placeholder' => 'Координаты'])}}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('work_time','Часы работы')}}
          {{Form::text('work_time', old('work_time'), ['class' => 'form-control','placeholder' => 'Часы работы'])}}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('phone','Телефон')}}
          {{Form::text('phone', old('phone'), ['class' => 'form-control','placeholder' => 'Телефон'])}}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('email','Email')}}
          {{Form::text('email', old('email'), ['class' => 'form-control','placeholder' => 'Email'])}}
        </div>
      </div>
      @if (auth()->user()->role('admin'))          
      <div class="col-md-3">
        <div class="form-group">
          {{Form::label('user_id','Связь с пользователем')}}
          {{Form::select('user_id', $users, old('user_id'), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
        </div>
      </div>
      @else
        {{Form::hidden('user_id', auth()->user()->id)}}
      @endif
    </div>
    <hr>
    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
          <div class="form-check">
            {{Form::hidden('has_contract', 0)}}
            {{Form::checkbox('has_contract', 1, old('has_contract'), ['id' => 'has_contract','class' => 'form-check-input'])}}
            {{Form::label('has_contract','Договор есть')}}
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <div class="form-check">
            {{Form::hidden('active', 0)}}
            {{Form::checkbox('active', 1, old('active'), ['id' => 'active','class' => 'form-check-input'])}}
            {{Form::label('active','Активен')}}
          </div>
        </div>
      </div>
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
