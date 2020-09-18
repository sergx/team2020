@extends('layouts.app')
@section('content')
@section('container_open')
  <div class="container"> <!-- container_open -->
@show
@section('head_content')
  <!-- head_content -->
@show
@section('with_sidebar')
  <div class="row">
    <div class="col-12 col-md-8 col-lg-9">
      @yield('content_with-sidebar')
    </div>
    <div class="col-12 col-md-4 col-lg-3">
      @include('chunk.nav-side')
    </div>
  </div>
@show
@section('container_close')
  </div> <!-- container_close -->
@show

@endsection
