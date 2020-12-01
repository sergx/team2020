@extends('layouts.with-sidebar')

@section('container_open')
@endsection

@section('head_content')
@endsection

@section('with_sidebar')
<div id="app">
  <resource-edit></resource-edit> {{-- Не важно как называется - все равно выводиться App --}}
</div>
@endsection

@section('container_close')
@endsection

@section('bottom_script')
  @parent
  <script src="{{ mix('js/modxresource.js') }}"></script>
@endsection
