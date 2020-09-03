@extends('layouts.app')
@section('content')
  <div class="container">
    @include('inc.breadcrumbs')
    <h1>Новая сделка</h1>

    {!! Form::open(['route' => $template_data['module'].'.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{-- @TODO - Сделать связь с существующем материалом --}}
    <h3>Материал</h3>
    <div class="form-group">
      {{Form::label('materialrezerv_id','Материал в резерве - из базы')}}
      <a href="{{route('materialrezerv.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('materialrezerv_id', $materials_rezerv, null, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('materialsklad_id','Материал на складе - из базы')}}
      <a href="{{route('materialsklad.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('materialsklad_id', $materials_sklad, null, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>
    {{--
    <hr>
    <h3>Если не из базы</h3>
    <hr>

    <div class="form-group">
      {{Form::label('material_name','Материал')}}
      {{Form::text('material_name', '', ['class' => 'form-control','placeholder' => 'Материал'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_volume','Кол-во')}}
      {{Form::text('material_volume', '', ['class' => 'form-control','placeholder' => 'Кол-во'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_place','Местоположение')}}
      {{Form::text('material_place', '', ['class' => 'form-control','placeholder' => 'Местоположение'])}}
    </div>

    <div class="form-group">
      {{Form::label('material_description','Комментарий по материалу')}}
      {{Form::textarea('material_description', '', ['class' => 'form-control','placeholder' => 'Комментарий по материалу'])}}
    </div>

    <h3>Фотографии материала</h3>
    <div class="form-group">
      {{Form::file('images[]', ['multiple'])}}
    </div>
    --}}
    
    <hr>

    <h3>Продавц</h3>
    <div class="form-group">
      {{Form::label('seller_id','Продавец из базы')}}
      <a href="{{route('seller.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('seller_id', $sellers, null, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_price','Цена от продавца')}}
      {{Form::text('seller_price', '', ['class' => 'form-control','placeholder' => 'Цена от продавца'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_description','Детали условий сделки с продавцом')}}
      {{Form::textarea('seller_description', '', ['class' => 'form-control','placeholder' => 'Детали условий сделки с продавцом'])}}
    </div>
{{--
    <h3>О продавце</h3>
    <div class="form-group">
      {{Form::label('seller_name','Имя / Название организации')}}
      {{Form::text('seller_name', '', ['class' => 'form-control','placeholder' => 'Имя / Название организации'])}}
    </div>

    <div class="form-group">
      {{Form::label('seller_phone','Телефон')}}
      {{Form::text('seller_phone', '', ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>
--}}
    <hr>
    
    <h3>Покупатель</h3>
    <div class="form-group">
      {{Form::label('buyer_id','Покупатель из базы')}}
      <a href="{{route('buyer.create')}}" target="_blank" class="btn btn-primary btn-sm">+ Добавить</a>
      {{Form::select('buyer_id', $buyers, null, ['class' => 'form-control', 'placeholder' => 'Выбрать..'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_price','Цена для покупателя')}}
      {{Form::text('buyer_price', '', ['class' => 'form-control','placeholder' => 'Цена для покупателя'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_description','Детали условий сделки с покупателем')}}
      {{Form::textarea('buyer_description', '', ['class' => 'form-control','placeholder' => 'Детали условий сделки с покупателем'])}}
    </div>

    {{--
    <div class="form-group">
      {{Form::label('buyer_name','Имя / Название организации')}}
      {{Form::text('buyer_name', '', ['class' => 'form-control','placeholder' => 'Имя / Название организации'])}}
    </div>

    <div class="form-group">
      {{Form::label('buyer_phone','Телефон')}}
      {{Form::text('buyer_phone', '', ['class' => 'form-control','placeholder' => 'Телефон'])}}
    </div>

    --}}

    {{Form::submit('Сохранить', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
  </div>
@endsection
