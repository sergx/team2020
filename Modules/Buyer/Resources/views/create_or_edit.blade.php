@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')

    @if (isset($item))
      <h1>Редактировать <a href="{{route('buyer.show', $item->id)}}">покупателя</a></h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{Form::hidden('_method', 'PUT')}}
    @else
    <h1>Добавить покупателя</h1>
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
      {{Form::label('description','Комментарий - Особенности, что покупал, насколько значим')}}
      {{Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Комментарий общий'])}}
    </div>

    <div class="form-group">
      {{Form::label('description_material','Потребность в материалах')}}
      {{Form::textarea('description_material', old('description_material'), ['class' => 'form-control','placeholder' => 'Комментарий по потребностям в материалах'])}}
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
