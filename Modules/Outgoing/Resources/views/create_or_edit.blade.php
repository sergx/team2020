@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route($model->getClassShortLower().".show", $model->id), 'title' => $model->name]
      ]])

    {!! Form::open(['route' => [$template_data['module'].'.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

    @hasanyrole('admin')
      <h3>Агент</h3>
      <div class="form-group">
        {{Form::select('user_id', $agents, false, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
      </div>
    @else
      {{Form::hidden('user_id', auth()->user()->id)}}
    @endhasanyrole

    <div class="form-group">
      {{Form::label('name','Название для издержки')}}
      {{Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Название для издержки'])}}
    </div>

    <h3>Подробности для <a href="{{route($model->getClassShortLower().".show", $model->id)}}" target="_blank">{!!$model->name!!}</a></h3>

    {{Form::hidden('backroute', route($model->getClassShortLower().".show", $model->id))}}
    {{Form::hidden('outgoingcostable_id', $model->id)}}
    {{Form::hidden('outgoingcostable_type', get_class($model))}}
    
    <div class="form-group">
      {{Form::label('cost_rub','Сумма в рублях')}}
      {{Form::number('cost_rub', old('cost_rub'), ['class' => 'form-control','placeholder' => 'Сумма в рублях'])}}
    </div>

    <div class="form-group">
      {{Form::label('description','Комментарий')}}
      {{Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Комментарий'])}}
    </div>

    <hr>
    <p>Необязательные поля</p>

    <div class="form-group">
      {{Form::label('type','Тип')}}
      {{Form::text('type', old('type'), ['class' => 'form-control','placeholder' => 'Тип'])}}
    </div>

    <div class="form-group">
      {{Form::label('status','Статус')}}
      {{Form::select('status', [1 => 'Оплачен, завершен', 2 => 'Запланирован'], old('status'), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>
    {{-- <hr>
    <div>Поля ниже актуальны, если издержка объединяет несколько элементов</div>


    Создать и сохранить OutgoingCost для переданной модели --}}

<hr>
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
