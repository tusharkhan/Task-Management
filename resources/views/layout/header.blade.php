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
    <link rel="stylesheet" href="{{ asset('assets/stylesheet/toastr.min.css') }}">

    @stack('css')

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

    <script>
        const token = localStorage.getItem("access_token");
        let currentUrl = window.location.href;
        // remove last slash
        currentUrl = currentUrl.replace(/\/$/, "");

        if( currentUrl == "{{route('home')}}" ){
            if (!token) {
                window.location.href = '{{ route('login') }}';
            }
        } else if (
            currentUrl == "{{route('login')}}" ||
            currentUrl == "{{route('register')}}" ||
            currentUrl == "{{route('forget.password.get')}}"
        ){
            if (token) {
                window.location.href = '{{ route('home') }}';
            }
        }
    </script>

</head>
<body>
