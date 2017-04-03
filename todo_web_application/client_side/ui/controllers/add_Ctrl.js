$(document).ready(function() {
    $('#btn_Back').on('click',function() {
        window.location.replace('http://localhost/todo_web_application/client_side/ui/views/tasks.html');
    });
    
    $('#btn_AddTask').on('click', function() {
        var name = $('#txt_TaskName').val().trim();
        
        // Do not submit the task when its data is corrupted
        if(name == undefined || name == '') {
            alert('Insert the task name, please');
            return;
        }
        
        Service.createTask(name);
    });
});