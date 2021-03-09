@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('seller.index'), 'title' => 'Продавцы']    
    ]])

@endsection

@section('content_with-sidebar')

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h1 class="h2 mb-0">
      {{$item->name}}
      @include('inc.pre-deleted-badge')
    </h1>
    @if ($item->has_contract)
    <span class="badge badge-success">Договор есть</span>
    @else
    <span class="badge badge-secondary">Договора нет</span>
    @endif
  </div>

  <div class="card-body">
    <div class="card-text">
      <ul>
        @if($item->place)<li>Местоположение — {{$item->place}}</li>@endif
        @if($item->description)<li>Комментарий — {{$item->description}}</li>@endif
      </ul>
    </div>

    @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'Seller', 'model_id' => $item->id, 'removable' => true])
    @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'Seller', 'model_id' => $item->id, 'removable' => true])

  </div>
</div>

@if (count($item->MaterialsSklad))
<div class="card mb-4">
  <h3 class="card-header h3">
    Материалы на складе от продавца
  </h3>
  <div class="card-body">
    <div class="card-text">
      <ul class="list-group list-group-flush">
        @foreach ($item->MaterialsSklad as $elem)
          <li class="list-group-item">
            <a href="{{route('materialsklad.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a>
          </li>
        @endforeach
      </ul>
    </div>

  </div>
</div>
@endif

@if (count($item->MaterialsRezerv))
<div class="card mb-4">
  <h3 class="card-header h3">
    Материалы в резерве от продавца
  </h3>
  <div class="card-body">
    <div class="card-text">
      <ul class="list-group list-group-flush">
        @foreach ($item->MaterialsRezerv as $elem)
          <li class="list-group-item"><a href="{{route('materialrezerv.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a></li>
        @endforeach
      </ul>
    </div>

  </div>
</div>
@endif

@if(auth()->user()->hasAnyPermission(['edit any '.$template_data['module']]))
  <hr>
  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>
@endif
 
@endsection
