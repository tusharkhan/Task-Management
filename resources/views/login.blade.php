<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/21/2024
 */
?>

@extends("layout.main")

@section("content")

<!-- Start Main Content -->
<section class="container">
    <div class="row ">
        <div class="col-md-6 card mx-auto mt-5 p-4">
            <form id="login_form" method="post">

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="login-form">
                    <h3 class="text-center p-4">Task Management Login</h3>
                    <div class="form-group" >
                        <label for="email">Email: <span class="text-danger">*</span> </label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" autocomplete="off">
                        <span class="text-danger" id="email_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password: <span class="text-danger">*</span> </label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" autocomplete="off">
                        <span class="text-danger" id="pwd_error"></span>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <p>Dont have account ? <a href="{{ route('register') }}">Register here</a> </p>
                    <p>Forgot Password ? <a href="{{ route('forget.password.get') }}">Reset Password</a> </p>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
<!-- End Main Content-->

@push('scripts')
    <script>
        let form = $('#login_form');
        let submitButton = form.find('button[type="submit"]');

        form.on('submit', function (event) {
            event.preventDefault();

            let email = form.find('input[name="email"]').val();
            let pwd = form.find('input[name="pwd"]').val();

            enableSpinnerForButton(submitButton);

            $('#email_error').text('');
            $('#pwd_error').text('');

            if(email === '' || pwd === ''){
                if(email === ''){
                    $('#email_error').text('Email is required');
                }else{
                    $('#email_error').text('');
                }

                if(pwd === ''){
                    $('#pwd_error').text('Password is required');
                }else{
                    $('#pwd_error').text('');
                }

                return;
            }

            $.ajax({
                url: '{{ route('api.login') }}',
                type: 'POST',
                data: {
                    email: email,
                    password: pwd
                },
                success: function (response) {
                    console.log(response);
                    if ( response.code == 200 ){
                        let token = response.data.access_token;
                        let username = response.data.user.name;
                        let userid = response.data.user.id;

                        // store token in local storage
                        localStorage.setItem('access_token', token);
                        localStorage.setItem('username', username);

                        // redirect to dashboard
                        window.location.href = '{{ route('home') }}';
                    }
                },
                error: function (error) {
                    disableSpinnerForButton(submitButton, 'Login');
                    let errorResponse = error.responseJSON;
                    let statusCode = error.status;
                    if(errorResponse.errors){
                        if ( statusCode == 422 ){
                            if(errorResponse.errors.email){
                                $('#email_error').text(errorResponse.errors.email[0]);
                            }else{
                                $('#email_error').text('');
                            }

                            if(errorResponse.errors.password){
                                $('#pwd_error').text(errorResponse.errors.password[0]);
                            }else{
                                $('#pwd_error').text('');
                            }
                        } else if (statusCode == 401){
                            let errorMessage = errorResponse.errors;
                            toastr.error(errorMessage.error);
                        } else {
                            toastr.error("Something went wrong. Please try again later.");
                        }
                    }
                }
            });
        });
    </script>
@endpush
