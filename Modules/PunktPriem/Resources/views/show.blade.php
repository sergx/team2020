@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('punktpriem.index'), 'title' => 'Партнеры']    
    ]])
@endsection

@section('content_with-sidebar')
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h1 class="h2 mb-0">
      {{$item->name}}
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
        @if ($item->address)
          <li>Адрес — {{$item->address}}</li>
        @endif
        @if ($item->description)
          <li>Описание — {{$item->description}}</li>
        @endif
        @if ($item->place)  
          <li>place — {{$item->place}}</li>
        @endif
      </ul>
    </div>
    @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'PunktPriem', 'model_id' => $item->id, 'removable' => true])
    @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'PunktPriem', 'model_id' => $item->id, 'removable' => true])

  </div>
</div>


  <hr>
  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>

 
@endsection
