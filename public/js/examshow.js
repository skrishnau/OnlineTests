$(document).ready(function(){
    $(".startTest").on("click", startTest);
    $(".endTest").on("click", endTest);
    $(".btnStartPaper").on("click", function(){
        $("#startModal").modal("show");
    });
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
