$(document).ready(function(){
    $(".formExamCreate").on("submit", examCreate);
});


function examCreate(e){
    e.preventDefault();
    const name = $(this).find(".name").val();
    const type = $(this).find(".type").val();
    const paperId = $(this).find(".paperId").val();
    // post
    let data = {
        "paperId": paperId,
        "course": name,
        "type": type,
    };
    $.post("/exam/store", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            location = response.data.redirectUrl;
        } 
    });

}
