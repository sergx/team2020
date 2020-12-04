@extends('layouts.with-sidebar')

@section('head_content')
@include('inc.breadcrumbs', ['breadcrumb_items' => [
  ['href' => route('buyer.index'), 'title' => 'Покупатели']    
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
      @if (!empty($item->description))
      <p>
        <strong>Особенности, что покупал, насколько значим</strong><br>
        {{ $item->description }}
      </p>
      @endif
      @if (!empty($item->description_material))
      <p>
        <strong>Потребность в материалах</strong><br>
        {{ $item->description_material }}
      </p>
      @endif
    </div>
    
    @if (!$item->admin_verification)
      @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'Buyer', 'model_id' => $item->id, 'removable' => true])
    @else
      <h2>Контакты</h2>
      <p>Для получения контактов требуется <strong>особое подтверждение</strong> у руководства.</p>
    @endif
    @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'Buyer', 'model_id' => $item->id, 'removable' => true])

  </div>
</div>

  <hr>

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>

 
@endsection
