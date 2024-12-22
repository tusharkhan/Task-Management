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
                                        <span class="icon flaticon-more-1"></span>
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
                                        <span class="icon flaticon-more-1"></span>
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
                                <h5 id="span_status"> Status :<span class="badge badge-primary">Primary</span> </h5>
                                <h5 id="span_priority">Priority :<span class="badge badge-secondary">Secondary</span></h5>
                                <h5 id="span_date">Due Date :<span class="badge badge-dark">Success</span></h5>
                            </div>
                            <hr>
                            <p class="card-text" id="task_des">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
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
        // Check for JWT token on page load
        document.addEventListener("DOMContentLoaded", function () {
            const token = localStorage.getItem("access_token");

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
                    loadTaskData(priorities, statuses);
                },
                onSelectAll: function () {
                    statuses = $('#status').val();
                    loadTaskData(priorities, statuses);
                },
                onDeselectAll: function () {
                    statuses = $('#status').val();
                    loadTaskData(priorities, statuses);
                }
            });

            $('#priority').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select Priorities',
                buttonWidth: '100%',
                onChange: function() {
                    priorities = $('#priority').val();
                    loadTaskData(priorities, statuses);
                },
                onSelectAll: function () {
                    priorities = $('#priority').val();
                    loadTaskData(priorities, statuses);
                },
                onDeselectAll: function () {
                    priorities = $('#priority').val();
                    loadTaskData(priorities, statuses);
                }
            });
        });
    </script>

    <script>
        // document on load fetch task data
        function loadTaskData(priorities = [], statuses = []) {
            let span_completed = $(".completed_article header h4 span");
            let ul_completed = $(".completed_article .board-content ul");

            let span_in_progress = $(".in_progress_article header h4 span");
            let ul_in_progress = $(".in_progress_article .board-content ul");

            let span_pending = $(".pending_article header h4 span");
            let ul_pending = $(".pending_article .board-content ul");

            let taskUrl = "{{ route('api.tasks.index') }}";
            let token   = localStorage.getItem("access_token");

            // data array send as json
            let data = {
                priorities: priorities,
                statuses: statuses
            };

            console.log(data)

            $.ajax({
                url: taskUrl,
                type: 'POST',
                data: JSON.stringify(data),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                },
                success: function (response) {
                    if(response.code == 200){
                        span_completed.text('(0)');
                        ul_completed.empty();

                        span_in_progress.text('(0)');
                        ul_in_progress.empty();

                        span_pending.text('(0)');
                        ul_pending.empty();

                        let completed = response.data.completed;
                        let in_progress = response.data.in_progress;
                        let pending = response.data.pending;

                        if( completed ) addCompletedData(response.data.completed);
                        if(in_progress) addInProgressData(response.data.in_progress);
                        if(pending) addPendingData(response.data.pending);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    </script>

    <script>
        let logout = $("#logout");

        logout.on('click', function (){
            const token = localStorage.getItem("access_token");

            let logoutUrl = "{{ route('api.logout') }}";

            $.ajax({
                url: logoutUrl,
                type: 'POST',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                success: function (response) {

                },
                error: function (error) {
                    console.log(error);
                }
            });

            if( token ) {
                deleteAll();
                window.location.href = '{{ route('login') }}';
            }
        });
    </script>

    <script>
        var createTaskModalCenter = $("#createTaskModalCenter");
        var modalTitle = $("#exampleModalLongTitle");
        var create_delete_button = $("#create_delete_button");

        createTaskModalCenter.on('hide.bs.modal', function (event) {
            modalTitle.text('Create Task');
            create_delete_button.text('Create Task');
            $("#title").val('');
            $("#dueDate").val('');
            $("#description").val('');
            $("#inputState").val('');
            $("#inputPriority").val('');
            $("#gridCheck").prop('checked', false);
            $("#task_id").val('');
            $("#action_type").val('create');
        });

        function createUpdateModal(){
            let title = $("#title").val();
            let dueDate = $("#dueDate").val();
            let description = $("#description").val();
            let status = $("#inputState").val();
            let priority = $("#inputPriority").val();
            let is_completed = $("#gridCheck").is(":checked");
            let action_type = $("#action_type").val();

            let token = localStorage.getItem("access_token");

            let taskUrl = "{{ route('api.tasks.store') }}";
            let method = 'POST';

            if(action_type == 'update'){
                let id = $("#task_id").val();
                taskUrl = "{{ route('api.tasks.update', ':id') }}";
                taskUrl = taskUrl.replace(':id', id);
                method = 'PUT';
            } else {
                $("#title").val('');
                $("#dueDate").val('');
                $("#description").val('');
                $("#inputState").val('');
                $("#inputPriority").val('');
                $("#gridCheck").prop('checked', false);

                modalTitle.text('Create Task');
                create_delete_button.text('Create Task');
            }


            let data = {
                title: title,
                due_date: dueDate,
                description: description,
                status: status,
                priority: priority,
                is_completed: is_completed
            };

            $.ajax({
                url: taskUrl,
                type: method,
                data: JSON.stringify(data),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                },
                success: function (response) {
                    if(response.code == 201 || response.code == 200){
                        loadTaskData();
                        if(action_type == 'update'){
                            toastr.info(response.message);
                        } else {
                            toastr.success(response.message);
                        }
                        createTaskModalCenter.modal('hide');
                    }
                },
                error: function (error) {
                    let errorResponse = error.responseJSON;
                    let statusCode = error.status;

                    if(statusCode == 422){
                        let errors = errorResponse.errors;
                        let titleError = errors.title ? errors.title[0] : '';
                        let dueDateError = errors.due_date ? errors.due_date[0] : '';
                        let descriptionError = errors.description ? errors.description[0] : '';
                        let statusError = errors.status ? errors.status[0] : '';
                        let priorityError = errors.priority ? errors.priority[0] : '';

                        $("#title_error").text(titleError);
                        $("#due_date_error").text(dueDateError);
                        $("#description_error").text(descriptionError);
                        $("#status_error").text(statusError);
                        $("#priority_error").text(priorityError);
                    } else if(statusCode == 401){
                        toastr.error("Unauthorized access");
                        window.location.href = '{{ route('login') }}';
                    } else {
                        toastr.error("Something went wrong");
                    }
                }
            });

            return false;
        }
    </script>

    <script>
        function deleteTask(id){
            let token = localStorage.getItem("access_token");
            let taskUrl = "{{ route('api.tasks.destroy', ':id') }}";
            taskUrl = taskUrl.replace(':id', id);

            $.ajax({
                url: taskUrl,
                type: 'DELETE',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                success: function (response) {
                    if(response.code == 200){
                        toastr.warning(response.message);
                        loadTaskData();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>

    <script>
        function editTask(id){
            createTaskModalCenter.modal('show');
            let token = localStorage.getItem("access_token");
            let showUrl = "{{ route('api.tasks.show', ':id') }}";
            showUrl = showUrl.replace(':id', id);

            $.ajax({
                url: showUrl,
                type: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                success: function (response) {
                    if(response.code == 200){
                        let task = response.data;
                        let title = task.title;
                        let dueDate = task.due_date;
                        let description = task.description;
                        let status = task.status;
                        let priority = task.priority;
                        let is_completed = task.is_completed;

                        $("#title").val(title);
                        $("#dueDate").val(dueDate);
                        $("#description").val(description);
                        $("#inputState").val(status);
                        $("#inputPriority").val(priority);
                        $("#gridCheck").prop('checked', is_completed);
                        $("#task_id").val(id);
                        $("#action_type").val('update');

                        modalTitle.text('Edit Task');
                        create_delete_button.text('Update Task');
                    }
                },
                error: function (error) {
                    let statusCode = error.status;
                    if(statusCode == 401){
                        toastr.error("Unauthorized access");
                        deleteAll();
                        window.location.href = '{{ route('login') }}';
                    } else {
                        toastr.error("Something went wrong while fetching task data");
                    }

                }
            });
        }
    </script>

    <script>
        function showTask(id){
            let viewTaskModalCenter = $("#viewTaskModalCenter");
            let token = localStorage.getItem("access_token");
            let showUrl = "{{ route('api.tasks.show', ':id') }}";
            showUrl = showUrl.replace(':id', id);
            viewTaskModalCenter.modal('show');

            $.ajax({
                url: showUrl,
                type: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                success: function (response) {
                    if(response.code == 200) {
                        let task = response.data;
                        let title = task.title;
                        let dueDate = task.due_date;
                        let description = task.description;
                        let status = task.status;
                        let priority = task.priority;
                        let is_completed = task.is_completed;

                        let showTaskModalLongTitle = $("#showTaskModalLongTitle");
                        showTaskModalLongTitle.text("Title :" + title);

                        let date = new Date(dueDate);
                        dueDate = date.toDateString();


                        let span_status = $("#span_status");
                        let span_priority = $("#span_priority");
                        let span_date = $("#span_date");
                        let task_des = $("#task_des");

                        // empty all
                        span_status.empty();
                        span_priority.empty();
                        span_date.empty();
                        task_des.empty();


                        let badgeClass = 'primary';
                        if(priority == 'low'){
                            badgeClass = 'secondary';
                        } else if(priority == 'medium'){
                            badgeClass = 'warning';
                        } else if(priority == 'high'){
                            badgeClass = 'danger';
                        }
                        let priorityText = '<span class="badge badge-'+ badgeClass +'" >'+ priority +'</span>'
                        span_priority.append('Priority : ' + priorityText);

                        badgeClass = 'red';
                        if(status == 'pending'){
                            badgeClass = 'green';
                        } else if(status == 'in_progress'){
                            badgeClass = 'yellow';
                        } else if(status == 'completed'){
                            badgeClass = 'red';
                        }

                        status = status.replace('_', ' ').toUpperCase();

                        let statusText = '<span class="badge badge-'+ badgeClass +'" >'+ status +'</span>'
                        span_status.append('Status : ' + statusText);

                        span_date.append('Due Date : ' + '<span class="badge badge-dark">'+ dueDate +'</span>');
                        task_des.append(description);


                    }
                },
                error: function (error) {
                    let statusCode = error.status;
                    if(statusCode == 401){
                        toastr.error("Unauthorized access");
                        deleteAll();
                        window.location.href = '{{ route('login') }}';
                    } else {
                        toastr.error("Something went wrong while fetching task data");
                    }
                }
            });
        }
    </script>
@endpush
