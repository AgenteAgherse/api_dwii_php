<?php
    require_once '../Entidades/Acta.php';
    $datos = json_decode(file_get_contents('php://input'));
    if ($datos == NULL && $_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(400);
    }
    else {
        header('Content-type:application/json;charset=utf-8');
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
    }
?>