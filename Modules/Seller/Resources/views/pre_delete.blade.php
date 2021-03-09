@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} на удаление</h1>

  @if(count($items) > 0)

  @include('inc.search-form', ['route' => [$template_data['module'].'.search'], 'q' => !empty($q) ? $q : ''])

  <div class="table-responsive mb-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-nowrap">Оставить</th>
          <th scope="col" class="text-nowrap">Имя / Организация</th>
          <th scope="col" class="text-nowrap">Местоположение</th>
          <th scope="col" class="text-nowrap">Комментарий</th>
          <th scope="col" class="text-nowrap">Договор</th>
          <th scope="col" class="text-nowrap">Удалить</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td>
            {!! Form::open(['route' => [$template_data['module'].'.keep-alive', $item->id], 'method' => 'GET', 'enctype' => 'multipart/form-data']) !!}
            {{Form::submit('Не удалять', ['class' => 'btn btn-sm btn-success'])}}
            {!! Form::close() !!}
          </td>
          <td><a href="{{route($template_data['module'].'.show', $item->id)}}">{!!$item->name!!}</a></td>
          <td>{!!$item->place!!}</td>
          <td>{!!$item->description!!}</td>
          <td>{{$item->has_contract ? 'Есть': '—'}}</td>
          <td>
            {!! Form::open(['route' => [$template_data['module'].'.destroy', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
              {{Form::hidden('_method', 'DELETE')}}
              {{Form::submit('Удалить', ['class' => 'btn btn-sm btn-danger'])}}
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$items->links()}}
  </div>
  @endif

@endsection

@section('with_sidebar')
  <!-- Убираем сайдбар -->
@endsection
