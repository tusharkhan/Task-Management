<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2024
 */
?>

@extends('layout.main')


@section('content')

    <section class="container">

        <div class="row">

            <div class="col-md-6 card mx-auto mt-5 p-4">

                @if (Session::has('message'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif



                <form action="{{ route('forget.password.post') }}" method="POST">

                    @csrf

                    <div class="login-form">

                        <h3 class="text-center p-4">Reset Password</h3>
                        <div class="form-group" >
                            <label for="email">Email: <span class="text-danger">*</span> </label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" autocomplete="off">
                            @if ($errors->has('email'))

                                <span class="text-danger">{{ $errors->first('email') }}</span>

                            @endif
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">

                        Send Password Reset Link

                    </button>

                </form>

            </div>

        </div>

    </section>

@endsection
