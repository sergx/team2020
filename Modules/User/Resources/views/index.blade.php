@extends('layouts.with-sidebar')
@section('head_content')
  @include('inc.breadcrumbs')
  <h1>Пользователи</h1>
@endsection

@section('content_with-sidebar')
<h4 class="mb-3"><a href="{{route('userroles.index')}}">Permissions and Roles</a></h4>
@if(count($items) > 0)
<ul>
  @foreach ($items as $item)
    <li><strong><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a></strong>
      @if (auth()->user()->id === $item->id)
        (это Вы)
      @endif

      @php
        $item_roles = [];
      @endphp

      @if (count($item->roles))
        — сейчас роль
        @foreach($item->roles as $role)
          @if (auth()->user()->id === $item->id && $role->id === 2)
            <span>{{__('common.role_'.$role->name)}}</span>
          @else
            <a href="{{route('user.role_update', ['user_id' =>  $item->id, 'role_id' => $role->id])}}">{{__('common.role_'.$role->name)}}</a>
          @endif
          @if ($role->name == 'page_renter')
            <strong>(<a href="{{route('fastedit.show', "user_permission/".$item->id)}}">Редактировать доступ к страницам</a>)</strong>
          @endif
          @php
            $item_roles[] = $role->name
          @endphp
        @endforeach

        @if (auth()->user()->id !== $item->id)
         <small>(Нажмите, чтобы отменить)</small>
        @endif
      @endif
      <br>
    @if (count($roles) > count($item_roles))      
      Назначить роль:
    @endif
    @foreach ($roles as $role)
      @if (!in_array($role->name, $item_roles))
        <a href="{{route('user.role_update', ['user_id' =>  $item->id, 'role_id' => $role->id])}}">{{__('common.role_'.$role->name)}}</a>
      @endif
    @endforeach
    <hr>
    </li>
  @endforeach
</ul>
{{$items->links()}}
@endif


@endsection

