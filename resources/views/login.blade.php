<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/21/2024
 */
?>

    <!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <title> Task </title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Load Stile -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheet/min.css') }}">

    <!-- Meta SEO -->
    <meta name="keyword" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="canonical" href=""/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Start Main Content -->
<section class="container">
    <div class="row ">
        <div class="col-md-6 card mx-auto mt-5 p-4">
            <form action="" >
                <div class="form-group" >
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                </div>

                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                </div>

                <button type="submit" class="btn btn-primary text-black">Login</button>
            </form>
        </div>
    </div>
</section>
<!-- End Main Content-->

<!-- Start Footer -->
<footer>

</footer>
<!-- End Footer -->

<!-- Start Script -->
<script src="{{ asset('assets/javascript/min.js') }}"></script>
</body>
</html>
