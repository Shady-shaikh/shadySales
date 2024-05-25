@section('title', 'Login-SS')
@include('backend.layouts.empty')
@section('content')

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Shady</b>Sales</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Please login to access your account</p>
            @include('backend.include.errors')
            {{ Form::open(['route' => 'admin.auth_user']) }}

            <div class="input-group mb-3">
                {{ Form::text('email',null, ['class' => 'form-control',
                'placeholder'
                => 'Email', 'required' => true,'autocomplete'=>'off']) }}
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                {{ Form::password('password', ['class' => 'form-control',
                'placeholder'=> 'Password', 'required' => true,'autocomplete'=>'off']) }}
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
                <!-- /.col -->
            </div>
            {{ Form::close() }}


            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="{{route('admin.forgot_password')}}">I forgot my password</a>
            </p>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@section('js')
<script>
    $(document).ready(function() {

        // Check if remember token cookie exists
        var rememberToken = "{{ $rememberToken }}";
        if (rememberToken) {
            // Split the remember token into email and password
            var credentials = rememberToken.split('|');
            // Populate email and password fields
            $('#email').val(credentials[0]);
            $('#password').val(credentials[1]);
            // Check the Remember Me checkbox
            $('#remember').prop('checked', true);
        }
    });
</script>