var completed_article = $(".completed_article");
var in_progress_article = $(".in_progress_article");
var pending_article = $(".pending_article");


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
        let h3 = $("<h3>").text(task.title);
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
