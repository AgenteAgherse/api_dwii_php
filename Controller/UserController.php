<?php
    require_once '../Entidades/User.php';
    $datos = json_decode(file_get_contents('php://input'));
    // Generación de Headers
    if ($datos == NULL && $_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(400);
    }
    else {
        header('Content-type:application/json;charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        //header("Access-Control-Allow-Headers: Content-Type, Authorization");
        
        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':
                $findUser = $_GET['findUser'];
                if ($findUser != NULL) {
                    echo json_encode(User::findUser($findUser));
                }
                break;
            case 'POST':
                $login = $_GET['login'];
                if ($login != NULL) {
                    echo json_encode(User::getWhere($datos->user, $datos->password));
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