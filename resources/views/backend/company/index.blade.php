@section('title', 'Companies')
@include('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Companies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Companies</li>
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
                            <h3 class="card-title">Companies</h3>
                            @can('Create Companies')
                            <a href="{{ route('company.create')}}" class="btn btn-primary float-right">Add</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="no_export">Logo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                        <th>Pin Code</th>
                                        <th class="no_export"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)

                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td class="no_export">
                                            @if(isset( $row->company_logo))
                                            <a href="{{asset('public/company_profile/' . $row->company_logo)}}"
                                                target="_blank"><img
                                                    src="{{asset('public/company_profile/' . $row->company_logo)}}"
                                                    alt="profile photo" width="80px"></a>
                                            @endif
                                        </td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>
                                            @php
                                            $states = DB::table('states')->where('state_id',$row->state)->first();
                                            @endphp
                                            {{$states->state_name}}
                                        </td>
                                        <td>{{$row->pin_code}}</td>
                                        <td class="no_export">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @can('Update Companies')

                                                    <a class="dropdown-item"
                                                        href="{{route('company.edit',['company'=>$row->id])}}">Edit</a>
                                                    @endcan

                                                    @can('Delete Companies')
                                                    <form
                                                        action="{{ route('company.destroy', ['company' => $row->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>

                                                    @endcan
                                                    @can('View Basic Permission')
                                                    <a class="dropdown-item"
                                                        href="{{route('company.show',['company'=>$row->id])}}">View</a>
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