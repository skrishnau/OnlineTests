$(document).ready(function(){
    $(".startTest").on("click", startTest);
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
