
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

    toggleDisplay();
    // $(".btnToggleDisplay").on("click", ()=>{
    //     $(".isSingleDisplay").val("true"); 
    //     toggleDisplay(false);
    // });

    if($(".isAnswer").val() == "1"){
        $("input").prop("disabled", "disabled");
        $(".divNextPrevious").remove();
        $(".divSubmit").remove();
    }

    $(".btnStartExam").on("click", startExam);
    
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
    let candidateEmail = $(".candidateEmail").val();
    var isValid = true;
    const candidateId = $(".candidateId").val();
    const startDatetime = $(".startDatetime").val();
    if(!candidateId){
        if(!candidateName){
            isValid = false;
            notify("error", "Name is required");
        }
        if(!candidateEmail){
            isValid = false;
            notify("error", "Email is required");
        }
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
        "candidateName": candidateName,
        "candidateEmail": candidateEmail,
        "candidateId": candidateId,
        "startDatetime": startDatetime,
        "answers": answers,
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
    // group indication
    const groupBtn = $(".divGroupButtons").find(`[data-group="${another.attr("data-group")}"]`);
    if(groupBtn.length > 0){
        $(".divGroupButtons").find(".btnGroup").removeClass("active");
        groupBtn.addClass("active");
    } else {
        $(".divGroupButtons").find(".btnGroup").removeClass("active");
        $(".divGroupButtons").children(":first").addClass("active");
    }

}
function startExam(){
    blockWindow();
    const data = {
        'examId': $(".examId").val()
    };
    $.post('/answer/start', data, function(response){
        notify(response.status, response.message);
        unblockWindow();
        if(response.status != 'success'){
            return;
        }
        $("#startDatetime").val(response.data.startDatetime);
        $(".confirmSection").hide();
        $(".examSection").show();
    })
}
function toggleDisplay(){
    const isSingleDisplay = $(".isSingleDisplay").val() == "true" && $(".isAnswer").val() != "1";
    if(isSingleDisplay == true){
        // show one at a time
        const queSections = $(".queSection").hide();
        $(".divNextPrevious").show();
        $(".divSubmit").hide();
        examNext();
    } else {
        $(".divNextPrevious").hide();
        $(".divSubmit").show();
    }

    $(".examNext").unbind("click").on("click", examNext);
    $(".examPrevious").unbind("click").on("click", examPrevious);
}