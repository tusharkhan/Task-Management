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
                            <a href="{{ route('home') }}" title="" class="active">
                                <span class="icon flaticon-notepad-1"></span>
                                <span class="text">Tasks</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="" id="logout">
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
                            <button class="btn btn-blue" data-toggle="modal" data-target="#createTaskModalCenter">New Task <span class="flaticon-add"></span></button>
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
                                        <ul class="list">
                                            <div class="d-flex justify-content-center align-items-center vh-100">
                                                <div class="spinner-border text-danger" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <article class="board yellow in_progress_article">
                                    <header>
                                        <h4>In progress <span>(0)</span></h4>
                                    </header>
                                    <div class="board-content">
                                        <ul class="list">
                                            <div class="d-flex justify-content-center align-items-center vh-100">
                                                <div class="spinner-border text-warning" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <article class="board green pending_article">
                                    <header>
                                        <h4>Pending <span>(0)</span></h4>
                                    </header>
                                    <div class="board-content">
                                        <ul class="list">
                                            <div class="d-flex justify-content-center align-items-center vh-100">
                                                <div class="spinner-border text-green" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </ul>
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


    <!-- Save or edit Task -->
    <div class="modal fade bd-example-modal-lg" id="createTaskModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="task_create_delete_form" onsubmit="return createUpdateModal(this)" >
                    <input type="hidden" id="action_type" value="create">
                    <input type="hidden" id="task_id" value="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="title" placeholder="Title">
                                <span class="text-danger" id="title_error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dueDate">Due Date <span class="text-danger">*</span> </label>
                                <input type="date" class="form-control" id="dueDate" placeholder="Due Date">
                                <span class="text-danger" id="due_date_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span> </label>
                            <textarea type="text" class="form-control" id="description" placeholder="1234 Main St"> </textarea>
                            <span class="text-danger" id="description_error"></span>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Select Status <span class="text-danger">*</span> </label>
                                <select id="inputState" name="status" class="form-control">
                                    <option selected disabled>Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <span class="text-danger" id="status_error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputPriority">Priority <span class="text-danger">*</span> </label>
                                <select id="inputPriority" name="priority" class="form-control">
                                    <option selected disabled>Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <span class="text-danger" id="priority_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" name="is_completed" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    Mark as Completed
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="create_delete_button">Create Task</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="viewTaskModalCenter" tabindex="-1" role="dialog" aria-labelledby="showTaskModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showTaskModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show_task_modal_body">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 id="span_status">  </h5>
                                <h5 id="span_priority"></h5>
                                <h5 id="span_date"></h5>
                            </div>
                            <hr>
                            <p class="card-text" id="task_des"></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{asset('assets/javascript/bootstrap-multiselect.min.js')}}"></script>
    <script src="{{ asset('assets/javascript/min.js') }}"></script>

    <script>
        let user_name_header = $("#user_name_header");
        let user_name = localStorage.getItem("username");
        user_name_header.text(user_name);

        loadTaskData();
    </script>

@endpush
