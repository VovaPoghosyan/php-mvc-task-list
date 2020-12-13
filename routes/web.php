<?PHP

// Define base route
Route::add('/', 'Task@getAllTasks', 'get');

Route::add('/login', 'Auth@showLogin', 'get');
Route::add('/login', 'Auth@login', 'post');
Route::add('/logout', 'Auth@logout', 'get');

Route::add('/registration', 'Auth@showRegistration', 'get');
Route::add('/registration', 'Auth@registration', 'post');

Route::add('/tasks', 'Task@getAllTasks', 'get');
Route::add('/tasks/cretae', 'Task@showCreateTask', 'get');
Route::add('/tasks/create', 'Task@createTask', 'post');
Route::add('/tasks/([0-9]*)/update', 'Task@showUpdateTask', 'get');
Route::add('/tasks/([0-9]*)/update', 'Task@updateTask', 'post');
Route::add('/tasks/([0-9]*)/delete', 'Task@deleteTask', 'delete');

?>
