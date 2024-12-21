<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/21/2024
 */
?>

@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/stylesheet/bootstrap-multiselect.css') }}">
@endpush

@section('content')

    <!-- Start Header -->
    <header id="main-header">
        <div class="account">
            <h4 class="text-white p-2" id="user_name_header"></h4>
        </div>
    </header>
    <!-- End Header -->

    <!-- Start Main Content -->
    <section class="container-fluid no-padding">
        <div class="row wrapper no-padding">
            <div class="col-xl-1 col-sm-2">
                <nav class="menu-left">
                    <ul class="list">
                        <li>
                            <a href="#" title="" class="active">
                                <span class="icon flaticon-notepad-1"></span>
                                <span class="text">Tasks</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <span class="icon flaticon-power"></span>
                                <span class="text">Exit</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-xl-11 col-sm-10">
                <div class="main-content">
                    <header class="header-content">
                        <ul class="list list-inline">
                            <li>
                                <div class="filter-priority form-group">
                                    <select class="form-control" name="priority" id="priority" multiple="multiple">
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="filter-status form-group">
                                    <select class="form-control" name="status" id="status" multiple="multiple">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <div class="action">
                            <button class="btn btn-blue">New Task <span class="flaticon-add"></span></button>
                        </div>
                    </header>
                    <div class="dashboard">
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <article class="board red completed_article">
                                    <header>
                                        <h4>Completed <span>(0)</span></h4>
                                    </header>
                                    <div class="board-content">
                                        <ul class="list"></ul>
                                    </div>
                                </article>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <article class="board yellow in_progress_article">
                                    <header>
                                        <h4>In progress <span>(0)</span></h4>
                                        <span class="icon flaticon-more-1"></span>
                                    </header>
                                    <div class="board-content">
                                        <ul class="list"></ul>
                                    </div>
                                </article>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <article class="board green pending_article">
                                    <header>
                                        <h4>Pending <span>(0)</span></h4>
                                        <span class="icon flaticon-more-1"></span>
                                    </header>
                                    <div class="board-content">
                                        <ul class="list"></ul>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Content-->

@endsection

@push('scripts')
    <script src="{{asset('assets/javascript/bootstrap-multiselect.min.js')}}"></script>
    <script src="{{ asset('assets/javascript/min.js') }}"></script>
    <script>
        // Check for JWT token on page load
        document.addEventListener("DOMContentLoaded", function () {
            const token = localStorage.getItem("access_token"); // Replace with sessionStorage if preferred

            if (!token) {
                window.location.href = '{{ route('login') }}';
            } else {
                let user_name_header = $("#user_name_header");
                let user_name = localStorage.getItem("username");
                user_name_header.text(user_name);

                loadTaskData();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var priorities;
            var statuses;

            $('#status').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select Statuses',
                buttonWidth: '100%',
                onChange: function() {
                    statuses = $('#status').val();
                },
                onSelectAll: function () {
                    statuses = $('#status').val();
                },
                onDeselectAll: function () {
                    statuses = $('#status').val();
                }
            });

            $('#priority').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select Priorities',
                buttonWidth: '100%',
                onChange: function() {
                    priorities = $('#priority').val();
                },
                onSelectAll: function () {
                    priorities = $('#priority').val();
                },
                onDeselectAll: function () {
                    priorities = $('#priority').val();
                }
            });
        });
    </script>

    <script>
        // document on load fetch task data
        function loadTaskData(priorities = [], statuses = []) {
            let taskUrl = "{{ route('api.tasks.index') }}";
            let token   = localStorage.getItem("access_token");
            let data = {
                priorities: priorities,
                statuses: statuses
            };

            $.ajax({
                url: taskUrl,
                type: 'POST',
                data: data,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                },
                success: function (response) {
                    if(response.code == 200){
                        addCompletedData(response.data.completed);
                        addInProgressData(response.data.in_progress);
                        addPendingData(response.data.pending);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    </script>
@endpush
