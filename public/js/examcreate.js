
var optionEditors = [];

$(document).ready(function(){
    $(".editorAnswer").each((index, value)=>{
        let id = $(value).prop("id");
        // initializeEditor(id)
        initializeClassicEditor(id)
            .then(editor => {
                optionEditors[id] = editor;
            });
    });

    
});