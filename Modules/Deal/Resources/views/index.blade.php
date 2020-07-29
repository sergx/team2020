@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}}</h1>
  @if(count($items) > 0)
  <ul>
    @foreach ($items as $item)
      @if (!empty($item->name))
        <li><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a>, {!!$item->description!!}</li>
      @else
        <li><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->material_name}}: {{$item->seller_name}} -> {{$item->buyer_name}}</a></li>
      @endif
    @endforeach
  </ul>
  @endif

  {{$items->links()}}

 </div>
@endsection
