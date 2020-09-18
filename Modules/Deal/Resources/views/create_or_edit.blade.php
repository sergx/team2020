@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs', ['breadcrumb_items' => [
      ['href' => route('deal.index'), 'title' => 'Сделки'],   
      ]])
    @if (isset($item))
      <h1>Редактировать <a href="{{route('deal.show', $item->id)}}">сделку</a></h1>
      {{ Form::model($item, ['route' => [$template_data['module'].'.update', $item->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
      {{--
      {{Form::hidden('_method', 'PUT')}}
      {{Form::hidden('status', 'updated')}}
      --}}
    @else
      <h1>Новая сделка</h1>
      {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif
    @hasanyrole('admin')
    <h3>Ответственный агент</h3>
    <div class="form-group">
      {{-- ToDO ? вынести user_id в agent_id --}}
      {{--<a href="{{route('materialrezerv.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>--}}
      {{Form::select('user_id', $agents, old('user_id'), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>
    @endhasanyrole
    <h3>Материал</h3>
    <div class="form-group">
      {{Form::label('materialrezerv_id','Материал в резерве - из базы')}}
      <a href="{{route('materialrezerv.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('materialrezerv_id', $materials_rezerv, old('materialrezerv_id', isset($item) ? $item->MaterialRezerv->first()->id ?? '' : ''), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('materialsklad_id','Материал на складе - из базы')}}
      <a href="{{route('materialsklad.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('materialsklad_id', $materials_sklad, old('materialsklad_id', isset($item) ? $item->MaterialSklad->first()->id ?? '' : ''), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>
    <hr>

    <h3>Продавц</h3>
    <div class="form-group">
      {{Form::label('seller_id','Продавец из базы')}}
      <a href="{{route('seller.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('seller_id', $sellers, old('seller_id', isset($item) ? $item->Seller->first()->id ?? '' : ''), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_price','Цена от продавца')}}
      {{Form::text('seller_price', old('seller_price'), ['class' => 'form-control','placeholder' => 'Цена от продавца'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_description','Детали условий сделки с продавцом')}}
      {{Form::textarea('seller_description', old('seller_description'), ['class' => 'form-control','placeholder' => 'Детали условий сделки с продавцом'])}}
    </div>
    <hr>
    
    <h3>Покупатель</h3>
    <div class="form-group">
      {{Form::label('buyer_id','Покупатель из базы')}}
      <a href="{{route('buyer.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('buyer_id', $buyers, old('buyer_id', isset($item) ? $item->Buyer->first()->id ?? '' : ''), ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_price','Цена для покупателя')}}
      {{Form::text('buyer_price', old('buyer_price'), ['class' => 'form-control','placeholder' => 'Цена для покупателя'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_description','Детали условий сделки с покупателем')}}
      {{Form::textarea('buyer_description', old('buyer_description'), ['class' => 'form-control','placeholder' => 'Детали условий сделки с покупателем'])}}
    </div>

    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
