$(document).ready(function(){
    $(".startTest").on("click", startTest);
    $(".endTest").on("click", endTest);
    $(".btnStartExam").on("click", function(){
        $("#startModal").modal("show");
    });
    $(".btnAddStudents").on("click", addStudents);
    $(".btnStudentsSelected").on("click", studentsSelected);

});


function startTest(){
    blockWindow();
    var data = {
        'examId': $("#examId").val()
    };
    $.post("/exam/startTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#startModal').modal('hide'); 
            $(".btnStartExam").remove();
            $(".btnEndExam").show();
            $(".btnAddStudents").hide();
            $(".lblStartDatetime").text(response.data.startDatetime);
            removeAllActionButtons();
        } 
    });
}

function endTest(){
    blockWindow();
    var data = {
        'examId': $("#examId").val()
    };
    $.post("/exam/endTest", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#endModal').modal('hide'); 
            // hide both buttons
            $(".btnStartExam").remove();
            $(".btnEndExam").remove();
            $(".lblEndDatetime").text(response.data.endDatetime);
        } 
    });
}
function removeAllActionButtons(){
    $(".addQuestion, .editQuestion, .moveUp, .moveDown, .remove").remove();
}
function addStudents(){
    $(".tblStudentList").html('');
    $("#studentListModal").modal("show");
    blockWindow();
    const examId = $("#examId").val();
    $.get( `/exam/getAllStudents/${examId}`, function( response ) {
        console.log(response);
        if(response.status != 'success'){
            notify(response.status, response.message);
            return;
        }
        response.data.forEach((item)=>{
            //$(".divStudentList").append("Ram");
            $(".tblStudentList").append(`<tr><td><input class="chkStudent" ${item.isCandidate ? 'checked="checked"':''} type="checkbox" data-id="${item.id}" name="std_${item.id}" value="${item.name}"></td>
            <td>${item.name}</td>
            <td>${item.email}</td>
            </tr>`);
        })
    }).always(function(){
        unblockWindow();
    });
}
function studentsSelected(){
    const examId = $("#examId").val();
    const data = {
        students: [],
        examId
    };
    $(".chkStudent").each((index, item) => {
        if($(item).is(':checked')){
            data.students.push($(item).attr('data-id'));
        }
    })
    console.log(data);
    $.post("/exam/addStudents", (data), function(response){
        unblockWindow();
        console.log(response);
        notify(response.status, response.message);
        if(response.status == 'success'){
            $('#studentListModal').modal('hide'); 
            // refresh the page
            location.reload();
        } 
    });
}