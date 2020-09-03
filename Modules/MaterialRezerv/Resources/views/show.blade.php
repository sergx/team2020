@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('materialrezerv.index'), 'title' => 'Материалы в резерве']    
    ]])

  <h1>{{$item->name}}, {{$item->volume}}</h1>

  <ul>
    <li>Материал — {{$item->name}}</li>
    <li>Кол-во — {{$item->volume}}</li>
    <li>Местоположение — {{$item->place}}</li>
    <li>Комментарий — {{$item->description}}</li>
  </ul>


  @include('inc.model-files', ['data' => $item->Files, 'title' => 'Изображения материала', 'model' => 'materialrezerv', 'model_id' => $item->id, 'removable' => false])

  @if ($item->Seller()->exists())
  <hr>
  <h2>Продавец — <a href="{{route('seller.show', $item->Seller->id)}}">{{$item->Seller->name}}</a></h2>
    <ul>
      <li>Комментарий к продавцу — {{$item->Seller->description}}</li>
      <li>Комментарий по материалам — {{$item->Seller->description_material}}</li>
    </ul>
    @include('inc.model-contacts', ['data' => $item->Seller->PersonContacts, 'title' => 'Контакты продавца', 'model' => 'seller', 'model_id' => $item->id, 'removable' => false])
  @endif

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Изменить</a>

 </div>
@endsection
