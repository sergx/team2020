@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [['href' => route('deal.index'), 'title' => 'Сделки']]])
@endsection

@section('content_with-sidebar')

<div class="card mb-4">
  <h1 class="card-header h2">
    {!!$item->getDealName()!!}
  </h1>
  <div class="card-body">
    <div class="card-text">
      <p>
        Агент — <strong><a href="{{route("user.show", $item->user_id)}}">{{$item->User->name}}</a></strong>
        <br> Статус сделки — <strong>{{__('common.deal_status_'.$item->status)}}</strong>
      </p>

      @if (!empty($item->MaterialRezerv[0]))
      <h3>Материал в резерве</h3>
        <ul>
          <li>Материал: {{$item->MaterialRezerv[0]->name ?? "n/a"}}</li>
          <li>Кол-во: {{$item->MaterialRezerv[0]->volume ?? "n/a"}}</li>
          <li>Местоположение: {{$item->MaterialRezerv[0]->place ?? "n/a"}}</li>
          <li>Комментарий по материалу: {{$item->MaterialRezerv[0]->description ?? "n/a"}}</li>
        </ul>
      @endif
      
      @if (count($item->MaterialSklad))
      <h3>Материал на складе</h3>
        <ul>
          <li><a href="{{route("materialsklad.show", $item->MaterialSklad->first()->id)}}">{{$item->MaterialSklad->first()->name}}</a></li>
          <li>Кол-во: {{$item->MaterialSklad->first()->volume ?? "n/a"}}</li>
          <li>Местоположение: {{$item->MaterialSklad->first()->place ?? "n/a"}}</li>
        </ul>
      @endif

    </div>
  </div>
</div>

@if (count($item->Seller))
<div class="card mb-4">
  <h3 class="card-header">
    Продавец — <a href="{{route("seller.show", $item->Seller->first()->id)}}">{{$item->Seller->first()->name}}</a>
  </h3>
  <div class="card-body">
    <div class="card-text">
      <p>Цена от продавца: {{$item->seller_price ?? "n/a"}}</p>
      <p>Детали условий сделки с продавцом: {{$item->seller_description ?? "n/a"}}</p>
    </div>
    @include('inc.model-contacts', ['data' => $item->Seller->first()->PersonContacts, 'title' => 'Контакты продавца', 'model' => 'Seller', 'model_id' => $item->Seller->first()->id, 'removable' => false])
  </div>
</div>
@endif

  @if (count($item->Buyer))
    <div class="card mb-4">
      <h3 class="card-header">
        Покупатель — <a href="{{route("buyer.show", $item->Buyer->first()->id)}}">{{$item->Buyer->first()->name}}</a>
      </h3>
      <div class="card-body">
        <div class="card-text">
          <p>Цена для покупателя: {{$item->buyer_price ?? "n/a"}}</p>
          <p>Детали условий сделки с покупателем: {{$item->buyer_description ?? "n/a"}}</p>
        </div>
        @include('inc.model-contacts', ['data' => $item->Buyer->first()->PersonContacts, 'title' => 'Контакты покупателя', 'model' => 'Buyer', 'model_id' => $item->Buyer->first()->id, 'removable' => false])
      </div>
    </div>
  @endif

  @include('inc.model-outgoings')
  
  @if ($item->user_id === auth()->user()->id || auth()->user()->can('edit deal'))
    <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>
  @endif

  @if (auth()->user()->can('change deal status'))
  <a href="{{route($template_data['module'].'.status_update', ['id' => $item['id'], 'status' => 'accept'])}}" class="btn btn-success">Одобрить</a>
  <a href="{{route($template_data['module'].'.status_update', ['id' => $item['id'], 'status' => 'decline'])}}" class="btn btn-danger">Отклонить</a>
  @endif

  <h2 class="mt-3">История изменений</h2>
  <ul>
    @foreach ($item->Notification as $item_log)
      <li>
        <small>{{$item_log->created_at}}, <strong>
          @foreach ($item_log->User->roles as $role)
            {{__('common.role_'.$role->name)}}
          @endforeach
          {{$item_log->User->name}}</strong></small>
        <ul>
          <li>[icon] {{ __($item_log->options['formal_key']) }}</li>
          @if (isset($item_log->options['old_value']) && isset($item_log->options['new_value']))
            <li>
              @if (is_array($item_log->options['old_value']) && $item_log->options['formal_key'] == 'common.deal_formal_images_changed')
                Добавлены фотографии
              @else
                {{ $item_log->options['old_value'] }}
                ->
              @endif

              @if (is_array($item_log->options['new_value']) && $item_log->options['formal_key'] == 'common.deal_formal_images_changed')
              {{--
              {{var_dump($item_log->options['new_value'])}}
                @foreach ($item_log->options['new_value'] as $log_image_item)
                  <a href="{{$log_image_item}}" target="_blank"><img src="{{$log_image_item}}" alt="" style="max-width:100px;max-hight:100px"></a>
                @endforeach
                --}}
              @else
              {{ $item_log->options['new_value'] }}
              @endif
              </li>
          @endif
        </ul>
      </li>
    @endforeach
  </ul>

  

 
@endsection
