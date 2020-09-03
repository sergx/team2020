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

  @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'buyer', 'model_id' => $item->id, 'removable' => true])
  @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'buyer', 'model_id' => $item->id, 'removable' => true])
  <hr>
  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Обновить</a>

 </div>
@endsection
