
$(document).ready(function(){

console.log(CKEDITOR);
    // CKEDITOR.ClassicEditor.ready('instanceReady', function(evt){
    //     console.log("instance is ready");
    // });
    initializeEditor("editorQuestion");

    $(".moveUp").on("click", moveUp);


    $("#addOption").on("click", function(){
        let clone = $("#optionTemplate").find(".answerSection").clone();
        let $optionSections = $("#questionCreateForm").find(".editorAnswer").map((index, item)=>{
            return +$(item).attr("data-id");
        }).toArray();
        let lastId = $optionSections.length > 0 ? Math.max(...$optionSections): 0;
        let id = "editorAnswer" + (lastId + 1);
        $(clone).find(".editorAnswer").prop("id", id);
        $(clone).find(".editorAnswer").attr("data-id", lastId + 1);
        $("#answerTable").append(clone);
        $(".moveUp").unbind("click").on("click", moveUp);
        initializeEditor(id);
    });


    $("#questionCreateForm").on("submit", function(e){
        e.preventDefault();
        const $form = $(this);
        const tag = $form.find("#tag")?.val();
        const group = $form.find("#group")?.val();
        const type = $form.find("#type")?.val();
        const question = CKEDITOR.instances['editorQuestion'].getData();
        const options= [];
        $(".answerSection").each((value, index, array)=> {
            const text = CKEDITOR.instances[$(value).find(".editorAnswer").prop("id")].getData();
            const isCorrect =  $(value).find(".isCorrect").val();
            let answer = {
                "description": text,
                "isCorrect": isCorrect
            };
            options.push(answer);
        });

        let data = {
            "tag": tag,
            "group": group,
            "type": type,
            "description": question,
            "options": options
        };

        console.log(data);

    });
});

function moveUp(){
    debugger;
    var upper = $(this).closest("tr").prev();
    if(upper){
        $(upper).insertBefore($(this).closest("tr"));
    }
}