@section('title', 'Backend Sub Menus')
@include('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Backend Sub Menus</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('backendmenu.index')}}">Backend Menus</a></li>
                        <li class="breadcrumb-item active">Backend Sub Menus</li>
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
                            <h3 class="card-title">Backend Sub Menus</h3>
                            <a href="{{ route('backendsubmenu.create',['menu_id'=>request('menu_id')])}}"
                                class="btn btn-primary float-right">Add</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Controller Name</th>
                                        <th class="no_export"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)

                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$row->submenu_name}}</td>
                                        <td>{{$row->submenu_controller_name}}</td>
                                        <td class="no_export">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item"
                                                        href="{{route('backendsubmenu.edit',['backendsubmenu'=>$row->submenu_id,'menu_id'=>request('menu_id')])}}">Edit</a>
                                                    <form
                                                        action="{{ route('backendsubmenu.destroy', ['backendsubmenu' => $row->submenu_id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>

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