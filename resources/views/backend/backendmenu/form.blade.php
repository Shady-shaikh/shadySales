@section('title', Request::segment(4) === 'edit' ? 'Edit Backend Menu' : 'Create Backend Menu')

@include('backend.layouts.app')

@section('content')

@php
use App\Models\backend\BasePermission;
$permissions = BasePermission::all();
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Backend Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('backendmenu.index')}}">Backend Menus</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }}
                            Backend Menu</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Menu</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['backendmenu.update', $data->menu_id],
                            'method'
                            => 'PUT']) }}
                            @else
                            {{ Form::open(['route' => 'backendmenu.store']) }}
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('menu_name', 'Menu Name *') }}
                                            {{ Form::text('menu_name', null, ['class' => 'form-control', 'placeholder'
                                            => 'Enter Menu Name', 'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('menu_controller_name', 'Menu Controller Name *') }}
                                            {{ Form::text('menu_controller_name', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Menu Controller Name', 'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('menu_action_name', 'Menu Action Name') }}
                                            {{ Form::text('menu_action_name', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Menu Action Name']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('menu_icon', 'Menu Icon') }}
                                            {{ Form::text('menu_icon', null, ['class' => 'form-control', 'placeholder'
                                            => 'Enter Menu Icon']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        {{ Form::label('has_submenu', 'Has Sub Menus ?') }}
                                        <fieldset>
                                            <div class="radio radio-success">
                                                {{ Form::radio('has_submenu','1',true,['id'=>'radioyes']) }}
                                                {{ Form::label('radioyes', 'Yes') }}
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="radio radio-danger">
                                                {{ Form::radio('has_submenu','0',false,['id'=>'radiono']) }}
                                                {{ Form::label('radiono', 'No') }}
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        {{ Form::label('visibility', 'Show / Hide') }}
                                        <fieldset>
                                            <div class="radio radio-success">
                                                {{ Form::radio('visibility','1',true,['id'=>'radioshow']) }}
                                                {{ Form::label('radioshow', 'Yes') }}
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="radio radio-danger">
                                                {{ Form::radio('visibility','0',false,['id'=>'radiohide']) }}
                                                {{ Form::label('radiohide', 'No') }}
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2 menu_permissions">
                                        {{ Form::label('permissions', 'Menu Permissions *') }}
                                        <ul class="list-unstyled mb-0">
                                            @foreach($permissions as $permission)
                                            <li class="d-inline-block mr-2 mb-1">
                                                <fieldset>
                                                    <div class="checkbox checkbox-primary">
                                                        {{ Form::checkbox('permissions[]',
                                                        $permission->base_permission_id, null,
                                                        ['id'=>'permissions['.$permission->base_permission_id.']']) }}
                                                        {{
                                                        Form::label('permissions['.$permission->base_permission_id.']',
                                                        $permission->base_permission_name) }}
                                                    </div>
                                                </fieldset>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-start">
                                        {{ Form::submit('Save', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                                        <button type="reset"
                                            class="btn btn-light-secondary mr-1 mb-1 text-white">Reset</button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

@section('js')

<script>
    $(document).ready(function()
    {
      $('input[type=radio][name=has_submenu]').change(function()
      {
        // alert(this.value);
        permissions(this.value);
      });
      var sub_per_load = $('input[type=radio][name=has_submenu]:checked').val();
      if (sub_per_load != '')
      {
        // alert(sub_per_load);
          permissions(sub_per_load);
      }
    });
    function permissions(subcat)
    {
      if (subcat == '1')
      {
          $('.menu_permissions').hide();
      }
      else if (subcat == '0')
      {
          $('.menu_permissions').show();
      }
    }
</script>