<?php
    require_once '../Entidades/Personas.php';
    $datos = json_decode(file_get_contents('php://input'));
    if ($datos == NULL && $_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(400);
    }
    else {
        header('Content-type:application/json;charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':

                if($datos != NULL) { 
                    echo json_encode(Personas::getWhere($datos->identificacion)); 
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
    }
?>