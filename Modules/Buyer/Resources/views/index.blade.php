@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} <a href="{{route($template_data['module'].'.create')}}" class="btn btn-sm btn-primary">+ Добавить</a></h1>

  @endsection

  @section('content_with-sidebar')
  @if(count($items) > 0)

  
  {{ Form::open(['route' => [$template_data['module'].'.search'], 'method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'form-inline']) }}
    <div class="form-group mb-2 mr-2">
      {{Form::text('q', $q, ['class' => 'form-control','placeholder' => 'Поиск по всем полям'])}}
    </div>
    {{Form::submit('Найти', ['class' => 'btn btn-primary mb-2'])}}
  {!! Form::close() !!}

  <div class="table-responsive mb-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-nowrap">Имя / Организация</th>
          <th scope="col" class="text-nowrap">Местоположение</th>
          <th scope="col" class="text-nowrap">Комментарий</th>
          <th scope="col" class="text-nowrap">Договор</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td><a href="{{route($template_data['module'].'.show', $item->id)}}">{!! $item->name !!}</a></td>
          <td>{!! $item->place !!}</td>
          <td>
            {!! $item->description !!}
            @if(!empty($item->description) && !empty($item->description_material))
              <br>
            @endif
            {!! $item->description_material !!}
          </td>
          <td>{{$item->has_contract ? 'Есть': '—'}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$items->links()}}
  @endif


@endsection
