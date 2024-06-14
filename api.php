<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

define("ROOT_DIR", dirname(__FILE__));
define("PRIVATE_DIR", ROOT_DIR . "/private/");
define("PUBLIC_DIR", ROOT_DIR . "/public/");


require_once PRIVATE_DIR . 'config/config.php';

//get Utility
require_once PRIVATE_DIR . '/utility.php';
require_once PRIVATE_DIR . '/database.php';

$db = new ADEJ1R\Database();

$fullClassName = APP_NAMESPACE . "\\Utility";
$utility = $fullClassName::getInstance();

function sendJSON($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function sendData($data, $defaultStatus = 200) {
    if (!is_array($data)) {
        sendJSON([$data]);
    } elseif (array_key_exists("status", $data)) {
        sendJSON($data["message"], $data["status"]);
    } else {
        sendJSON($data, $defaultStatus);
    }
}

$method = $_SERVER['REQUEST_METHOD'];
$path_info = array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '';
if ($path_info) {
    $uri = explode('/', trim($_SERVER['PATH_INFO'] || '', '/'));
    $id = isset($uri[0]) && is_numeric($uri[0]) ? (int)$uri[0] : null;
} else {
    $uri = null;
    $id = null;
}

switch ($method) {
    case 'OPTIONS':
        http_response_code(200);
        exit;
    case 'GET':
        if ($id !== null) {
            api_sendSingleRecord($id);
        } else {
            api_sendAllRecords();
        }
        break;
    case 'POST':
        api_createRecord();
        break;
    case 'PUT':
       api_updateRecord($id);
        break;
    case 'DELETE':
        api_deleteRecord($id);
        break;
    default:
        // Nem támogatott metódus
        sendJSON(['message' => 'Nem támogatott metódus'], 405);
        break;
}


function api_parseBody() {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        var_dump(json_last_error());
        $error = ["message" => "A bejövő adatok értelmezése sikertelen"];
        sendJSON($error, 400);
        die();
    }

    //kulcsok kisbetűsre!!
    $input = array_change_key_case($input, CASE_LOWER);

    if (array_key_exists("id", $input)) {
        unset($input["id"]);
    }
    return $input;
}

function api_sendSingleRecord($id) {
    global $db;
    $item = $db->getSingleRecord($id);
    if (is_null($item)) {
        sendJSON([], 404);
    } else {
        sendData($item);
    }
}

function api_sendAllRecords() {
    global $db;
    //összes elem
    $items = $db->getAllRecords();
    sendData($items);
}

function api_createRecord() {
    global $db;
    global $utility;
    // Új elem létrehozása
    $newRecord = api_parseBody();

    $errors = $utility->validate_input($newRecord);
    if ($errors !== "") {
        sendJSON(["message" => $errors], 400);
        return;
    }
    $item = $db->insertRecord($newRecord);
    sendData($item, 201);
}

function api_updateRecord($id) {
    global $db;
    global $utility;

    if (is_numeric($id)) {
        $updatedRecord = api_parseBody();
        $errors = $utility->validate_input($updatedRecord);
        if ($errors !== "") {
            sendJSON(["message" => $errors], 400);
            return;
        }
        $response = $db->updateRecord($id, $updatedRecord);
        sendData($response, 204);
    } else {
        sendJSON(['message' => 'ID szükséges a frissítéshez'], 400);
    }
}

function api_deleteRecord($id) {
    global $db;
    global $utility;

    if (is_numeric($id)) {
        $response = $db->deleteRecord($id);
        sendData($response, 204);
    } else {
        sendJSON(['message' => 'ID szükséges a törléshez'], 400);
    }
}