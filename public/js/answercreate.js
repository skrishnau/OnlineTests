
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

    showTimer();
    const isSingleDisplay =$(".isSingleDisplay").val();
    if(isSingleDisplay == "true"){
        // show one at a time
        const queSections = $(".queSection").hide();
        $(".divNextPrevious").show();
        $(".divSubmit").hide();
        examNext();
    } else {
        $(".divNextPrevious").remove();
        $(".divSubmit").show();
    }

    $(".examNext").on("click", examNext);
    $(".examPrevious").on("click", examPrevious);
    
});

function showTimer(date) {
    setInterval(function(){
        $(".timer").text(new Date().getTime());
    }, 1000);
}

function optionRowClicked() {
    $(this).find("input:radio").prop("checked", true);
}

function examSubmit(){
    blockWindow();
    var $this = $(this);
    var paperId = $(".paperId").val();
    var examId = $(".examId").val();
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
        "examId": examId,
        //"candidateId": candidateId,
        "candidateName": candidateName,
        "candidateEmail": candidateEmail,
        "answers": answers
    };
    $.post("/answer/store", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            location = response.data.redirectUrl;
        } 
    });

}

function examPrevious(){
    moveToAnotherQuestion(-1);
}

function examNext(){
    moveToAnotherQuestion(1);
}

function moveToAnotherQuestion(moveIndex){
    const active = $(".queSection.active");
    const newIndex = active.length == 0 ? 0 : (+active.data("index") + moveIndex);
    const another = $(`.queSection[data-index='${newIndex}'`);
    if(another.length > 0) {
        active.removeClass("active").hide();
        another.show().addClass("active");
    } 
    if($(`.queSection[data-index='${newIndex + 1}'`).length == 0) {
        $(".divSubmit").show();
        $(".examNext").prop("disabled", "disabled");
    } else {
        $(".divSubmit").hide();
        $(".examNext").prop("disabled", "");
    }
    if($(`.queSection[data-index='${newIndex - 1}'`). length == 0) {
        $(".examPrevious").prop("disabled", "disabled");
    } else {
        $(".examPrevious").prop("disabled", "");
    }
}