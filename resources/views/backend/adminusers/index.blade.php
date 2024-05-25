@section('title', 'Admin Users')
@include('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Admin Users</li>
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
                            @can('Create Admin Users')
                            <a href="{{ route('users.create')}}" class="btn btn-primary float-right">Add</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="no_export"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>
                                            <a href="{{asset('public/admin_user_profile/' . $row->profile_pic)}}"
                                                target="_blank"><img
                                                    src="{{asset('public/admin_user_profile/' . $row->profile_pic)}}"
                                                    alt="profile photo" width="80px"></a>
                                        </td>
                                        <td>{{$row->full_name}}</td>

                                        <td>{{$row->email}}</td>
                                        <td>{{$row->userrole->name}}</td>
                                        <td class="no_export">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @can('Update Admin Users')

                                                    <a class="dropdown-item"
                                                        href="{{route('users.edit',['user'=>$row->id])}}">Edit</a>
                                                    @endcan

                                                    @can('Delete Admin Users')

                                                    <form action="{{ route('users.destroy', ['user' => $row->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>
                                                    @endcan
{{-- 
                                                    @can('View Admin Users')
                                                    <a class="dropdown-item"
                                                        href="{{route('users.show',['user'=>$row->id])}}">View</a>
                                                    @endcan --}}
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