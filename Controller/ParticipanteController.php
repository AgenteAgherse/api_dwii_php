<?php
    require_once '../Entidades/Participante.php';
    $datos = json_decode(file_get_contents('php://input'));
    if ($datos == NULL && $_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(400);
    }
    else {
        header('Content-type:application/json;charset=utf-8');
        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':
                if($datos != NULL) { 
                    echo json_encode(Participante::getWhere($datos->idparticipante)); 
                }
                else { 
                    echo json_encode(Participante::getAll()); 
                }
                break;

            case 'POST':
                if(Participante::insert(
                $datos->compromiso,
                $datos->participante)) {
                    http_response_code(200);
                }
                else {
                    http_response_code(400);
                }
                break;
    
            case 'PUT':
                    http_response_code(404);
                break;

            case 'DELETE':
                if(Participante::delete($datos->idparticipante)) { http_response_code(200); }
                else { http_response_code(400); }
                break;
            
            default:
                http_response_code(405);
                break;
        }
    }
?>