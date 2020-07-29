@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')

  <h2>{{$deal_item->material_name}}: {{$deal_item->seller_name}} <small>({{$deal_item->seller_price}})</small> -> {{$deal_item->buyer_name}} <small>({{$deal_item->buyer_price}})</small></h2>
  <p>Статус сделки — <strong>{{__('common.deal_status_'.$deal_item->status)}}</strong></p>

  <h3>О материале</h3>
  <ul>
    <li>Материал: {{$deal_item->material_name ?? "n/a"}}</li>
    <li>Кол-во: {{$deal_item->material_volume ?? "n/a"}}</li>
    <li>Местоположение: {{$deal_item->material_place ?? "n/a"}}</li>
    <li>Комментарий по материалу: {{$deal_item->material_description ?? "n/a"}}</li>
  </ul>
  <h3>О продавце</h3>
  <ul>
    <li>Имя / Название организации: {{$deal_item->seller_name ?? "n/a"}}</li>
    <li>Телефон: {{$deal_item->seller_phone ?? "n/a"}}</li>
    <li>Цена от продавца: {{$deal_item->seller_price ?? "n/a"}}</li>
    <li>Детали условий сделки с продавцом: {{$deal_item->seller_description ?? "n/a"}}</li>
  </ul>
  <h3>О покупателе</h3>
  <ul>
    <li>Имя / Название организации: {{$deal_item->buyer_name ?? "n/a"}}</li>
    <li>Телефон: {{$deal_item->buyer_phone ?? "n/a"}}</li>
    <li>Цена для покупателя: {{$deal_item->buyer_price ?? "n/a"}}</li>
    <li>Детали условий сделки с покупателем: {{$deal_item->buyer_description ?? "n/a"}}</li>
  </ul>
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
            <li>{{ $deal_item_log->options['old_value'] }} -> {{ $deal_item_log->options['new_value'] }}</li>
          @endif
        </ul>
      </li>
    @endforeach
  </ul>

  

 </div>
@endsection
