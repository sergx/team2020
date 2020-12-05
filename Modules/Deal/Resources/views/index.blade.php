@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} <a href="{{route($template_data['module'].'.create')}}" class="btn btn-sm btn-primary">+ Добавить</a></h1>
  @if(count($items) > 0)

  @include('inc.search-form', ['route' => [$template_data['module'].'.search'], 'q' => !empty($q) ? $q : ''])

  <div class="table-responsive mb-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Сделка</th>
          <th scope="col">Материал</th>
          <th scope="col">Объем</th>
          <th scope="col">Продавец</th>
          <th scope="col">Цена от продавца</th>
          <th scope="col">Цена для покупателя</th>
          <th scope="col">Покупатель</th>
          <th scope="col">Агент</th>
        </tr>
      </thead>
      <tbody>
        @php
          $tags = ["<span style='background-color:#ffde19'>", "</span>"];
        @endphp
        @foreach ($items as $item)
        <tr>
          <td><a href="{{route("deal.show", $item->id)}}">
            {!! !empty($q) ? wrap_string(date("Y-m-d H:i" , strtotime($item->created_at)),  $q, $tags) : date("Y-m-d H:i" , strtotime($item->created_at)) !!}
          </a></td>
          <td>{!! !empty($q) ? wrap_string($item->material->name,  $q, $tags) : $item->material->name !!}</td>
          <td>{{$item->material->volume}}</td>
          <td><a href="{{route("seller.show", $item->Seller->first()->id)}}">
            {!! !empty($q) ? wrap_string($item->Seller->first()->name,  $q, $tags) : $item->Seller->first()->name !!}
          </a></td>
          <td>{{$item->seller_price}}</td>
          <td>{{$item->buyer_price}}</td>
          <td><a href="{{route("buyer.show", $item->Buyer->first()->id)}}">
            {!! !empty($q) ? wrap_string($item->Buyer->first()->name,  $q, $tags) : $item->Buyer->first()->name !!}
          </a></td>
          <td><a href="{{route("user.show", $item->user_id)}}">
            {!! !empty($q) ? wrap_string($item->User->name,  $q, $tags) : $item->User->name !!}
          </a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$items->links()}}
  </div>
  @endif
@endsection

@section('with_sidebar')
{{-- Чтобы убрать сайдбар --}}
@endsection
