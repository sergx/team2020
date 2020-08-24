<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{route('index')}}">На главую</a></li>
   @if (!empty($breadcrumb_items))
      @foreach ($breadcrumb_items as $breadcrumb_item)
        <li class="breadcrumb-item"><a href="{{$breadcrumb_item['href']}}">{{$breadcrumb_item['title']}}</a></li>
      @endforeach
   @endif
  </ol>
 </nav>
