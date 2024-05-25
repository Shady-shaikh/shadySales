@section('title', Request::segment(4) === 'edit' ? 'Edit Role' : 'Create Role')
@include('backend.layouts.app')

@section('content')
<style>
    .menu_permissions {
        padding-top: 32px !important;
    }
</style>
@php

use App\Models\backend\BackendMenubar;
use Spatie\Permission\Models\Role;
use App\Models\backend\BackendSubMenubar;
use App\Models\backend\BasePermission;
use Spatie\Permission\Models\Permission;


// $user_id = Auth()->guard('admin')->user()->id;

$backend_menubar = BackendMenubar::Where(['visibility'=>1])->orderBy('sort_order')->get();

$view_permission = BasePermission::where(DB::raw('LOWER(base_permission_name)'), 'LIKE', 'view')
->where('guard_name', Auth::guard()->name)
->first();
$view_permission_id = $view_permission->base_permission_id;
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('role.index')}}">Roles</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Role
                        </li>
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
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Role</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['role.update', $data->id], 'method'
                            => 'PUT']) }}
                            @else
                            {{ Form::open(['route' => 'role.store']) }}
                            @endif
                            {{ csrf_field() }}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            {{ Form::label('name', 'Role Name *') }}
                                            {{ Form::select('name',
                                            DB::table('deapartment')->pluck('name','id'),$data->department_id??null,
                                            ['class' =>
                                            'form-control',
                                            'placeholder' => 'Select
                                            Role Name',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            {{ Form::label('parent_roles', 'Parent Role (If Required) ') }}
                                            {{ Form::select('parent_roles',
                                            Role::pluck('name', 'id'),
                                            $data->parent_roles??null, ['class'
                                            => 'form-control
                                            select2','placeholder'=>'Select Parent Role']) }}
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12 mt-2 mb-2">
                                        <div class="form-label-group">
                                            {{ Form::checkbox('readonly', null, null, ['id'=>'readonly']) }}
                                            {{ Form::label('readonly', 'Select All For Read Only *') }}
                                            <span class="px-2">
                                                {{ Form::checkbox('readwrite', null, null, ['id'=>'readwrite']) }}
                                                {{ Form::label('readwrite', 'Select All For Read/Write *') }}
                                            </span>

                                        </div>
                                    </div>



                                    @foreach($backend_menubar as $menu)

                                    <div class="col-md-12 col-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card " style="background-color: #babfc73d !important;">
                                                    @if($menu->has_submenu == 1)
                                                    @php

                                                    if(!empty($data)){
                                                    $backend_menu_permission = explode(',',$data->menu_ids);
                                                    $backend_submenu_permission = explode(',',$data->submenu_ids);
                                                    }else{
                                                    $backend_menu_permission=[];
                                                    $backend_submenu_permission=[];
                                                    $has_permissions = [];
                                                    }
                                                    $backend_submenubar =
                                                    BackendSubMenubar::Where(['menu_id'=>$menu->menu_id])->get();
                                                    @endphp
                                                    @if($backend_submenubar)
                                                    <div class="card-header "
                                                        style="background-color: #babfc73d !important;">
                                                        <h4 class="card-title">
                                                            <div class="checkbox checkbox-primary">
                                                                {{ Form::checkbox('menu_id[]', $menu->menu_id,
                                                                in_array($menu->menu_id,$backend_menu_permission)??null,
                                                                ['id'=>'menu['.$menu->menu_id.']','class' =>
                                                                'menu-checkbox']) }}
                                                                {{ Form::label('menu['.$menu->menu_id.']',
                                                                $menu->menu_name) }}
                                                            </div>
                                                        </h4>
                                                    </div>
                                                    @endif

                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach($backend_submenubar as $submenu)
                                                            <div class="col-md-6 col-12">
                                                                <div class="card-group">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h3 class="card-title">
                                                                                <div class="checkbox checkbox-primary">
                                                                                    {{
                                                                                    Form::checkbox('submenu_id[]',
                                                                                    $submenu->submenu_id,
                                                                                    in_array($submenu->submenu_id,$backend_submenu_permission)??null,
                                                                                    ['id'=>'submenu['.$menu->menu_id.']['.$submenu->submenu_id.']',
                                                                                    'class'=>'submenu-checkbox',
                                                                                    'data-menu'=>$menu->menu_id])
                                                                                    }}
                                                                                    {{
                                                                                    Form::label('submenu['.$menu->menu_id.']['.$submenu->submenu_id.']',
                                                                                    $submenu->submenu_name) }}
                                                                                </div>
                                                                            </h3>
                                                                            <div
                                                                                class="col-md-12 col-12 mt-2  menu_permissions">
                                                                                <ul class="list-unstyled mb-0">
                                                                                    <?php
                                                                                        $backend_permission =
                                                                                        explode(',',$submenu->submenu_permissions);
                                                                                        $permissions =
                                                                                        Permission::where('menu_id',$menu->menu_id)->where('submenu_id',$submenu->submenu_id)->get();
                                                                                        $permissions =
                                                                                        collect($permissions)->mapWithKeys(function
                                                                                        ($item, $key) {
                                                                                        return
                                                                                        [$item['base_permission_id'] =>
                                                                                        ['id'=>$item['id'],'name'=>$item['name']]];
                                                                                        });
                                                                                        // dd($permissions);
                                                                                        
                                                                                        foreach($backend_permission as
                                                                                        $permission){
                                                                                        if(!$permissions->isEmpty()){
                                                                                        ?>
                                                                                    <li
                                                                                        class="d-inline-block mr-2 mb-1">
                                                                                        <fieldset>
                                                                                            <div
                                                                                                class="checkbox checkbox-primary">
                                                                                                @php
                                                                                                $class='';
                                                                                                if($permission ==
                                                                                                $view_permission_id){
                                                                                                $class = 'viewonly';
                                                                                                }
                                                                                                @endphp
                                                                                                {{
                                                                                                Form::checkbox('permissions['.$permissions[$permission]['id'].']',
                                                                                                $permissions[$permission]['id'],
                                                                                                in_array($permissions[$permission]['id'],$has_permissions)??null,
                                                                                                ['id'=>'permissions['.$permissions[$permission]['id'].']','class'=>$class])
                                                                                                }}
                                                                                                {{
                                                                                                Form::label('permissions['.$permissions[$permission]['id'].']',
                                                                                                $permissions[$permission]['name'])
                                                                                                }}
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </li>
                                                                                    <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @else

                                                            <div class="col-md-12">
                                                                <h4 class="card-title">
                                                                    <div class="checkbox checkbox-primary">
                                                                        {{ Form::checkbox('menu_id[]',
                                                                        $menu->menu_id, null,
                                                                        ['id'=>'menu['.$menu->menu_id.']']) }}
                                                                        {{ Form::label('menu['.$menu->menu_id.']',
                                                                        $menu->menu_name) }}
                                                                    </div>
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-6 col-12 mt-2 menu_permissions">
                                                                <ul class="list-unstyled mb-0">
                                                                    <?php
                                                                        $backend_permission =
                                                                        explode(',',$menu->permissions);
                                                                        $permissions =
                                                                        Permission::where('menu_id',$menu->menu_id)->get();
                                                                        $permissions =
                                                                        collect($permissions)->mapWithKeys(function
                                                                        ($item, $key) {
                                                                        return
                                                                        [$item['base_permission_id'] =>
                                                                        ['id'=>$item['id'],'name'=>$item['name']]];
                                                                        });
                                                                        // dd($permissions);
                                                                        foreach($backend_permission as
                                                                        $permission){
                                                                        if(isset($permissions[$permission])){
                                                                        ?>
                                                                    <li class="d-inline-block mr-2 mb-1">
                                                                        <fieldset>
                                                                            <div class="checkbox checkbox-primary">
                                                                                @php
                                                                                $class='';
                                                                                if($permission ==
                                                                                $view_permission_id){
                                                                                $class = 'viewonly';
                                                                                }
                                                                                @endphp

                                                                                {{
                                                                                Form::checkbox('permissions['.$permissions[$permission]['id'].']',
                                                                                $permissions[$permission]['id'],
                                                                                null,
                                                                                ['id'=>'permissions['.$permissions[$permission]['id'].']','class'=>$class])
                                                                                }}
                                                                                {{
                                                                                Form::label('permissions['.$permissions[$permission]['id'].']',
                                                                                $permissions[$permission]['name'])
                                                                                }}
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <?php
                                                                                }
                                                                            }
                                                                        ?>

                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                                    </div>

                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Get all menu checkboxes
    const menuCheckboxes = document.querySelectorAll('.menu-checkbox');

    // Loop through each menu checkbox
    menuCheckboxes.forEach(function(checkbox) {
        // Add change event listener
        checkbox.addEventListener('change', function() {
            // Get the menu ID
            const menuId = checkbox.value;
            // Get all corresponding submenu checkboxes
            const submenuCheckboxes = document.querySelectorAll('input[name="submenu_id[]"][data-menu="' + menuId + '"]');
            // Loop through submenu checkboxes and update their checked status
            submenuCheckboxes.forEach(function(submenuCheckbox) {
                submenuCheckbox.checked = checkbox.checked;
                // Trigger change event on submenu checkbox to update its permissions
                submenuCheckbox.dispatchEvent(new Event('change'));
            });
        });
    });

    // Get all submenu checkboxes
    const submenuCheckboxes = document.querySelectorAll('.submenu-checkbox');

    // Loop through each submenu checkbox
    submenuCheckboxes.forEach(function(submenuCheckbox) {
        // Add change event listener
        submenuCheckbox.addEventListener('change', function() {
            // Get the parent container of the submenu checkbox
            const parentContainer = submenuCheckbox.closest('.card-body');
            // Get all permission checkboxes within the parent container
            const permissionCheckboxes = parentContainer.querySelectorAll('.menu_permissions input[type="checkbox"]');
            // Loop through permission checkboxes and update their checked status
            permissionCheckboxes.forEach(function(permissionCheckbox) {
                permissionCheckbox.checked = submenuCheckbox.checked;
            });
        });
    });
});


    
    $("#readwrite").on("click", function(){
        if (this.checked) { 
          $('input:checkbox').not('#readonly').prop('checked', true);
          $('#readonly').prop('checked', false);                    
        }else{
          $('input:checkbox').not('#readonly').prop('checked', false);    
        }
    });
  
    $("#readonly").on("click", function(){
      if (this.checked) { 
        $('.viewonly').not('#readonly').prop('checked', true); 
        $('input:checkbox').not('.viewonly').not('#readonly').prop('checked', false); 
        $('#readwrite').prop('checked', false);                   
        }else{
          $('.viewonly').not('#readonly').prop('checked', false);    
        }
    });
</script>