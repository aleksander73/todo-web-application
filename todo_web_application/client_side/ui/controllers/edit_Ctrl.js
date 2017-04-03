$(document).ready(function() {
    var id = getUrlParameter('id');
    var name = toNormalForm(getUrlParameter('name'));
    
    $('#txt_TaskName').val(name);
    
    // ----------------------------------------------------------
    
    $('#btn_Back').on('click',function() {
        window.location.replace('http://localhost/todo_web_application/client_side/ui/views/tasks.html');
    });
    
    $('#btn_Save').on('click', function() {
        var name = $('#txt_TaskName').val().trim();
        
        // Do not edit the task when its data is corrupted
        if(name == undefined || name == '') {
            alert('Insert all of the values, please');
            return;
        }
        
        Service.updateTask(id, name);
    });
});