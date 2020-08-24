@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('seller.index'), 'title' => 'Продавцы']    
    ]])

  <h1>{{$item->name}}</h1>

  <a href="{{route('personcontact.create', ['model' => 'seller', 'model_id' => $item->id])}}">Добавить контакт</a>

  <ul>
    @foreach ($item->getAttributes() as $key => $value)
      <li>{{$key}} — {{$value}}</li>
    @endforeach
  </ul>

  @if ($item->PersonContacts()->exists())
    <h3>Контакты</h3>
    @foreach ($item->PersonContacts as $elem)
      <li>{{$elem->name}}: {{$elem->phone}}, {{$elem->email}}</li>
    @endforeach
  @endif
  
  @if ($item->Files()->exists())
    <h3>Файлы</h3>
    @foreach ($item->Files as $elem)
      <li>{{$elem->filename}} - {{$elem->path}}</li>
    @endforeach
  @endif

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Обновить</a>

 </div>
@endsection
