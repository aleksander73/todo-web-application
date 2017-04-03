$(document).ready(function() {
    Service.getAllTasks();
    
    $('#btn_Add').on('click', function() {
        window.location.replace('http://localhost/todo_web_application/client_side/ui/views/add.html');
    });
    
    $('#btn_LogOut').on('click', function() {
        Service.logOut();
    });
});