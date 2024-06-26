<?php
    require_once '../Entidades/Acta.php';
    require_once '../Database/Encryptation.php';
    $datos = json_decode(file_get_contents('php://input'));


    // Set CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    $datos = json_decode(file_get_contents('php://input'));
 
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $userData = JWTdata::validateJWT($token);
        if ($userData) {
            $id = $userData['sub'];
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            exit();
        }
    }
    else {
        http_response_code(401);
        exit();
    }
    

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            if(isset($_GET['compromiso'])) { 
                echo json_encode(Acta::getWhere($_GET['compromiso'])); 
            }
            else if(isset($_GET['actas_hechas'])) {
                echo json_encode(Acta::obtenerActasHechas($id));
            }
            else if(isset($_GET['buscar_acta'])) {
                $acta = $_GET['buscar_acta'];
                echo json_encode(Acta::buscarActa($id, $acta));
            }
            else if(isset($_GET['buscar_titulo'])) {
                $titulo = $_GET['buscar_titulo'];
                echo json_encode(Acta::buscarPorTitulo($id, $titulo));
            }
            else { 
                echo json_encode(Acta::getAll()); 
            }
            break;

        case 'POST':
            if(Acta::insert(
            $datos->pertenece, 
            $datos->titulo,
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
    }
?>