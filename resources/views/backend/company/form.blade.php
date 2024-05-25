@section('title', Request::segment(4) === 'edit' ? 'Edit Company' : 'Create Company')
@include('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Company</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('company.index')}}">Companies</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }}
                            Company</li>
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
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Company
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['company.update', $data->id], 'method'
                            => 'PUT','enctype' => 'multipart/form-data']) }}
                            @else
                            {{ Form::open(['route' => 'company.store','enctype' => 'multipart/form-data']) }}
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">

                                            {{ Form::label('name', 'Company Name *') }}
                                            {{ Form::text('name', Request::segment(4) ===
                                            'edit'?$data->name:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Name',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('email', 'Email *') }}
                                            {{ Form::email('email', Request::segment(4) ===
                                            'edit'?$data->email:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Email',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('phone', 'Company Phone Number *') }}
                                            {{ Form::number('phone', Request::segment(4) ===
                                            'edit'?$data->phone:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Phone Number',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('address_line_1', 'Address Line 1 *') }}
                                            {{ Form::text('address_line_1', Request::segment(4) ===
                                            'edit'?$data->address_line_1:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Address Line 1',
                                            'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('address_line_2', 'Address Line 2') }}
                                            {{ Form::text('address_line_2', Request::segment(4) ===
                                            'edit'?$data->address_line_2:null, ['class' => 'form-control',
                                            'placeholder'=> 'Address Line 2'
                                            ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('landmark', 'Landmark *') }}
                                            {{ Form::text('landmark', Request::segment(4) ===
                                            'edit'?$data->landmark:null, ['class' => 'form-control',
                                            'placeholder'=> 'Landmark',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">

                                            {{ Form::label('country', 'Select Country *') }}
                                            {{
                                            Form::select('country',DB::table('countries')->pluck('country_name','country_id'),
                                            Request::segment(4) ===
                                            'edit'?$data->country:null, ['class' => 'form-control select2',
                                            'required' => true]) }}
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">

                                            {{ Form::label('state', 'Select State *') }}
                                            {{
                                            Form::select('state',[],null, ['class' => 'form-control select2',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">

                                            {{ Form::label('city', 'Select District *') }}
                                            {{
                                            Form::select('city',[],null, ['class' => 'form-control select2',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('city_name', 'City *') }}
                                            {{ Form::text('city_name', Request::segment(4) ===
                                            'edit'?$data->city_name:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter City Name',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('pin_code', 'Pin Code *') }}
                                            {{ Form::number('pin_code', Request::segment(4) ===
                                            'edit'?$data->pin_code:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Pin Code',
                                            'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('gst_no', 'GST No. *') }}
                                            {{ Form::text('gst_no', Request::segment(4) ===
                                            'edit'?$data->pin_code:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter GST No.',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('company_logo', 'Company Logo') }}
                                            {{ Form::file('company_logo', ['class' => 'form-control']) }}
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


@section('js')
@include('backend.components.country_state_city_js')