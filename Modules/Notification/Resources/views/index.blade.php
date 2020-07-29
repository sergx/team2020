@extends('layouts.app')
@section('content')
 <div class="container">
  @include('inc.breadcrumbs')
  <h1>{{__("common.".$template_data['module']."_title")}}</h1>
  @if(count($items) > 0)
  <ul>
    @foreach ($items as $item)
    @if(count($item->NotificationViews) === 0)
      <li class="mb-3">
        {{--
        {{__('common.'.Str::lower($item->model->class_basename).'_title')}}
        <a href="{{route(Str::lower($item->model->class_basename).".show", $item->model_id)}}">{{$item->model->name}}</a>
        <br>
        --}}
        <small>{{$item->created_at}} {{__($item->options['formal_key'])}}, <a href="{{route("user.show", $item->user_id)}}">{{$item->user->name}}</a></small>
        @if (isset($item->options['old_value']) && isset($item->options['new_value']))
          <ul>
            <li><strong>Старое значение</strong>: {{$item->options['old_value']}}</li>
            <li><strong>Новое значение</strong>: {{$item->options['new_value']}}</li>
          </ul>
        @endif
        {!! Form::open(['route' => ['notification.view_add', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
          {{Form::hidden('user_id', Auth::user()->id)}}
          {{Form::submit('Поменить как прочитано', ['class' => 'btn btn-primary btn-sm ajax_notification'])}}
        {!! Form::close() !!}
      </li>
      @endif
    @endforeach
    
  </ul>
  
  <hr>

  <ul style="opacity:0.6">
    @foreach ($items as $item)
    @if(count($item->NotificationViews) > 0)
      <li class="mb-3">
        {{--
        {{__('common.'.Str::lower($item->model->class_basename).'_title')}}
        <a href="{{route(Str::lower($item->model->class_basename).".show", $item->model_id)}}">{{$item->model->name}}</a>
        <br>
        --}}
        <small>{{$item->created_at}} {{__($item->options['formal_key'])}}, <a href="{{route("user.show", $item->user_id)}}">{{$item->user->name}}</a></small>
        @if (isset($item->options['old_value']) && isset($item->options['new_value']))
        <ul>
          <li><strong>Старое значение</strong>: {{$item->options['old_value']}}</li>
          <li><strong>Новое значение</strong>: {{$item->options['new_value']}}</li>
        </ul>
        @endif
        
        {!! Form::open(['route' => ['notification.view_remove', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
          {{Form::hidden('user_id', Auth::user()->id)}}
          {{Form::submit('Поменить как не прочитано', ['class' => 'btn btn-primary ajax_notification'])}}
        {!! Form::close() !!}
      </li>
      @endif
    @endforeach
  </ul>
  @endif

  {{$items->links()}}

 </div>
 <script>
   /*
  $(".ajax_notification").click(function(event){
    event.preventDefault();
    var form = $(this).closest("form");
    axios.post(form.attr("action"), form.serialize())
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
  });
  */
</script>
@endsection

