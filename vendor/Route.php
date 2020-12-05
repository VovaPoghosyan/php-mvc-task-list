<?PHP

class Route
{

  private static $routes = Array();

  /**
    * Function used to add a new route
    * @param string $expression    Route string or expression
    * @param string $name    Controller@actionName
    * @param string|array $method  Either a string of allowed method or an array with string values
    *
    */
  public static function add($expression, $name, $method = 'get')
  {
    array_push(self::$routes,Array(
      'expression' => $expression,
      'name'       => $name,
      'method'     => $method
    ));
  }

  public static function run($basepath = '/', $case_matters = false, $trailing_slash_matters = false)
  {
    // Parse current url
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

    if(isset($parsed_url['path']) && $parsed_url['path'] != '/'){
	  if($trailing_slash_matters){
		  $path = $parsed_url['path'];
	  } else {
		  $path = rtrim($parsed_url['path'], '/');
	  }
    } else {
      $path = '/';
    }

    // Get current request method
    $method = $_SERVER['REQUEST_METHOD'];

    foreach(self::$routes as $route){

      // If the method matches check the path

      // Add basepath to matching string
      if($basepath!=''&&$basepath!='/'){
        $route['expression'] = '('.$basepath.')'.$route['expression'];
      }

      // Add 'find string start' automatically
      $route['expression'] = '^'.$route['expression'];

      // Add 'find string end' automatically
      $route['expression'] = $route['expression'].'$';

      // echo $route['expression'].'<br/>';

      // Check path match
      if(preg_match('#'.$route['expression'].'#'.($case_matters ? '':'i'),$path,$matches)){

        // Cast allowed method to array if it's not one already, then run through all methods
        foreach ((array)$route['method'] as $allowedMethod) {
            // Check method match
            if(strtolower($method) == strtolower($allowedMethod)){

                array_shift($matches);// Always remove first element. This contains the whole string

                if($basepath!=''&&$basepath!='/'){
                    array_shift($matches);// Remove basepath
                }
                
                $url_parts = explode("@", $route['name']);
                self::runAction(
                  isset($url_parts[0]) ? $url_parts[0] : "IndexController",
                  isset($url_parts[1]) ? $url_parts[1] : "index",
                  $matches
                );

                // Do not check other routes
                break;
            }
        }
      }
    }

  }

  public static function runAction($controller, $action, $matches)
  {
    $controller_name = ucfirst(strtolower($controller)) . "Controller";
        $controller_file = $controller_name . ".php";

        if (file_exists(CONTROLLERS . $controller_file)) {
            include(CONTROLLERS . $controller_file);
            if (class_exists($controller_name)) {
                $current_controllet = new $controller_name;
                $current_action = $action . "Action";
                if (method_exists($current_controllet, $current_action)) {
                    $current_controllet->$current_action(...$matches);
                } else {
                    try {
                        throw new Exception($controller_name . " Class does not have action " . $current_action, 404);
                    } catch (Exception $e) {
                        echo "Message: " . $e->getMessage();
                    }
                }
            } else {
                try {
                    throw new Exception($controller_name . " Class is not found ", 404);
                } catch (Exception $e) {
                    echo "Message: " . $e->getMessage();
                }
            }
        } else {
            try {
                throw new Exception($controller_file . " is not found", 404);
            } catch (Exception $e) {
                echo "Message: " . $e->getMessage();
            }
        }
  }

}
