@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')

  <h1>{{$item->name}}, {{$item->volume}}</h1>

  <ul>
    <li>Материал — {{$item->name}}</li>
    <li>Кол-во — {{$item->volume}}</li>
    <li>Местоположение — {{$item->place}}</li>
    <li>Контакты — {{$item->contacts}}</li>
    <li>Комментарий — {{$item->description}}</li>

  </ul>

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Изменить</a>

 </div>
@endsection
