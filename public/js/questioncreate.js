const EDITOR_OPTION = "editorOption";

var questionEditor;
var optionEditors = {};
$(document).ready(function(){

    initializeEditor("editorQuestion")
        .then(editor => {
            questionEditor = editor;
        });

    initializeMoveOptionButtons();


    $("#addOption").on("click", function(){
        let clone = $("#optionTemplate").find(".optionSection").clone();
        let $optionSections = $("#questionCreateForm").find("." + EDITOR_OPTION).map((index, item)=>{
            return +$(item).attr("data-id");
        }).toArray();
        let lastId = $optionSections.length > 0 ? Math.max(...$optionSections): 0;
        let id = EDITOR_OPTION + (lastId + 1);
        $(clone).find("." + EDITOR_OPTION).prop("id", id);
        $(clone).find("." + EDITOR_OPTION).attr("data-id", lastId + 1);
        $("#optionTable").append(clone);
       
        initializeMoveOptionButtons();
        initializeTooltip();
        initializeEditor(id)
            .then(editor => {
                optionEditors[id] = editor;
            });
    });


    $("#questionCreateForm").on("submit", function(e){
        e.preventDefault();
        const $form = $(this);
        const tag = $form.find("#tag")?.val();
        const group = $form.find("#group")?.val();
        const type = $form.find("#type")?.val();
        const question = questionEditor.getData();//CKEDITOR.instances['editorQuestion'].getData();
        const options= [];
        $(".optionSection").each((index, value)=> {
            var editorId = $(value).find("." + EDITOR_OPTION).prop("id");
            if(editorId){
                const text = optionEditors[editorId].getData();//CKEDITOR.instances[editorId].getData();
                const isCorrect =  $(value).find(".isCorrect").val();
                let answer = {
                    "description": text,
                    "isCorrect": isCorrect
                };
                options.push(answer);
            }
        });

        let data = {
            "tag": tag,
            "group": group,
            "type": type,
            "description": question,
            "options": options
        };

        //console.log(data);
        disableAllButtons(e.target);
        $.post("/question/store", (data), function(response){
            console.log("response", response);
            enableAllButtons(e.target);
        });


    });
});

function initializeMoveOptionButtons(){
    $(".moveUp").unbind("click").on("click", moveUp);
    $(".moveDown").unbind("click").on("click", moveDown);
    $(".remove").unbind("click").on("click", remove);
}

function moveUp(){
    var $currentRow = $(this).closest("tr.optionSection");
    var prev = $currentRow.prev(".optionSection");
    if(prev){
        $(prev).before($currentRow);
    }
}

function moveDown(){
    var $currentRow = $(this).closest("tr.optionSection");
    var next = $currentRow.next(".optionSection");
    if(next){
        $(next).after($currentRow);
    }
}

function remove(){
    var $currentRow = $(this).closest("tr.optionSection").remove();
}