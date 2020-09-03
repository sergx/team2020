@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('seller.index'), 'title' => 'Продавцы']    
    ]])

  <h1>{{$item->name}}</h1>
  <ul>
    @foreach ($item->getAttributes() as $key => $value)
      <li>{{$key}} — {{$value}}</li>
    @endforeach
  </ul>
  @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'seller', 'model_id' => $item->id, 'removable' => true])
  @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'seller', 'model_id' => $item->id, 'removable' => true])

  @if (count($item->MaterialsSklad))
    <h3>Материалы на складе от продавца</h3>
    <ul>
      @foreach ($item->MaterialsSklad as $elem)
        <li><a href="{{route('materialsklad.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a></li>
      @endforeach
    </ul>
  @endif
  @if (count($item->MaterialsRezerv))
    <h3>Материалы в резерве от продавца</h3>
    <ul>
      @foreach ($item->MaterialsRezerv as $elem)
        <li><a href="{{route('materialsklad.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a></li>
      @endforeach
    </ul>
  @endif
<hr>
  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Обновить</a>

 </div>
@endsection
