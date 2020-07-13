@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')

  <h1>{{!empty($item['title']) ? $item['title'] : "ID ".$item->id }}</h1>

  <ul>
    @foreach ($item->getAttributes() as $key => $value)
      <li>{{$key}} — {{$value}}</li>
    @endforeach
  </ul>

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Обновить</a>

 </div>
@endsection
