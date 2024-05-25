@section('title', Request::segment(4) === 'edit' ? 'Edit Backend Sub Menu' : 'Create Backend Sub Menu')

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
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Backend Sub Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('backendmenu.index')}}">Backend Menus</a></li>
                        <li class="breadcrumb-item"><a href="{{route('backendsubmenu.index',['menu_id'=>request('menu_id')])}}">Backend Sub Menus</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }}
                            Backend Sub Menu</li>
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
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Sub Menu</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['backendsubmenu.update', $data->submenu_id],
                            'method'
                            => 'PUT']) }}
                            @else
                            {{ Form::open(['route' => 'backendsubmenu.store']) }}
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-label-group">
                                            <input type="hidden" name="menuId" value="{{request('menu_id')}}">
                                            <input type="hidden" name="submenu_id" value="{{$data->submenu_id??''}}">
                                            {{ Form::label('submenu_name', 'Sub Menu Name *') }}
                                            {{ Form::text('submenu_name', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Sub Menu Name', 'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-label-group">
                                            {{ Form::label('submenu_controller_name', 'Sub Menu Controller Name *') }}
                                            {{ Form::text('submenu_controller_name', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Sub Menu Controller Name', 'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-label-group">
                                            {{ Form::label('submenu_action_name', 'Sub Menu Action Name') }}
                                            {{ Form::text('submenu_action_name', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Sub Menu Action Name']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('menu_id', 'Menu') }}
                                            {{ Form::select('menu_id', $menu_list, request()->menu_id,
                                            ['class'=>'select2 form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
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
                                        {{ Form::label('submenu_permissions', 'Menu Permissions *') }}
                                        <ul class="list-unstyled mb-0">
                                            @php
                                            //$backend_permission = explode(',',$backendsubmenu->submenu_permissions);
                                            @endphp
                                            @foreach($permissions as $permission)
                                            <li class="d-inline-block mr-2 mb-1">
                                                <fieldset>
                                                    <div class="checkbox checkbox-primary">
                                                        {{ Form::checkbox('submenu_permissions[]',
                                                        $permission->base_permission_id, null,
                                                        ['id'=>'submenu_permissions['.$permission->base_permission_id.']'])
                                                        }}
                                                        {{
                                                        Form::label('submenu_permissions['.$permission->base_permission_id.']',
                                                        $permission->base_permission_name) }}
                                                    </div>
                                                </fieldset>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-start">
                                        {{ Form::submit('Save', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1 text-white">Reset</button>
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