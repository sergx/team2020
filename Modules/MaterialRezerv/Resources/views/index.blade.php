@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} <a href="{{route($template_data['module'].'.create')}}" class="btn btn-sm btn-primary">+ Добавить</a></h1>
@endsection

@section('content_with-sidebar')
  @if(count($items) > 0)

  @include('inc.search-form', ['route' => [$template_data['module'].'.search'], 'q' => !empty($q) ? $q : ''])

  <div class="table-responsive mb-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Материал</th>
          <th scope="col">Кол-во</th>
          <th scope="col">Местоположение</th>
          {{--<th scope="col">Контакты</th>--}}
          <th scope="col">Комментарий</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td><a href="{{route($template_data['module'].'.show', $item->id)}}">{!!$item->name!!}</a></td>
          <td>{!!$item->volume!!}</td>
          <td>{!!$item->place!!}</td>
          {{--<td>{!!$item->contacts!!}</td>--}}
          <td>{!!$item->description!!}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$items->links()}}
  @endif


 
@endsection
