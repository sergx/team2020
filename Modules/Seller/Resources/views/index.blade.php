@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} <a href="{{route($template_data['module'].'.create')}}" class="btn btn-sm btn-primary">+ Добавить</a></h1>
  @if(count($items) > 0)
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Имя / Организация</th>
        <th scope="col">Местоположение</th>
        <th scope="col">Контакты</th>
        <th scope="col">Комментарий</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $item)
      <tr>
        <td><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a></td>
        <td>{{$item->place}}</td>
        <td>{{$item->phone}}<br>{{$item->email}}</td>
        <td>{!!$item->description!!}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif

  {{$items->links()}}

 </div>
@endsection
