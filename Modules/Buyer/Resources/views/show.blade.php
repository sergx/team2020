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

  @if (count($item->Files) )
    <h3>Файлы</h3>
    @foreach ($item->Files as $file)
      <li>{{$file->filename}} - {{$file->path}}</li>
    @endforeach
  @endif

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Обновить</a>

 </div>
@endsection
