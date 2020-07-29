@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}}</h1>
  @if(count($items) > 0)
  <ul>
    @foreach ($items as $item)
      {{--<li><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a>--}}
      <li><strong>{{$item->name}}</strong>
        @php ($item_roles = [])
        @if (count($item->roles))
          — сейчас роль
          @foreach($item->roles as $role)
            <a href="{{route('user.role_update', ['user_id' =>  $item->id, 'role_id' => $role->id])}}">{{__('common.role_'.$role->name)}}</a>
            @php ($item_roles[] = $role->name)
          @endforeach
           <small>(Нажмите, чтобы отменить)</small>
        @endif
        <br>
      Назначить роль:
      @foreach ($roles as $role)
        @if (!in_array($role->name, $item_roles))
          <a href="{{route('user.role_update', ['user_id' =>  $item->id, 'role_id' => $role->id])}}">{{__('common.role_'.$role->name)}}</a>
        @endif
      @endforeach
      <hr>
      </li>
    @endforeach
  </ul>
  @endif

  {{$items->links()}}

 </div>
@endsection
