<?php
    require_once '../Entidades/Personas.php';
    // Set CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    $datos = json_decode(file_get_contents('php://input'));
 
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $findId = isset($_GET['findId'])? $_GET['findId']: null;
            if($findId != NULL) { 
                echo json_encode(Personas::getWhere($findId)); 
            }
            else { 
                echo json_encode(Personas::getAll()); 
            }
            break;

        case 'POST':
            if(Personas::insert($datos->identificacion, $datos->nombre, $datos->apellido, $datos->tipo_identificacion, $datos->profesion)) {
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;

        case 'PUT':
                if(Personas::update($datos->identificacion, $datos->nombre, $datos->apellido, $datos->tipo_identificacion, $datos->profesion)) {
                    http_response_code(200);
                } else { http_response_code(400); }
            break;

        case 'DELETE':
            if(Personas::delete($datos->identificacion)) { http_response_code(200); }
            else { http_response_code(400); }
            break;
        
        default:
            http_response_code(405);
            break;
    }
?>