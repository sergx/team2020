<li class="list-group-item">
  <ul class="list-group">
    @foreach ($items as $item)
    {{-- https://quickadminpanel.com/blog/laravel-how-to-make-menu-item-active-by-urlroute/ --}}
      @if (request()->is($model_key.'/'. $item->id))
        <li class="list-group-item active"><span>{!!$item->name!!}</span></li>
      @else
        <li class="list-group-item {{ (request()->is($model_key.'/'. $item->id)) ? 'active' : ''}}"><a href="{{ route($model_key.'.show', ['id' => $item->id]) }}">{!!$item->name!!}</a></li>
      @endif
    @endforeach
  </ul>
</li>
