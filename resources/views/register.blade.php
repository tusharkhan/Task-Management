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
            <form id="register_form" method="post">
                <div id="alert-register"></div>
                <div class="login-form">
                    <h3 class="text-center p-4">Task Management Registration</h3>
                    <div class="form-group" >
                        <label for="name">Name: <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" autocomplete="off">
                        <span class="text-danger" id="name_error"></span>
                    </div>

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

                    <button type="submit" id="register_button" class="btn btn-primary">Register</button>
                    <p>Already have account ? <a href="{{ route('login') }}">Login here</a> </p>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
<!-- End Main Content-->

@push('scripts')
    <script>
        var form = $('#register_form');
        var submitButton = form.find('button[type="submit"]');

        form.on('submit', function (event) {
            event.preventDefault();

            let email = form.find('input[name="email"]').val();
            let name = form.find('input[name="name"]').val();
            let pwd = form.find('input[name="pwd"]').val();

            enableSpinnerForButton(submitButton);

            $('#email_error').text('');
            $('#pwd_error').text('');
            $('#name_error').text('');

            if(email === '' || pwd === '' || name === ''){
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

                if(name === ''){
                    $('#name_error').text('Name is required');
                }else{
                    $('#name_error').text('');
                }

                return;
            }

            $.ajax({
                url: '{{ route('api.register') }}',
                type: 'POST',
                data: {
                    email: email,
                    password: pwd,
                    name: name
                },
                success: function (response) {
                    if ( response.code == 201 ){
                        $('#alert-register').html('<div class="alert alert-primary alert-dismissible fade show" role="alert"> \n' +
                            '<strong>Success!</strong> Check your email to verify your account. \n' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>');
                        {{--let token = response.data.access_token;--}}
                        {{--let username = response.data.user.name;--}}
                        {{--// store token in local storage--}}
                        {{--localStorage.setItem('access_token', token);--}}
                        {{--localStorage.setItem('username', username);--}}

                        {{--// redirect to dashboard--}}
                        {{--window.location.href = '{{ route('home') }}';--}}
                    }
                },
                error: function (error) {
                    disableSpinnerForButton(submitButton, 'Register');
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

                            if( errorResponse.errors.name ){
                                $('#name_error').text(errorResponse.errors.name[0]);
                            } else {
                                $('#name_error').text('');
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
