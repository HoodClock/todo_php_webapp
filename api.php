<!-- Endpoint (express routes) [GET, POST] -->
<!-- it recives a json data from (frontend aka client aka html) and talk to the php class -->

<?php
header("Content-Type: application/json; charset=UTF-8");
include_once 'db.php';
include_once 'Todo.php';

$database = new Database();
$db = $database->getConnection();
$todo = new Todo($db);

// Check HTTP Method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $todo->read();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}

elseif ($method === 'POST') {
    // Read raw input (for JSON body)
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->title)) {
        if($todo->create($data->title)) {
            echo json_encode(["message" => "Task created."]);
        } else {
            echo json_encode(["message" => "Unable to create task."]);
        }
    }
}

elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->id)) {
        if($todo->delete($data->id)) {
            echo json_encode(["message" => "Task deleted."]);
        } else {
            echo json_encode(["message" => "Unable to delete task."]);
        }
    }
}
?>