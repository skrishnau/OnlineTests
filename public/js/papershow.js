const UP = "up";
const DOWN = "down";

$(document).ready(function(){
    $(".startTest").on("click", startTest);
    $(".moveUp, .moveDown").on("click", moveSection);
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
            $('#exampleModal').modal('hide'); 
            $(".testLink").text(response.data.linkUrl);
            $(".testLink").show();
        } 
    });

}

function moveSection(e){
    var action = $(e.target).hasClass("moveUp") ? UP : $(e.target).hasClass("moveDown") ? DOWN : "";
    debugger;
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