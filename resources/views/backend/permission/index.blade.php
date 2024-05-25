@section('title', 'Base Permissions')
@include('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Base Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Base Permissions</li>
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
                            <h3 class="card-title">Base Permissions</h3>
                            @can('Create Basic Permission')
                            <a href="{{ route('permission.create')}}" class="btn btn-primary float-right">Add</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th class="no_export"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)

                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$row->base_permission_name}}</td>
                                        <td>{{$row->guard_name}}</td>
                                        <td class="no_export">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @can('Update Basic Permission')

                                                    <a class="dropdown-item"
                                                        href="{{route('permission.edit',['permission'=>$row->base_permission_id])}}">Edit</a>
                                                    @endcan

                                                    @can('Delete Basic Permission')
                                                    <form
                                                        action="{{ route('permission.destroy', ['permission' => $row->base_permission_id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>

                                                    @endcan
                                                    @can('View Basic Permission')
                                                    <a class="dropdown-item"
                                                        href="{{route('permission.show',['permission'=>$row->base_permission_id])}}">View</a>
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