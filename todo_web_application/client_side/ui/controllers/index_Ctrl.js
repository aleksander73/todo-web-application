$(document).ready(function() {
    $('#btn_LogIn').on('click', function() {
        var username = $('#txt_Username').val().trim();
        var password = $('#txt_Password').val().trim();
        
        Service.requestLogIn(username, password);
    });
});