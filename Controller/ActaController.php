<?php
    require_once '../Entidades/Acta.php';
    $datos = json_decode(file_get_contents('php://input'));

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
            if($datos != NULL) { 
                echo json_encode(Acta::getWhere($datos->idacta)); 
            }
            else { 
                echo json_encode(Acta::getAll()); 
            }
            break;

        case 'POST':
            if(Acta::insert(
            $datos->pertenece, 
            $datos->fecha, 
            $datos->hora, 
            $datos->lugar_emision, 
            $datos->descripcion)) {
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;

        case 'PUT':
                if(Acta::update($datos->idacta,                    
                $datos->pertenece, 
                $datos->fecha, 
                $datos->hora, 
                $datos->lugar_emision, 
                $datos->descripcion)) {
                    http_response_code(200);
                } else { http_response_code(400); }
            break;

        case 'DELETE':
            if(Acta::delete($datos->idacta)) { http_response_code(200); }
            else { http_response_code(400); }
            break;
        
        default:
            http_response_code(405);
            break;
    }
?>