@if(auth()->user()->hasAnyPermission(['delete any '.$template_data['module'],'pre_delete any '.$template_data['module']]))
@foreach ($items as $item)
  @if(!empty($item->pre_deleted))
  <div class="alert alert-primary">
    Есть элементы 
    @if(auth()->user()->can([ 'delete any '.$template_data['module'] ]))
      <a href="{{route($template_data['module'].'.pre-deleted-list')}}">на удаление</a>
    @else
      на удаление
    @endif
  </div>
  @break
  @endif
@endforeach
@endif
