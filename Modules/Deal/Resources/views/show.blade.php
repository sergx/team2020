@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [['href' => route('deal.index'), 'title' => 'Сделки']]])
@endsection

@section('content_with-sidebar')

<div class="card mb-4">
  <h1 class="card-header h2">
    {!!$deal_item->getDealName()!!}
  </h1>
  <div class="card-body">
    <div class="card-text">
      <p>
        Агент — <strong><a href="{{route("user.show", $deal_item->user_id)}}">{{$deal_item->User->name}}</a></strong>
        <br> Статус сделки — <strong>{{__('common.deal_status_'.$deal_item->status)}}</strong>
      </p>

      @if (!empty($deal_item->MaterialRezerv[0]))
      <h3>Материал в резерве</h3>
        <ul>
          <li>Материал: {{$deal_item->MaterialRezerv[0]->name ?? "n/a"}}</li>
          <li>Кол-во: {{$deal_item->MaterialRezerv[0]->volume ?? "n/a"}}</li>
          <li>Местоположение: {{$deal_item->MaterialRezerv[0]->place ?? "n/a"}}</li>
          <li>Комментарий по материалу: {{$deal_item->MaterialRezerv[0]->description ?? "n/a"}}</li>
        </ul>
      @endif
      
      @if (count($deal_item->MaterialSklad))
      <h3>Материал на складе</h3>
        <ul>
          <li><a href="{{route("materialsklad.show", $deal_item->MaterialSklad->first()->id)}}">{{$deal_item->MaterialSklad->first()->name}}</a></li>
          <li>Кол-во: {{$deal_item->MaterialSklad->first()->volume ?? "n/a"}}</li>
          <li>Местоположение: {{$deal_item->MaterialSklad->first()->place ?? "n/a"}}</li>
        </ul>
      @endif

    </div>
  </div>
</div>

@if (count($deal_item->Seller))
<div class="card mb-4">
  <h3 class="card-header">
    Продавец — <a href="{{route("seller.show", $deal_item->Seller->first()->id)}}">{{$deal_item->Seller->first()->name}}</a>
  </h3>
  <div class="card-body">
    <div class="card-text">
      <p>Цена от продавца: {{$deal_item->seller_price ?? "n/a"}}</p>
      <p>Детали условий сделки с продавцом: {{$deal_item->seller_description ?? "n/a"}}</p>
    </div>
    @include('inc.model-contacts', ['data' => $deal_item->Seller->first()->PersonContacts, 'title' => 'Контакты продавца', 'model' => 'Seller', 'model_id' => $deal_item->Seller->first()->id, 'removable' => false])
  </div>
</div>
@endif

  @if (count($deal_item->Buyer))
    <div class="card mb-4">
      <h3 class="card-header">
        Покупатель — <a href="{{route("buyer.show", $deal_item->Buyer->first()->id)}}">{{$deal_item->Buyer->first()->name}}</a>
      </h3>
      <div class="card-body">
        <div class="card-text">
          <p>Цена для покупателя: {{$deal_item->buyer_price ?? "n/a"}}</p>
          <p>Детали условий сделки с покупателем: {{$deal_item->buyer_description ?? "n/a"}}</p>
        </div>
        @include('inc.model-contacts', ['data' => $deal_item->Buyer->first()->PersonContacts, 'title' => 'Контакты покупателя', 'model' => 'Buyer', 'model_id' => $deal_item->Buyer->first()->id, 'removable' => false])
      </div>
    </div>
  @endif

  
  @if ($deal_item->user_id === auth()->user()->id || auth()->user()->can('edit deal'))
    <a href="{{route($template_data['module'].'.edit', $deal_item['id'])}}" class="btn btn-primary">Редактировать</a>
  @endif

  @if (auth()->user()->can('change deal status'))
  <a href="{{route($template_data['module'].'.status_update', ['id' => $deal_item['id'], 'status' => 'accept'])}}" class="btn btn-success">Одобрить</a>
  <a href="{{route($template_data['module'].'.status_update', ['id' => $deal_item['id'], 'status' => 'decline'])}}" class="btn btn-danger">Отклонить</a>
  @endif

  <h2 class="mt-3">История изменений</h2>
  <ul>
    @foreach ($deal_item->Notification as $deal_item_log)
      <li>
        <small>{{$deal_item_log->created_at}}, <strong>
          @foreach ($deal_item_log->User->roles as $role)
            {{__('common.role_'.$role->name)}}
          @endforeach
          {{$deal_item_log->User->name}}</strong></small>
        <ul>
          <li>[icon] {{ __($deal_item_log->options['formal_key']) }}</li>
          @if (isset($deal_item_log->options['old_value']) && isset($deal_item_log->options['new_value']))
            <li>
              @if (is_array($deal_item_log->options['old_value']) && $deal_item_log->options['formal_key'] == 'common.deal_formal_images_changed')
                Добавлены фотографии
              @else
                {{ $deal_item_log->options['old_value'] }}
                ->
              @endif

              @if (is_array($deal_item_log->options['new_value']) && $deal_item_log->options['formal_key'] == 'common.deal_formal_images_changed')
              {{--
              {{var_dump($deal_item_log->options['new_value'])}}
                @foreach ($deal_item_log->options['new_value'] as $log_image_item)
                  <a href="{{$log_image_item}}" target="_blank"><img src="{{$log_image_item}}" alt="" style="max-width:100px;max-hight:100px"></a>
                @endforeach
                --}}
              @else
              {{ $deal_item_log->options['new_value'] }}
              @endif
              </li>
          @endif
        </ul>
      </li>
    @endforeach
  </ul>

  

 
@endsection
