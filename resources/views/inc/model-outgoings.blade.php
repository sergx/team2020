<div class="card mt-4 mb-4">
  <h3 class="card-header">
    Издержки
    {!! Form::open(['route' => ['outgoing.create'], 'method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'd-inline-block']) !!}
    {{Form::hidden('model_class', base64_encode(get_class($item)))}}
    {{Form::hidden('model_id',$item->id)}}
    {{Form::submit('+ Добавить', ['class' => 'btn btn-sm btn-primary'])}}
    {!! Form::close() !!}
  </h3>
  @if (count($item->OutgoingCosts))
  <div class="card-body">
    <div class="card-text">
        <ul>
          @foreach ($item->OutgoingCosts as $elem)
          <li>
          <strong>
            <a href="{{route('outgoing.show', $elem->outgoing_id)}}">{{$elem->Outgoing->name}}</a>
          </strong>
          <br>
          <strong>{{$elem->cost_rub}} руб</strong>
          @if (count($elem->Outgoing->OutgoingCosts) > 1)
            / <i>Составная издержка, общая цена — </i> <strong>{{$elem->Outgoing->total_cost}} руб</strong>
          @endif
          <br>
          @if ($elem->description)
            <div>{{$elem->description}}</div>
          @endif
        </li>
          @endforeach
        </ul>
    </div>
  </div>
  @endif
</div>
