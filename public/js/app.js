
$(document).ready(function(){
    initializeTooltip();

    // global ajax setup, need to include csrf token in every post request, hence added header (globally)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});


function initializeTooltip(){
    $('[title]').tooltip();
}

function disableAllButtons(container){
    $(container).find("button, a").attr("disabled", true);
}

function enableAllButtons(container){
    $(container).find("button, a").attr("disabled", false);
}