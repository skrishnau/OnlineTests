$(document).ready(function(){
    $(".formUserCreate").on("submit", userCreate);
});


function userCreate(e){
    e.preventDefault();
    blockWindow();
    const id = $(this).find("#id").val();
    const name = $(this).find("#name").val();
    const password = $(this).find("#uPassword").val();
    const confirmPassword = $(this).find("#confirmPassword").val();
    if(password!== confirmPassword){
        notify('info', `Password and Confirm-Password do not match.`);
        return;
    }
    const role = $(this).find("#role").val();
    const email = $(this).find("#uEmail").val();
    // post

    let data = {
        "id": id,
        "name": name,
        "password": password,
        "role": role,
        "email": email,
    };
   console.log(data);
    $.post("/user/store", (data), function(response){
        unblockWindow();
        notify(response.status, response.message);
        if(response.status == 'success'){
            location = response.data.redirectUrl;
        } 
    });

}
