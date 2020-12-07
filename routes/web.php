<?PHP

// Define base route
Route::add('/', 'Index@index', 'get');

Route::add('/login', 'Auth@showLogin', 'get');
Route::add('/login', 'Auth@login', 'post');

Route::add('/registration', 'Auth@showRegistration', 'get');
Route::add('/registration', 'Auth@registration', 'post');

Route::add('/profile', 'Index@index', 'get');

?>
