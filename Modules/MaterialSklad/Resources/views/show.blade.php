@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('materialsklad.index'), 'title' => 'Материалы на складе']    
    ]])

@endsection

@section('content_with-sidebar')

<div class="card mb-4">
  <h1 class="card-header h2">
    {{$item->name}}, {{$item->volume}}
  </h1>
  <div class="card-body">
    <div class="card-text">
      <ul>
        @if($item->name)<li>Материал — {{$item->name}}</li>@endif
        @if($item->volume)<li>Кол-во — {{$item->volume}}</li>@endif
        @if($item->place)<li>Местоположение — {{$item->place}}</li>@endif
        @if($item->description)<li>Комментарий — {{$item->description}}</li>@endif
      </ul>
    </div>
    @include('inc.model-files', ['data' => $item->Files, 'title' => 'Изображения материала', 'model' => 'materialsklad', 'model_id' => $item->id, 'removable' => false])

  </div>
</div>
@if ($item->Seller()->exists())
<div class="card">
  <h3 class="card-header">
    Источник (продавец) материала — <a href="{{route('seller.show', $item->Seller->id)}}">{{$item->Seller->name}}</a>
  </h3>
  <div class="card-body">
    <div class="card-text">
      @if($item->Seller->description)<p>Комментарий к продавцу — {{$item->Seller->description}}</p>@endif
      @if($item->Seller->description_material)<p>Комментарий по материалам — {{$item->Seller->description_material}}</p>@endif
    </div>
    @include('inc.model-contacts', ['data' => $item->Seller->PersonContacts, 'title' => 'Контакты продавца', 'model' => 'seller', 'model_id' => $item->id, 'removable' => false])
  </div>
</div>
@endif

<hr>

<a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>


@endsection
