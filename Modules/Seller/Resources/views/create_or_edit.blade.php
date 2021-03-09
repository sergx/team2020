@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('seller.index'), 'title' => 'Продавцы']  
      ]])

    @if (isset($item))
      <h1>
        Редактировать <a href="{{route('seller.show', $item->id)}}">продавца</a>
        @include('inc.pre-deleted-badge')
      </h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{Form::hidden('_method', 'PUT')}}
    @else
      <h1>Добавить продавца</h1>
      {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif

    <div class="form-group">
      {{Form::label('name','Имя / Компания')}}
      {{Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Имя / Компания'])}}
    </div>

    <div class="form-group">
      {{Form::label('place','Местоположение')}}
      {{Form::text('place', old('place'), ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

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
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Комментарий'])}}
    </div>
    
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

    @if (isset($item))
      @include('inc.pre-delete-button-on-edit')
    @endif
  </div>
@endsection
