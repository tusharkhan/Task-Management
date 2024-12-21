var completed_article = $(".completed_article");
var in_progress_article = $(".in_progress_article");
var pending_article = $(".pending_article");


function addCompletedData(data) {
    let span = $(".completed_article header h4 span");
    let ul = $(".completed_article .board-content ul");
    let completedData = data;
    span.text('(' + completedData.length + ')');

    for (let i = 0; i < completedData.length; i++) {
        let task = completedData[i];
        let li = $("<li>").addClass("el");
        let div = $("<div>").addClass("task red");
        let header = $("<header>");
        let h3 = $("<h4>").text(task.title);
        let span = $("<span>").addClass("icon flaticon-link");
        let taskContent = $("<div>").addClass("task-content").text(task.description);

        header.append(h3, span);
        div.append(header, taskContent);
        li.append(div);
        ul.append(li);
    }

}


function addInProgressData(data) {
    let span = $(".in_progress_article header h4 span");
    let ul = $(".in_progress_article .board-content ul");
    let inProgressData = data;
    span.text('(' + inProgressData.length + ')');

    for (let i = 0; i < inProgressData.length; i++) {
        let task = inProgressData[i];
        let li = $("<li>").addClass("el");
        let div = $("<div>").addClass("task yellow");
        let header = $("<header>");
        let h3 = $("<h4>").text(task.title);
        let span = $("<span>").addClass("icon flaticon-link");
        let taskContent = $("<div>").addClass("task-content").text(task.description);

        header.append(h3, span);
        div.append(header, taskContent);
        li.append(div);
        ul.append(li);
    }
}


function addPendingData(data) {
    let span = $(".pending_article header h4 span");
    let ul = $(".pending_article .board-content ul");
    let pendingData = data;
    span.text('(' + pendingData.length + ')');

    for (let i = 0; i < pendingData.length; i++) {
        let task = pendingData[i];
        let li = $("<li>").addClass("el");
        let div = $("<div>").addClass("task green");
        let header = $("<header>");
        let h3 = $("<h4>").text(task.title);
        let span = $("<span>").addClass("icon flaticon-link");
        let taskContent = $("<div>").addClass("task-content").text(task.description);

        header.append(h3, span);
        div.append(header, taskContent);
        li.append(div);
        ul.append(li);
    }
}
