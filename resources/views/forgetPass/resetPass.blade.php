<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2024
 */
?>

@extends("layout.main")

@section("content")

    <!-- Start Main Content -->
    <section class="container">
        <div class="row ">
            <div class="col-md-6 card mx-auto mt-5 p-4">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('reset.password.post') }}" method="post">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="login-form">
                        <h3 class="text-center p-4">Change Password</h3>

                        <div class="form-group">
                            <label for="pwd">Password: <span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" autocomplete="off">
                            @if ($errors->has('password'))

                                <span class="text-danger">{{ $errors->first('password') }}</span>

                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password: <span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Enter password" name="password_confirmation" autocomplete="off">
                            @if ($errors->has('password_confirmation'))

                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
