@section('title', Request::segment(4) === 'edit' ? 'Edit Party' : 'Create Party')
@include('backend.layouts.app')
@section('content')
@php
Use App\Models\backend\Company;
Use App\Models\backend\Category;
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Party</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('party.index')}}">Parties</a></li>
                        <li class="breadcrumb-item active">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }}
                            Party</li>
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
                        <h4 class="card-title">{{ Request::segment(4) === 'edit' ? 'Edit' : 'Create' }} Party
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @include('backend.include.errors')
                            @if(Request::segment(4) === 'edit')
                            {{ Form::model($data, ['route' => ['party.update', $data->id], 'method'
                            => 'PUT']) }}
                            @else
                            {{ Form::open(['route' => 'party.store']) }}
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('name', 'Name *') }}
                                            {{ Form::text('name', Request::segment(4) ===
                                            'edit'?$data->name:null, ['class' => 'form-control',
                                            'placeholder'=> 'Enter Name',
                                            'required' => true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('company_id', 'Company *') }}
                                            {{ Form::select('company_id',Company::pluck('name','id'),
                                            Request::segment(4) ===
                                            'edit'?$data->company_id:null, ['class' => 'form-control',
                                            'placeholder'=> 'Select',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('type', 'Type *') }}
                                            {{ Form::select('type',['cus'=>'Customer','ven'=>'Vendor'],
                                            Request::segment(4) ==='edit'?$data->type:null,
                                            ['class' => 'form-control',
                                            'placeholder'=> 'Select',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('category', 'Category *') }}
                                            {{ Form::select('category',Category::pluck('name','id'),
                                            Request::segment(4) ==='edit'?$data->category:null,
                                            ['class' => 'form-control select2',
                                            'placeholder'=> 'Select',
                                            'required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('group', 'Group *') }}
                                            {{ Form::select('group',[],
                                            Request::segment(4) ==='edit'?$data->Group:null,
                                            ['class' => 'form-control select2',
                                            'placeholder'=> 'Select',
                                            'required' => true]) }}
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

{{-- models --}}

{{-- category --}}
<div class="modal fade text-left" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            {{ Form::label('category', "Add Category *") }}
                            {{ Form::text('category', null, [
                            'placeholder' => 'Enter Category',
                            'class' => 'form-control',
                            'id'=>'model_category',
                            'required' => true,
                            ]) }}
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mr-1 mb-1"
                            id="submit_category_modal">Submit</button>
                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- group --}}
<div class="modal fade text-left" id="add_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            {{ Form::label('category', "Category *") }}
                            {{ Form::select('category', [],null, [
                            'placeholder' => 'Select Category',
                            'class' => 'form-control',
                            'id'=>'modal_category',
                            'required' => true,
                            ]) }}
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            {{ Form::label('group', "Group *") }}
                            {{ Form::text('group',null, [
                            'placeholder' => 'Enter Group',
                            'class' => 'form-control',
                            'id'=>'modal_group',
                            'required' => true,
                            ]) }}
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit_group_modal">Submit</button>
                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('js')

<script src="{{ asset('public/backend/js/MasterHandler.js') }}"></script>
<script src="{{ asset('public/backend/js/Dynamicdropdown.js') }}"></script>



<script>
    $(document).ready(function(){

        $(document).on('click', 'button[data-id="#add_group_modal"]', function() {
            var category = $('#category').val();
            new DynamicDropdown('{{ route('admin.get_category') }}',
              category, '#modal_category');
        });

    });



    $('#category').on('change', function(){
        new DynamicDropdown('{{ route('admin.get_group') }}',
            $(this).val(), '#group');
    });
               
    new MasterHandler('#category', '#add_category_modal', '#submit_category_modal',
        "{{ route('admin.store_category') }}",null,'#model_category');

    new MasterHandler('#group', '#add_group_modal', '#submit_group_modal',
        "{{ route('admin.store_group') }}",null,'#modal_category','#modal_group');
</script>