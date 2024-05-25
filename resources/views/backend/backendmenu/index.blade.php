@section('title', 'Backend Menus')
@include('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Backend Menus</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Backend Menus</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Backend Menus</h3>
                            @can('Create Backend Menus')
                            <a href="{{ route('backendmenu.create')}}" class="btn btn-primary float-right">Add</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Controller Name</th>
                                        <th class="no_export">Icon</th>
                                        <th class="no_export"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)

                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$row->menu_name}}</td>
                                        <td>{{$row->menu_controller_name}}</td>
                                        <td class="no_export">{{$row->menu_icon}}</td>
                                        <td class="no_export">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @can('Sub Menu Backend Menus')
                                                    @if($row->has_submenu)
                                                    <a class="dropdown-item"
                                                        href="{{route('backendsubmenu.index',['menu_id'=>$row->menu_id])}}">Sub
                                                        Menu</a>
                                                    @endif
                                                    @endcan
                                                    @can('Update Backend Menus')

                                                    <a class="dropdown-item"
                                                        href="{{route('backendmenu.edit',['backendmenu'=>$row->menu_id])}}">Edit</a>

                                                    @endcan

                                                    @can('Delete Backend Menus')

                                                    <form
                                                        action="{{ route('backendmenu.destroy', ['backendmenu' => $row->menu_id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>
                                                    @endcan

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>