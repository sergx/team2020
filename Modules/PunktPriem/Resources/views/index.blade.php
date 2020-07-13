@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}}</h1>
  @if(count($items) > 0)
  <ul>
    @foreach ($items as $item)
      <li><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a>, {!!$item->description!!}
        , {{$item->address}}
        , {{$item->phone}}
        , {{$item->email}}
      </li>
    @endforeach
  </ul>
  @endif

  {{$items->links()}}

 </div>
@endsection
