const UP = "up";
const DOWN = "down";

$(document).ready(function(){
    $(".startTest").on("click", startTest);
    $(".endTest").on("click", endTest);
    $(".moveUp, .moveDown").on("click", moveSection);
    $(".remove").on("click", function(){
        $("#questionDeleteModal .questionId").val($(this).closest(".movableSection").find(".questionId").val());
        $("#questionDeleteModal").modal("show");
    });
    $(".deleteQuestion").on("click", deleteQuestion);
});

function startTest(){
    blockWindow();
    var data = {
        'paperId': $("#paperId").val()
    };
    $.post("/paper/startTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#startModal').modal('hide'); 
            $(".btnStartPaper").remove();
            $(".btnEndPaper").show();
            $(".lblStartDatetime").text(response.data.startDatetime);
            removeAllActionButtons();
        } 
    });
}

function endTest(){
    blockWindow();
    var data = {
        'paperId': $("#paperId").val()
    };
    $.post("/paper/endTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#endModal').modal('hide'); 
            // hide both buttons
            $(".btnStartPaper").remove();
            $(".btnEndPaper").remove();
            $(".lblEndDatetime").text(response.data.endDatetime);
        } 
    });
}
function removeAllActionButtons(){
    $(".addQuestion, .editQuestion, .moveUp, .moveDown, .remove").remove();
}

function moveSection(e){
    var action = $(e.target).hasClass("moveUp") ? UP : $(e.target).hasClass("moveDown") ? DOWN : "";
    let canMove = action == UP ? canMoveUp(e) : action == DOWN ? canMoveDown(e) : false;
    if(!canMove){
        return;
    }
    blockWindow();
    let data = {
        'id': $(e.target).closest(".movableSection").find(".questionId").val(),
        'action': action
    };
    $.post("/question/updateSerialNumber", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            if(action ==  UP){
                moveUp(e);
            } else if(action == DOWN){
                moveDown(e);
            }
        } 
    });
}
function deleteQuestion(e) {
    blockWindow();
    var id = $("#questionDeleteModal .questionId").val();
    let data = {
        'id': id,
    };
    $.post('/question/destroy', data, function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            var base_id = "#questionRow";
            var next = $(base_id + id).next();
            var serialNumber = $(base_id + id).find(".serialNumber").val();
            $(base_id + id).remove();
            $("#questionDeleteModal").modal("hide");
            while(next.length > 0){
                var tempSN = next.find(".serialNumber").val();
                next.find(".serialNumber").val(serialNumber);
                next.find(".serialNumberText").text(serialNumber);

                serialNumber = tempSN;
                next = next.next();
            }
        }
    });
}