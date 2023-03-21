const EDITOR_OPTION = "editorOption";

var questionEditor;
var optionEditors = {};
$(document).ready(function(){

    initializeEditor("editorQuestion")
        .then(editor => {
            questionEditor = editor;
            // -- hide  loading gif after  a second -- //
            unblockWindow();
            // -- end of hide loading fig -------------//

        });

    initializeMoveOptionButtons();


    $("#addOption").on("click", addQuestion);


    $("#questionCreateForm").on("submit", saveQuestion);
});

function initializeMoveOptionButtons(){
    $(".moveUp").unbind("click").on("click", moveUp);
    $(".moveDown").unbind("click").on("click", moveDown);
    $(".remove").unbind("click").on("click", remove);
}



function remove(){
    var curSN = $(this).closest("tr.optionSection").find(".serialNumber").val();
    var next = $(this).closest("tr.optionSection").next(".optionSection");
    while(next.length > 0){
        let tempSN = next.find(".serialNumber").val();
        next.find(".serialNumber").val(curSN);
        curSN = tempSN;
        next = next.next(".optionSection");
    }
    var $currentRow = $(this).closest("tr.optionSection").remove();
}
function addQuestion(){
    let clone = $("#optionTemplate").find(".optionSection").clone();
    let $optionSections = $("#questionCreateForm").find("." + EDITOR_OPTION).map((index, item)=>{
        return +$(item).attr("data-id");
    }).toArray();
    let lastId = $optionSections.length > 0 ? Math.max(...$optionSections): 0;
    let id = EDITOR_OPTION + (lastId + 1);
    $(clone).find("." + EDITOR_OPTION).prop("id", id);
    $(clone).find("." + EDITOR_OPTION).attr("data-id", lastId + 1);

    // serial Number
    $("#optionTable .optionSection:last-child").find("")

    $("#optionTable").append(clone);
    
    initializeMoveOptionButtons();
    initializeTooltip();
    initializeEditor(id)
        .then(editor => {
            optionEditors[id] = editor;
        });
}
function saveQuestion(e){
    e.preventDefault();
    blockWindow();
    const $form = $(this);
    const id = $form.find("#id")?.val();
    const paperId = $form.find("#paperId")?.val();
    const tag = $form.find("#tag")?.val();
    const group = $form.find("#group")?.val();
    const question = questionEditor.getData();//CKEDITOR.instances['editorQuestion'].getData();
    const options= [];
    $(".optionSection").each((index, value)=> {
        var editorId = $(value).find("." + EDITOR_OPTION).prop("id");
        if(editorId){
            const optionId = $(value).find(".id")?.val() ?? 0;
            const text = optionEditors[editorId].getData();//CKEDITOR.instances[editorId].getData();
            const isCorrect =  $(value).find(".isCorrect").val();
            const serialNumber = $(value).find(".serialNumber").val();
            let answer = {
                "id": optionId,
                "description": text,
                "isCorrect": isCorrect,
                "serialNumber": serialNumber
            };
            options.push(answer);
        }
    });

    let data = {
        "id": id,
        "paperId": paperId,
        "tag": tag,
        "group": group,
        "description": question,
        "options": options
    };

    // console.log(data);
    //disableAllButtons(e.target);
    $.post("/question/store", (data), function(response){
        enableAllButtons(e.target);
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'error'){
            // show error message
        } else {
            window.location = ("/paper/show/" + paperId);
        }
    });
}