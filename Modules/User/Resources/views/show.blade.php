@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('user.index'), 'title' => 'Агенты']    
    ]])

  <h1>{{$item->name}}</h1>
@endsection

@section('content_with-sidebar')
  <p>
    @if (count($item->roles))
      @foreach($item->roles as $role)
        {{__('common.role_'.$role->name)}},
      @endforeach
    @endif
    <a href="mailto:{{$item->email}}" target="_blank">{{$item->email}}</a></p>
  <p>

  </p>
  @include('inc.model-contacts', ['data' => $item->PersonContacts, 'title' => 'Контакты', 'model' => 'User', 'model_id' => $item->id, 'removable' => true])
  @include('inc.model-files',    ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'User', 'model_id' => $item->id, 'removable' => true])

  {{--
    @if (count($item->MaterialsSklad))
      <h3>Материалы на складе от продавца</h3>
      <ul>
        @foreach ($item->MaterialsSklad as $elem)
          <li><a href="{{route('materialsklad.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a></li>
        @endforeach
      </ul>
    @endif
    @if (count($item->MaterialsRezerv))
      <h3>Материалы в резерве от продавца</h3>
      <ul>
        @foreach ($item->MaterialsRezerv as $elem)
          <li><a href="{{route('materialsklad.show', $elem->id)}}">{{$elem->name}}, {{$elem->volume}}</a></li>
        @endforeach
      </ul>
    @endif
  --}}
<hr>
  {{--<a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>--}}

 
@endsection
