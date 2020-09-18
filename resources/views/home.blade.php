@extends('layouts.app')

@section('content')
<div class="container">
  @include('inc.breadcrumbs')
  <div id="app">
    <example-component></example-component>
  </div>
</div>
@endsection
