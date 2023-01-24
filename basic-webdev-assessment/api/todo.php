<?php
try {
    require_once("todo.controller.php");
    
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode( '/', $uri);
    $requestType = $_SERVER['REQUEST_METHOD'];
    $body = file_get_contents('php://input');
    $pathCount = count($path);

    $controller = new TodoController();
    
    switch($requestType) {
        case 'GET':
            if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
                $id = $path[$pathCount - 1];
                $todo = $controller->load($id);
                if ($todo) {
                    http_response_code(200);
                    die(json_encode($todo));
                }
                http_response_code(404);
                die();
            } else {
                http_response_code(200);
                die(json_encode($controller->loadAll()));
            }
            break;
        case 'POST':
            //implement your code here
			 $todo = $_POST;
			 if (empty($todo)) // implemented if statement that checks if object $todo does not contain an values if that's true then its runs code 404 and die 
			 {
                http_response_code(404);
                die();
            } else {// else statement runs only if the object &todo does  contain any values then, its calls the function Create implemented on the controller and then after its run code 200
				$controller->create($todo)
                http_response_code(200);
                die();
            }
            break;
        case 'PUT':
            //implement your code here
			$todo = $_POST;
			$id = $path[$pathCount - 1]
			//$id = $request->getQueryParam('id'); in case if one choose to get id by parameter(they use this method, at this i followed your implementation for consistance)
			 if (empty($todo))  {
               //// implemented if statement that checks if object $todo does not contain an values if that's true then its runs code 404 and die
                http_response_code(404);
                die();
            } else {
				// else statement runs if object &todo does  contain any values then, its calls the function update implemented on the controller and run code 200
				$controller->update($id,$todo)
                http_response_code(200);
                die();
            }
            break;
        case 'DELETE':
            //implement your code here
			$id = $path[$pathCount - 1]
			//$id = $request->getQueryParam('id'); in case if one choose to get id by parameter(they use this method, at this i followed your implementation for consistance)
			 if (empty($id))  {
                //// implemented if statement that checks if object $id does not contain an values if that's true then its runs code 404 and die
                http_response_code(404);
                die();
            } else {
				// else statement runs if object $id  does  contain any values then, its calls the function delete implemented on the controller and run code 200
				$controller->delete($id)//im passing id as function parameter,as expeted on the controller
                http_response_code(200);
                die();
            }
            break;
        default:
            http_response_code(501);
            die();
            break;
    }
} catch(Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die();
}
