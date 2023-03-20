
var optionEditors = [];

$(document).ready(function(){

    $(".optionRow").on("click", optionRowClicked);

    if($(".editorAnswer").length == 0){
        unblockWindow();
    }
    $(".editorAnswer").each((index, value)=>{
        let id = $(value).prop("id");
        // initializeEditor(id)
        initializeClassicEditor(id)
            .then(editor => {
                optionEditors[id] = editor;

                // -- hide  loading gif after  a second -- //
                unblockWindow();
                // -- end of hide loading fig -------------//
            });
    });

    $(".examSubmit").on("click", examSubmit);
    
});

function optionRowClicked(){
    $(this).find("input:radio").prop("checked", true);
}

function examSubmit(){
    blockWindow();
    var $this = $(this);
    var paperId = $(".paperId").val();
    let candidateName = $(".candidateName").val();
    //let candidateId = $(".candidateId").val();
    let candidateEmail = $(".candidateEmail").val();
    var isValid = true;
    if(!candidateName){
        isValid = false;
        notify("error", "Name is required");
    }
    if(!candidateEmail){
        isValid = false;
        notify("error", "Email is required");
    }

    if(!isValid){
        unblockWindow();
        return;
    }
    var answers = [];
    var unfilledQuestions = [];
    $(".questionRow").each((index, value) => {
        debugger;
        let questionId = $(value).find(".questionId").val();
        let answerText = null;
        let optionId = null;
        if($(`input[name="que_${questionId}"]`).length > 0){
            optionId = $(`input[name="que_${questionId}"]:checked`).val();
            if(!optionId){
                isValid = false;
                unfilledQuestions.push($(value).find(".serialNumber").val());
            }
        } else {
            let editorId = $(value).find(".editorAnswer").prop("id");
            answerText = optionEditors[editorId].getData();
            if(!answerText){
                isValid = false;
                unfilledQuestions.push($(value).find(".serialNumber").val());
            }
        }
        answers.push({
            "questionId": questionId,
            "optionId": optionId,
            "answerText": answerText
        });
    });
    
    if(!isValid){
        notify("error", "Unfilled Question No.: " + unfilledQuestions.join(", "));
        unblockWindow();
        return;
    }
    let data = {
        "paperId": paperId,
        //"candidateId": candidateId,
        "candidateName": candidateName,
        "candidateEmail": candidateEmail,
        "answers": answers
    };
    $.post("/exam/store", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            location = response.data.redirectUrl;
        } 
    });

}