<?php
    require_once '../Entidades/Compromiso.php';
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
                echo json_encode(Compromiso::getWhere($datos->idcompromiso)); 
            }
            else { 
                echo json_encode(Compromiso::getAll()); 
            }
            break;

        case 'POST':
            if(Compromiso::insert(
            $datos->organizador, 
            $datos->fecha_inicio, 
            $datos->fecha_fin, 
            $datos->hora_inicio, 
            $datos->hora_fin, 
            $datos->titulo, 
            $datos->descripcion, 
            $datos->lugar, 
            $datos->modalidad, 
            $datos->capacidad)) {
                http_response_code(200);
            }
            else {
                http_response_code(400);
            }
            break;

        case 'PUT':
                if(Compromiso::update($datos->idcompromiso, 
                $datos->organizador, 
                $datos->fecha_inicio, 
                $datos->fecha_fin, 
                $datos->hora_inicio, 
                $datos->hora_fin, 
                $datos->titulo, 
                $datos->descripcion, 
                $datos->lugar, 
                $datos->modalidad, 
                $datos->capacidad)) {
                    http_response_code(200);
                } else { http_response_code(400); }
            break;

        case 'DELETE':
            if(Compromiso::delete($datos->idcompromiso)) { http_response_code(200); }
            else { http_response_code(400); }
            break;
        
        default:
            http_response_code(405);
            break;
    }
?>