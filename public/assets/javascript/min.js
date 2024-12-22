var completed_article = $(".completed_article");
var in_progress_article = $(".in_progress_article");
var pending_article = $(".pending_article");
var logout = $("#logout");

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

logout.on('click', function (){
    const token = localStorage.getItem("access_token");

    let logout = logoutUrl();

    $.ajax({
        url: logout,
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
        logoutAndRedirect();
    }
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

    let taskUrl = taskCreateUrl();
    let method = 'POST';

    if(action_type == 'update'){
        let id = $("#task_id").val();
        taskUrl = taskUpdateUrl(id);

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
                loginUrl();
            } else {
                toastr.error("Something went wrong");
            }
        }
    });

    return false;
}

function deleteTask(id){
    let token = localStorage.getItem("access_token");
    let taskUrl = taskDeleteUrl(id);


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

function editTask(id){
    createTaskModalCenter.modal('show');
    let token = localStorage.getItem("access_token");
    let showUrl = taskShowUrl(id);

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
                logoutAndRedirect();
            } else {
                toastr.error("Something went wrong while fetching task data");
            }

        }
    });
}

function showTask(id){
    let viewTaskModalCenter = $("#viewTaskModalCenter");
    let token = localStorage.getItem("access_token");
    let showUrl = taskShowUrl(id);
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
                logoutAndRedirect();
            } else {
                toastr.error("Something went wrong while fetching task data");
            }
        }
    });
}

function loadTaskData(priorities = [], statuses = []) {
    let span_completed = $(".completed_article header h4 span");
    let ul_completed = $(".completed_article .board-content ul");

    let span_in_progress = $(".in_progress_article header h4 span");
    let ul_in_progress = $(".in_progress_article .board-content ul");

    let span_pending = $(".pending_article header h4 span");
    let ul_pending = $(".pending_article .board-content ul");

    let taskUrl = taskListUrl();
    let token   = localStorage.getItem("access_token");

    // data array send as json
    let data = {
        priorities: priorities,
        statuses: statuses
    };

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

function addCompletedData(data) {
    let span = $(".completed_article header h4 span");
    let ul = $(".completed_article .board-content ul");
    let completedData = data;
    span.text('(' + completedData.length + ')');
    ul.empty();

    for (let i = 0; i < completedData.length; i++) {
        let task = completedData[i];
        let list = createList(task, "red");

        ul.append(list);
    }
}


function addInProgressData(data) {
    let span = $(".in_progress_article header h4 span");
    let ul = $(".in_progress_article .board-content ul");
    let inProgressData = data;
    span.text('(' + inProgressData.length + ')');
    ul.empty();

    for (let i = 0; i < inProgressData.length; i++) {
        let task = inProgressData[i];
        let li = createList(task, "yellow");
        ul.append(li);
    }
}


function addPendingData(data) {
    let span = $(".pending_article header h4 span");
    let ul = $(".pending_article .board-content ul");
    let pendingData = data;
    span.text('(' + pendingData.length + ')');
    ul.empty();

    for (let i = 0; i < pendingData.length; i++) {
        let task = pendingData[i];
        let li = createList(task, "green");
        ul.append(li);
    }
}


function createList(data, color){
        let task = data;
        let li = $("<li>").addClass("el");
        let taskdiv = $("<div>").addClass("task " + color);
        let rowDiv = $("<div>").addClass("row");
        let firstCol = $("<div>").addClass("col-12");
        let rowDiv2 = $("<div>").addClass("row");
        let secondCol = $("<div>").addClass("col-9");
        let h3 = $("<h3 class='cursor-pointer' onclick='showTask("+data.id+")' >").text(task.title);
        let thirdCol = $("<div>").addClass("col-3");
        let ul = $("<ul>").addClass("action_icon_ul");
        let editLi = $("<li class='cursor-pointer' onclick='editTask("+ data.id +")'>").addClass("icon flaticon-edit");
        let deleteLi = $("<li class='cursor-pointer' onclick='deleteTask("+ data.id +")'>").addClass("icon flaticon-garbage text-danger");
        let fourthCol = $("<div>").addClass("col-12");
        let taskContent = $("<div>").addClass("task-content").text(task.description);

        ul.append(editLi, deleteLi);
        thirdCol.append(ul);
        secondCol.append(h3);
        rowDiv2.append(secondCol, thirdCol);
        firstCol.append(rowDiv2);
        fourthCol.append(taskContent);
        rowDiv.append(firstCol, fourthCol);
        taskdiv.append(rowDiv);
        li.append(taskdiv);

        return li;
}
