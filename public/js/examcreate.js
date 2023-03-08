
var optionEditors = [];

$(document).ready(function(){

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

    
});