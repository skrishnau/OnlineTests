
$(document).ready(function(){
    initializeTooltip();

    // global ajax setup, need to include csrf token in every post request, hence added header (globally)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // setTimeout(() => {
    //     unblockWindow();
    // }, 500); 
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

function blockWindow(){
    $(".loadingBackground").show();
}

function unblockWindow(){
    $(".loadingBackground").hide();
}

// https://notifyjs.jpillora.com/
function notify(status, message){
    $.notify(message, status);
}


// ---------- Movable sections' MoveUP and MoveDown actions ---------------- //
function moveUp(e){
    var $this = e ? $(e.target) : $(this);
    var $currentRow = $this.closest("tr.movableSection");
    var prev = $currentRow.prev(".movableSection");
    if(prev){
        debugger;
        var curSN = $currentRow.find(".serialNumber").val();
        var prevSN = prev.find(".serialNumber").val();
        
        $currentRow.find(".serialNumber").val(prevSN);
        $currentRow.find(".serialNumberText").text(prevSN);

        prev.find(".serialNumber").val(curSN);
        prev.find(".serialNumberText").text(curSN);

        $(prev).before($currentRow);
        return true;
    }
    return false;
}

function canMoveUp(e){
    var $this = e ? $(e.target) : $(this);
    var $currentRow = $this.closest("tr.movableSection");
    return $currentRow.prev(".movableSection").length > 0;
}

function moveDown(e){
    var $this = e ? $(e.target) : $(this);
    var $currentRow = $this.closest("tr.movableSection");
    var next = $currentRow.next(".movableSection");
    if(next){
        var curSN = $currentRow.find(".serialNumber").val();
        var nextSN = next.find(".serialNumber").val();

        $currentRow.find(".serialNumber").val(nextSN);
        $currentRow.find(".serialNumberText").text(nextSN);

        next.find(".serialNumber").val(curSN);
        next.find(".serialNumberText").text(curSN);

        $(next).after($currentRow);
        return true;
    }
    return false;
}

function canMoveDown(e){
    var $this = e ? $(e.target) : $(this);
    var $currentRow = $this.closest("tr.movableSection");
    return $currentRow.next(".movableSection").length > 0;
}
