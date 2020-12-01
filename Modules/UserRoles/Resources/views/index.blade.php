@extends('layouts.with-sidebar')

@section('head_content')
  @include('inc.breadcrumbs')
@endsection

@section('content_with-sidebar')

<div class="row">
  <div class="col-12 col-sm-6">
    <h2>Permissions</h2>
    <ul>
      @foreach ($permissions as $item)
      <li>
        {{$item->name}}
        @if (count($item->roles))
          <ul>
            @foreach ($item->roles as $role_item)
              <li>{{$role_item->name}}</li>
            @endforeach
          </ul>
        @else
        {!! Form::open(['route' => [$template_data['module'].'.remove-permission',
        ['permission' => $item->id]], 'method' => 'POST', 'class' => 'd-inline-block']) !!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Х', ['class' => 'btn btn-danger btn-sm', 'style' => 'font-size: 0.5rem;	padding: 0.125rem 0.25rem;'])}}
        {!! Form::close() !!}
        @endif
      </li>
      @endforeach
    </ul>

    {{ Form::model($item, ['route' => [$template_data['module'].'.add-permission'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-inline']) }}
    {{ Form::text('permission', "", ['class' => 'form-control','placeholder' => 'Permission']) }}
    <br>
    {{ Form::submit('Add permission', ['class' => 'btn btn-primary ml-3']) }}
    {!! Form::close() !!}

  </div>
  <div class="col-12 col-sm-6">
    <h2>Roles</h2>
    <ul>
      @foreach ($roles as $item)
      <li>
        {{$item->name}} ({{__('common.role_'.$item->name)}})
        <ul>
          @foreach ($item->permissions as $permission_item)
            <li>
              {{$permission_item->name}}
              {!! Form::open(['route' => [$template_data['module'].'.permission-revoke-role',
              ['role_id' => $item->id, 'permission' => $permission_item->id]], 'method' => 'POST', 'class' => 'd-inline-block']) !!}
              {{Form::hidden('_method', 'DELETE')}}
              {{Form::submit('Х', ['class' => 'btn btn-danger btn-sm', 'style' => 'font-size: 0.5rem;	padding: 0.125rem 0.25rem;'])}}
              {!! Form::close() !!}
            </li>
          @endforeach
          <li>
            {{ Form::model($item, ['route' => [$template_data['module'].'.permission-to-role'], 'method' => 'POST', 'class' => 'form-inline']) }}
            {{ Form::hidden('role_id', $item->id) }}
            {{ Form::select('permission', $permissions_pluck, "", ['class' => 'form-control-sm', 'placeholder' => 'Выбрать..'])}}
            {{ Form::submit('Add role', ['class' => 'btn btn-sm btn-primary ml-3']) }}
            {!! Form::close() !!}
          </li>
        </ul>
      </li>
      @endforeach
    </ul>
    {{ Form::model($item, ['route' => [$template_data['module'].'.add-role'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-inline']) }}
    {{ Form::text('role', "", ['class' => 'form-control','placeholder' => 'Role']) }}
    <br>
    {{ Form::submit('Add role', ['class' => 'btn btn-primary ml-3']) }}
    {!! Form::close() !!}
  </div>
</div>


@endsection
