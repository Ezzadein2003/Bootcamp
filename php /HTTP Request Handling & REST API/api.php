
<?php

header("Content-Type: application/json");

$users = [
    ["id" => 1, "name" => "Ahmed"],
    ["id" => 2, "name" => "Ali"]
];

$method = $_SERVER["REQUEST_METHOD"];

$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    case "GET":

        echo json_encode([
            "status" => "success",
            "users" => $users
        ]);

        break;


    case "POST":

        if (!isset($input["name"]) || trim($input["name"]) === "") {
            http_response_code(400);

            echo json_encode([
                "error" => "Name is required"
            ]);

            break;
        }

        $new_user = [
            "id" => count($users) + 1,
            "name" => $input["name"]
        ];

        $users[] = $new_user;

        http_response_code(201);

        echo json_encode([
            "status" => "User added",
            "user" => $new_user
        ]);

        break;


    case "PUT":

        echo json_encode([
            "status" => "PUT request received"
        ]);

        break;


    case "DELETE":

        echo json_encode([
            "status" => "DELETE request received"
        ]);

        break;


    default:

        http_response_code(405);

        echo json_encode([
            "error" => "Method not allowed"
        ]);

        break;
}

?>
