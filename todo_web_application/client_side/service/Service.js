function Service() {}

// ---------------------------------------------------

Service.createUser = function(username, password) {
   $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/user/create_user.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "username" : username,
            "password" : password
        },
        success : function(response) {
            bootbox.alert(response['message']);
        }
    });
}

Service.updateUser = function(username, password) {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/user/update_user.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "username" : username,
            "password" : password
        },
        success : function(response) {
            bootbox.alert(response['message']);
        }
    });
}

Service.deleteUser = function(username) {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/user/delete_user.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "username" : username
        },
        success : function(response) {
            bootbox.alert(response['message']);
        }
    });
}

// ---------------------------------------------------

Service.requestLogIn = function(username, password) {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/login/login.php',
        type : 'GET',
        dataType : 'JSON',
        data : {
            "username" : username,
            "password" : password
        },
        success : function(response) {
            var permittedToLogIn = response['permission'];
            if(permittedToLogIn) {
                Service.logIn();
            } else {
                bootbox.alert('Username or password incorrect!');
            }
        }
    });
}

Service.logIn = function() {
    window.location.replace('http://localhost/todo_web_application/client_side/ui/views/tasks.html');
}

Service.logOut = function() {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/login/logout.php',
        type : 'GET',
        dataType : 'JSON',
        success : function(response) {
            var message = response['message'] + ' Redirecting to \'index.html\' page ...';
            bootbox.alert(message, function() {
                window.location.replace('http://localhost/todo_web_application/client_side/ui/views/index.html');
            });
        }
    });
}

// ---------------------------------------------------

Service.createTask = function(name) {
    var task = new Task(name);
    
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/task/create_task.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "task" : task
        },
        success : function(response) {
            window.location.replace('http://localhost/todo_web_application/client_side/ui/views/tasks.html');
        }
    });
}

Service.updateTask = function(id, name) {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/task/update_task.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "id" : id,
            "name" : name
        },
        success : function(response) {
            window.location.replace('http://localhost/todo_web_application/client_side/ui/views/tasks.html');
        }
    });
}

Service.deleteTask = function(id) {
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/task/delete_task.php',
        type : 'POST',
        dataType : 'JSON',
        data : {
            "id" : id
        },
        success : function(response) {
            location.reload();
        }
    });
}

Service.getAllTasks = function() { 
    $.ajax({
        url : 'http://localhost/todo_web_application/server_side/crud/task/get_tasks.php',
        type : 'GET',
        dataType : 'JSON',
        success : function(data){            
            Service.onTaskListReceived(data);
        }
    });
}

Service.onTaskListReceived = function(data) {
    data['tasks'].forEach(function(task) {
        var id = task['ID'];
        var name = task['Name'];
        
        // ---------------------------------------------------
        
        // CHANGES Change the list of tasks to a table (optional)
        
        var htmlBtnEdit = '<button type="button" class="btn btn-link" id="btn_Edit' + id + '">Edit</button>';
        var htmlBtnDelete = '<button type="button" class="btn btn-link" id="btn_Delete' + id + '">Done</button>';

        // Insert new HTML code into the list
        $('#ls_tasks').append('<li>' + name + ' ' + htmlBtnEdit + ' ' + htmlBtnDelete + '</li>');
        
        // ---------------------------------------------------
        
        // Set up eventHandlers
        
        $('#btn_Edit' + id).on('click', function() {
            window.location.replace('http://localhost/todo_web_application/client_side/ui/views/edit.html?id=' + id + '&name=' + toUrlForm(name));
        });
        
        $('#btn_Delete' + id).on('click', function() {
            var message = 'Please, confirm the completition of task \'' + name + '\'.</br><b>Task will be removed and this operation cannot be reversed!</b>';            
            bootbox.confirm(message, function(result){ 
                if(result) {
                    Service.deleteTask(id);   
                }
            });
        });
    });
}