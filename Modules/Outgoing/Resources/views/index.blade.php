@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
  <h1>Издержки</h1>
@endsection

@section('content_with-sidebar')
  @if(count($items) > 0)
  <div class="table-responsive mb-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Название</th>
          <th scope="col">Элемент(ы)</th>
          <th scope="col">Стоимость</th>
          <th scope="col">Комментарий</th>
          <th scope="col">Агент</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td><a href="{{route($template_data['module'].'.show', $item->id)}}">{{$item->name}}</a></td>
          <td>
            @if (count($item->OutgoingCosts) > 1)
              @foreach ($item->OutgoingCosts as $item_oc)
                {{ $item_oc->outgoingcostable->name }}<hr style='margin-top:2px;margin-bottom:2px'>
              @endforeach
            @else
              {{$item->OutgoingCosts->first()->outgoingcostable->name}}
            @endif
          </td>
          <td>
            {!!$item->OutgoingCosts->pluck('cost_rub')->implode("<hr style='margin-top:2px;margin-bottom:2px'>")!!}
            @if (count($item->OutgoingCosts) > 1)
              <hr style='margin-top:2px;margin-bottom:2px'>
              <strong>Итого: {{$item->total_cost}}</strong>
            @endif
          </td>
          <td>
            @if (count($item->OutgoingCosts) > 1)
              @foreach ($item->OutgoingCosts as $item_oc)
                {{ $item_oc->description }}<hr style='margin-top:2px;margin-bottom:2px'>
              @endforeach
            @else
              {{$item->OutgoingCosts->first()->description}}
            @endif

            {{-- {!!$item->OutgoingCosts->pluck('description')->implode("<hr style='margin-top:2px;margin-bottom:2px'>")!!} --}}
          </td>
          {{-- <td>{{$item->total_description}}</td> --}}
          <td><a href="{{route("user.show", $item->user_id)}}">{{$item->user->name}}</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$items->links()}}
  @endif


 
@endsection
