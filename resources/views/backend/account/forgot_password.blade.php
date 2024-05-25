@section('title', 'Forgot Password')
@include('backend.layouts.empty')
@section('content')

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            @include('backend.include.errors')
            {{ Form::open(['route' => 'admin.recover_password']) }}
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                </div>
                <!-- /.col -->
            </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="{{route('admin.login')}}">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>