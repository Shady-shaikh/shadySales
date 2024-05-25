@section('title', Request::segment(4) === 'edit' ? 'Edit Admin Users' : 'Create Admin Users')
@include('backend.layouts.app')
@section('content')
@php
use Spatie\Permission\Models\Role;
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Admin User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Admin Users</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }}
                            Admin User</li>
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
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Admin User
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['users.update', $data->id], 'method'
                            => 'PUT','enctype' => 'multipart/form-data']) }}
                            @else
                            {{ Form::open(['route' => 'users.store','enctype' => 'multipart/form-data']) }}
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('first_name', 'First Name *') }}
                                            {{ Form::text('first_name', Request::segment(4) ===
                                            'edit'?$data->first_name:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter First Name',
                                            'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('last_name', 'Last Name') }}
                                            {{ Form::text('last_name', Request::segment(4) ===
                                            'edit'?$data->last_name:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Last Name']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('email', 'Email *') }}
                                            {{ Form::email('email', Request::segment(4) ===
                                            'edit'?$data->email:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Email',
                                            'required'=>true
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('mobile_no', 'Phone') }}
                                            {{ Form::number('mobile_no', Request::segment(4) ===
                                            'edit'?$data->mobile_no:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Mobile Number',
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('role_id', 'Role *') }}
                                            {{ Form::select('role_id',Role::pluck('name','id'), Request::segment(4) ===
                                            'edit'?$data->role_id:null, ['class' => 'form-control',
                                            'placeholder'=>'Select Role',
                                            'required'=>true,
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('profile_pic', 'Profile Photo') }}
                                            {{ Form::file('profile_pic', ['class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('password', 'Password' .(Request::segment(4)
                                            ==='edit'?'':'*')) }}
                                            {{ Form::password('password', ['class' => 'form-control',
                                            'placeholder'=>'Enter your password',
                                            'required'=>Request::segment(4)==='edit'?false:true,
                                            ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('password_confirmation', 'Confirm
                                            Password'.(Request::segment(4)
                                            ==='edit'?'':'*')) }}
                                            {{ Form::password('password_confirmation', ['class' => 'form-control',
                                            'placeholder'=>'Enter Confirm Password',
                                            'required'=>Request::segment(4)==='edit'?false:true,
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('account_status', 'Status') }}
                                            {{ Form::select('account_status',['1'=>'Active','2'=>'In-Active'], null,
                                            ['class' => 'form-control']) }}
                                        </div>
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