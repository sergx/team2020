@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs', ['breadcrumb_items' => [['href' => route('deal.index'), 'title' => 'Сделки']]])

  <h2>{!!$deal_item->getDealName()!!}</h2>
  
  <p>Статус сделки — <strong>{{__('common.deal_status_'.$deal_item->status)}}</strong></p>

  @if (!empty($deal_item->MaterialRezerv[0]))
  <h3>Материал в резерве</h3>
    <ul>
      <li>Материал: {{$deal_item->MaterialRezerv[0]->name ?? "n/a"}}</li>
      <li>Кол-во: {{$deal_item->MaterialRezerv[0]->volume ?? "n/a"}}</li>
      <li>Местоположение: {{$deal_item->MaterialRezerv[0]->place ?? "n/a"}}</li>
      <li>Комментарий по материалу: {{$deal_item->MaterialRezerv[0]->description ?? "n/a"}}</li>
    </ul>
  @endif
  
  @if (!empty($deal_item->MaterialSklad[0]))
  <h3>Материал на складе</h3>
    <ul>
      <li>Материал: {{$deal_item->MaterialSklad[0]->name ?? "n/a"}}</li>
      <li>Кол-во: {{$deal_item->MaterialSklad[0]->volume ?? "n/a"}}</li>
      <li>Местоположение: {{$deal_item->MaterialSklad[0]->place ?? "n/a"}}</li>
      <li>Комментарий по материалу: {{$deal_item->MaterialSklad[0]->description ?? "n/a"}}</li>
    </ul>
  @endif
  @if (!empty($deal_item->Buyer[0]))
  <h3>О покупателе</h3>
  <ul>
    <li>Имя / Название организации: {{$deal_item->Buyer[0]->name ?? "n/a"}}</li>
    <li>Телефон: {{$deal_item->Buyer[0]->phone ?? "n/a"}}</li>
  </ul>
  @endif
  <h3>Условия сделки</h3>
  <ul>
    <li>Цена для покупателя: {{$deal_item->buyer_price ?? "n/a"}}</li>
    <li>Детали условий сделки с покупателем: {{$deal_item->buyer_description ?? "n/a"}}</li>
  </ul>

  <h3>О продавце</h3>
  <ul>
    <li>Имя / Название организации: {{$deal_item->seller_name ?? "n/a"}}</li>
    <li>Телефон: {{$deal_item->seller_phone ?? "n/a"}}</li>
    <li>Цена от продавца: {{$deal_item->seller_price ?? "n/a"}}</li>
    <li>Детали условий сделки с продавцом: {{$deal_item->seller_description ?? "n/a"}}</li>
  </ul>
  <h3>Фотографии (images)</h3>
  <div class="form-group">
    <div class="form-row align-items-center">
      @if($deal_item->images)
        @foreach ($deal_item->images as $image_item)
        <div class="col">
          <a href="{{$image_item}}" target="_blank"><img src="{{$image_item}}" alt="image" style="max-width:100%;max-height:300px;"></a>
        </div>
        @endforeach
      @endif
    </div>
  </div>

  <h3>Фотографии (Files)</h3>
  <div class="form-group">
    <div class="form-row align-items-center">
      @if($deal_item->Files)
        @foreach ($deal_item->Files as $file)
        <div class="col">
          <a href="{{$file->path}}" target="_blank">
            <img src="{{$file->path}}" alt="image" style="max-width:100%;max-height:300px;">
            <span>{{$file->filename}}</span>
          </a>
        </div>
        @endforeach
      @endif
    </div>
  </div>
  @if ($deal_item->user_id === auth()->user()->id || auth()->user()->can('edit deal'))
    <a href="{{route($template_data['module'].'.edit', $deal_item['id'])}}" class="btn btn-primary">Изменить</a>
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

  

 </div>
@endsection
