$(document).ready(function(){
    $(".startTest").on("click", startTest);
    $(".endTest").on("click", endTest);
    $(".btnStartExam").on("click", function(){
        $("#startModal").modal("show");
    });
});


function startTest(){
    blockWindow();
    var data = {
        'examId': $("#examId").val()
    };
    $.post("/exam/startTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#startModal').modal('hide'); 
            $(".btnStartExam").remove();
            $(".btnEndExam").show();
            $(".lblStartDatetime").text(response.data.startDatetime);
            removeAllActionButtons();
        } 
    });
}

function endTest(){
    blockWindow();
    var data = {
        'examId': $("#examId").val()
    };
    $.post("/exam/endTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#endModal').modal('hide'); 
            // hide both buttons
            $(".btnStartExam").remove();
            $(".btnEndExam").remove();
            $(".lblEndDatetime").text(response.data.endDatetime);
        } 
    });
}
function removeAllActionButtons(){
    $(".addQuestion, .editQuestion, .moveUp, .moveDown, .remove").remove();
}
