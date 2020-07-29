@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>{{__("common.".$template_data['module']."_title")}} - {{__("common.".$template_data['template'])}}</h1>

    {!! Form::open(['route' => [$template_data['module'].'.update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'PUT')}}

    <h3>О материале</h3>
    <div class="form-group">
      {{Form::label('material_name','Материал')}}
      {{Form::text('material_name', $item->material_name, ['class' => 'form-control','placeholder' => 'Материал'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_volume','Кол-во')}}
      {{Form::text('material_volume', $item->material_volume, ['class' => 'form-control','placeholder' => 'Кол-во'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_place','Местоположение')}}
      {{Form::text('material_place', $item->material_place, ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_description','Комментарий по материалу')}}
      {{Form::textarea('material_description', $item->material_description, ['class' => 'form-control','placeholder' => 'Комментарий по материалу'])}}
    </div>
    
    <hr>
    
    <h3>О продавце</h3>
    <div class="form-group">
      {{Form::label('seller_name','Имя / Название организации')}}
      {{Form::text('seller_name', $item->seller_name, ['class' => 'form-control','placeholder' => 'Имя / Название организации'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_phone','Телефон')}}
      {{Form::text('seller_phone', $item->seller_phone, ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_price','Цена от продавца')}}
      {{Form::text('seller_price', $item->seller_price, ['class' => 'form-control','placeholder' => 'Цена от продавца'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_description','Детали условий сделки с продавцом')}}
      {{Form::textarea('seller_description', $item->seller_description, ['class' => 'form-control','placeholder' => 'Детали условий сделки с продавцом'])}}
    </div>
    
    <hr>
    
    <h3>О покупателе</h3>
    <div class="form-group">
      {{Form::label('buyer_name','Имя / Название организации')}}
      {{Form::text('buyer_name', $item->buyer_name, ['class' => 'form-control','placeholder' => 'Имя / Название организации'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_phone','Телефон')}}
      {{Form::text('buyer_phone', $item->buyer_phone, ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_price','Цена для покупателя')}}
      {{Form::text('buyer_price', $item->buyer_price, ['class' => 'form-control','placeholder' => 'Цена для покупателя'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_description','Детали условий сделки с покупателем')}}
      {{Form::textarea('buyer_description', $item->buyer_description, ['class' => 'form-control','placeholder' => 'Детали условий сделки с покупателем'])}}
    </div>
    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    @if ($item->user_id === auth()->user()->id || auth()->user()->can('delete deal'))
    <hr>
    {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Удалить', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}
    @endcan
  </div>
@endsection
