@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}} <a href="{{route($template_data['module'].'.create')}}" class="btn btn-sm btn-primary">+ Добавить</a></h1>

  @endsection

  @section('content_with-sidebar')
  @if(count($items) > 0)
  
  @include('inc.pre-deleted-alert')

  @include('inc.search-form', ['route' => [$template_data['module'].'.search'], 'q' => !empty($q) ? $q : ''])

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
          <td>
            @if(!empty($item->pre_deleted) && auth()->user()->hasAnyPermission(['delete any '.$template_data['module'],'pre_delete any '.$template_data['module']]))
            <span class="badge badge-warning">pre deleted</span>
            @endif
            <a href="{{route($template_data['module'].'.show', $item->id)}}">{!! $item->name !!}</a>
          </td>
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
