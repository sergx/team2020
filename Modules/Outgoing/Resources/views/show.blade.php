@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs', ['breadcrumb_items' => [
    ['href' => route('outgoing.index'), 'title' => 'Издержки']    
    ]])
@endsection

@section('content_with-sidebar')

<div class="card mb-4">
  <h1 class="card-header h2">
    Издержка — {{$item->name}} ({{$item->total_cost}} руб)
  </h1>
  <div class="card-body">
    <p>Агент — <a href="{{route('user.show', $item->user_id)}}">{{$item->user->name}}</a></p>
    @if (!empty($item->description))
      <div class="card-text">
        <strong>Комментарий:</strong> {{$item->description}}
      </div>
    @endif
    @include('inc.model-files', ['data' => $item->Files, 'title' => 'Файлы', 'model' => 'outgoing', /* 'model_b64' => base64_encode(get_class($item)), */'model_id' => $item->id, 'removable' => false])
  </div>
</div>

    <div class="card mt-4">
      <h3 class="card-header">
        Состав издержки
        {{-- {!! Form::open(['route' => ['outgoing.create'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'd-inline-block']) !!}
        {{Form::hidden('_method', 'GET')}}
        {{Form::hidden('model_class', base64_encode(get_class($item)))}}
        {{Form::hidden('backroute', route('materialrezerv.show', $item->id))}}
        {{Form::hidden('model_id',$item->id)}}
        {{Form::submit('+ Добавить', ['class' => 'btn btn-sm btn-primary'])}}
        {!! Form::close() !!} --}}
      </h3>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Элемент</th>
                <th scope="col">Сумма, руб</th>
                <th scope="col">Комментарий</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($item->OutgoingCosts as $item_oc)
              <tr>
                <td><a href="{{route($item_oc->outgoingcostable->getClassShortLower().".show", $item_oc->outgoingcostable->id)}}">{{$item_oc->outgoingcostable->name}}</a></td>
                <td>{{$item_oc->cost_rub}}</td>
                <td>{{$item_oc->description}}</td>
                <td>
                  {!! Form::open(['route' => ['outgoingcost.destroy', ['id' => $item_oc->id]], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'd-inline-block']) !!}
                  {{Form::hidden('_method', 'DELETE')}}
                  {{Form::hidden('outgoing_id', $item->id)}}
                  {{Form::submit('Х', ['class' => 'btn btn-danger btn-sm', 'style' => 'font-size: 0.5rem;	padding: 0.125rem 0.25rem;'])}}
                  {!! Form::close() !!}
                </td>
              </tr>
              @endforeach
            </tbody>
            @if (count($item->OutgoingCosts) > 1)
                
            <tfoot>
              <th scope="col">Итого:</th>
              <th scope="col">{{$item->total_cost}}</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tfoot>

            @endif
          </table>
        </div>
        <hr>
        <p>
          Вы можете добавить связанные позиции
          <br>
          <i>Например, если перевозились несколько материалов сразу. Если же требуется добавить несколько издержек к одному материалу, то нужно создавать разные издержки со страницы материала, или другого элемента.</i>
        </p>

        {!! Form::open(['route' => ['outgoingcost.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-row']) !!}

        {{Form::hidden('outgoing_id', $item->id)}}
        {{Form::hidden('outgoingcostable_type', $item->OutgoingCosts->first()->outgoingcostable_type)}}

        <div class="col-3">
          {{Form::select('outgoingcostable_id', $elems_all, '', ['class' => 'form-control', 'placeholder' => 'Выбрать элемент'])}}
        </div>

        <div class="col-2">
          {{Form::number('cost_rub', '', ['class' => 'form-control','placeholder' => 'Сумма в рублях'])}}
        </div>

        <div class="col">
          {{Form::text('description', '', ['class' => 'form-control','placeholder' => 'Комментарий'])}}
        </div>
        
        {{Form::submit('Добавить', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
      </div>
    </div>

  <hr>

  <a href="{{route($template_data['module'].'.edit', $item['id'])}}" class="btn btn-primary">Редактировать</a>





@endsection
